<?php

declare(strict_types=1);

namespace Starter\ServerDocumentation\Services;

/**
 * Validates document data for import operations.
 */
class ImportValidator
{
    /**
     * Maximum content size in bytes (5MB).
     */
    private const MAX_CONTENT_SIZE = 5 * 1024 * 1024;

    /**
     * Valid content type values.
     */
    private const VALID_CONTENT_TYPES = ['html', 'markdown', 'raw_html'];

    /**
     * UUID v4 regex pattern.
     */
    private const UUID_PATTERN = '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i';

    /**
     * Validate a document from JSON import data.
     *
     * @param array<string, mixed> $docData
     * @return array<string> Array of validation errors, empty if valid
     */
    public function validate(array $docData): array
    {
        $errors = [];

        // Required fields
        if (!isset($docData['uuid']) || !is_string($docData['uuid']) || $docData['uuid'] === '') {
            $errors[] = 'Missing or invalid uuid';
        } elseif (!preg_match(self::UUID_PATTERN, $docData['uuid'])) {
            $errors[] = 'Invalid UUID format: ' . $docData['uuid'];
        }

        if (!isset($docData['title']) || !is_string($docData['title']) || $docData['title'] === '') {
            $errors[] = 'Missing or invalid title';
        } elseif (strlen($docData['title']) > 255) {
            $errors[] = 'Title exceeds 255 characters';
        }

        if (!isset($docData['content']) || !is_string($docData['content'])) {
            $errors[] = 'Missing or invalid content';
        }

        // Content size limit
        if (isset($docData['content']) && strlen($docData['content']) > self::MAX_CONTENT_SIZE) {
            $errors[] = 'Content exceeds 5MB size limit';
        }

        // Content type validation
        if (isset($docData['content_type']) && !in_array($docData['content_type'], self::VALID_CONTENT_TYPES, true)) {
            $errors[] = 'Invalid content_type: ' . $docData['content_type'] . ' (must be html, markdown, or raw_html)';
        }

        // Boolean fields
        if (isset($docData['is_global']) && !is_bool($docData['is_global'])) {
            $errors[] = 'is_global must be a boolean';
        }
        if (isset($docData['is_published']) && !is_bool($docData['is_published'])) {
            $errors[] = 'is_published must be a boolean';
        }

        // Integer fields
        if (isset($docData['sort_order']) && !is_int($docData['sort_order'])) {
            $errors[] = 'sort_order must be an integer';
        }

        return $errors;
    }
}
