<?php

declare(strict_types=1);

namespace Starter\ServerDocumentation\Policies;

use App\Models\User;
use Starter\ServerDocumentation\Models\DocumentVersion;

/**
 * Policy for DocumentVersion model.
 *
 * Version access is tied to the parent Document - if a user can access
 * the document, they can view its versions. Modification of versions
 * (restore) requires document update permissions.
 */
class DocumentVersionPolicy
{
    /**
     * Can user view version history?
     * Requires view permission on the parent document.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view document');
    }

    /**
     * Can user view a specific version?
     * Requires view permission on the parent document.
     */
    public function view(User $user, DocumentVersion $version): bool
    {
        return $user->can('view document');
    }

    /**
     * Can user restore a version?
     * Requires update permission on the parent document.
     */
    public function restore(User $user, DocumentVersion $version): bool
    {
        return $user->can('update document');
    }

    /**
     * Versions are created automatically by the system.
     * Manual creation is not allowed.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Versions are immutable after creation.
     */
    public function update(User $user, DocumentVersion $version): bool
    {
        return false;
    }

    /**
     * Versions should not be deleted individually.
     * Use version pruning instead.
     */
    public function delete(User $user, DocumentVersion $version): bool
    {
        return false;
    }
}
