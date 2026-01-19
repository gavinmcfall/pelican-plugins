<?php

declare(strict_types=1);

namespace Starter\ServerDocumentation\Policies;

use App\Models\Server;
use App\Models\User;
use Starter\ServerDocumentation\Models\Document;

class DocumentPolicy
{
    /**
     * Intercept all authorization checks.
     * Root admins have full access to admin panel document operations.
     *
     * Note: viewOnServer is excluded because it has server-specific visibility
     * logic that should still apply (root admins see all docs on visible servers,
     * but documents must still be visible on the server itself).
     *
     * Returns:
     * - true: Allow (root admin for admin panel operations)
     * - null: Defer to specific policy method
     */
    public function before(User $user, string $ability): ?bool
    {
        // viewOnServer has its own root admin handling with server visibility checks
        if ($ability === 'viewOnServer') {
            return null;
        }

        if ($user->isRootAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Admin panel: Can user view documents list?
     * Uses Pelican's space-separated permission pattern.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewList document');
    }

    /**
     * Admin panel: Can user view a specific document?
     */
    public function view(User $user, Document $document): bool
    {
        return $user->can('view document');
    }

    /**
     * Admin panel: Can user create documents?
     */
    public function create(User $user): bool
    {
        return $user->can('create document');
    }

    /**
     * Admin panel: Can user update documents?
     */
    public function update(User $user, Document $document): bool
    {
        return $user->can('update document');
    }

    /**
     * Admin panel: Can user delete documents?
     */
    public function delete(User $user, Document $document): bool
    {
        return $user->can('delete document');
    }

    /**
     * Admin panel: Can user restore soft-deleted documents?
     */
    public function restore(User $user, Document $document): bool
    {
        return $user->can('delete document');
    }

    /**
     * Admin panel: Can user permanently delete documents?
     */
    public function forceDelete(User $user, Document $document): bool
    {
        return $user->can('delete document');
    }

    /**
     * Server panel: Can user view this document on a specific server?
     *
     * Visibility is determined by:
     * 1. Server visibility: Is the document global, attached to this server, or attached to this server's egg?
     * 2. Person visibility: Does the user have access based on roles/users restrictions?
     *
     * Uses the Document model's visibility helper methods to avoid logic duplication.
     */
    public function viewOnServer(User $user, Document $document, Server $server): bool
    {
        // 1. Server visibility check (using model helper)
        if (!$document->isVisibleOnServer($server)) {
            return false;
        }

        // 2. Root admin bypass - can see all documents on visible servers
        if ($user->isRootAdmin()) {
            return true;
        }

        // 3. Must be published for non-admins
        if (!$document->is_published) {
            return false;
        }

        // 4. Person visibility check (using model helper)
        return $document->isVisibleToUser($user);
    }
}
