<?php

declare(strict_types=1);

namespace Starter\ServerDocumentation\Services;

use App\Models\Server;
use App\Models\User;

/**
 * Processes template variables in document content.
 *
 * Supports variables like:
 * - {{user.name}}, {{user.email}}, {{user.id}}
 * - {{server.name}}, {{server.uuid}}, {{server.address}}, {{server.egg}}
 * - {{date}}, {{time}}, {{datetime}}
 */
class VariableProcessor
{
    /**
     * Available variables and their descriptions for documentation.
     *
     * @return array<string, string>
     */
    public static function getAvailableVariables(): array
    {
        return [
            // User variables
            '{{user.name}}' => 'Current user\'s display name',
            '{{user.username}}' => 'Current user\'s username',
            '{{user.email}}' => 'Current user\'s email address',
            '{{user.id}}' => 'Current user\'s ID',

            // Server variables (only available in server context)
            '{{server.name}}' => 'Server name',
            '{{server.uuid}}' => 'Server UUID',
            '{{server.id}}' => 'Server ID',
            '{{server.egg}}' => 'Server egg/game type name',
            '{{server.node}}' => 'Node name where server is hosted',
            '{{server.memory}}' => 'Allocated memory (MB)',
            '{{server.disk}}' => 'Allocated disk space (MB)',
            '{{server.cpu}}' => 'CPU limit percentage',

            // Date/time variables
            '{{date}}' => 'Current date (Y-m-d)',
            '{{time}}' => 'Current time (H:i)',
            '{{datetime}}' => 'Current date and time',
            '{{year}}' => 'Current year',
        ];
    }

    /**
     * Process all variables in content.
     */
    public function process(string $content, ?User $user = null, ?Server $server = null): string
    {
        // Process user variables
        $content = $this->processUserVariables($content, $user);

        // Process server variables
        $content = $this->processServerVariables($content, $server);

        // Process date/time variables
        $content = $this->processDateVariables($content);

        return $content;
    }

    /**
     * Process user-related variables.
     */
    protected function processUserVariables(string $content, ?User $user): string
    {
        if ($user === null) {
            $user = auth()->user();
        }

        if ($user === null) {
            // Replace with empty or placeholder if no user
            $replacements = [
                '{{user.name}}' => '',
                '{{user.username}}' => '',
                '{{user.email}}' => '',
                '{{user.id}}' => '',
            ];
        } else {
            $replacements = [
                '{{user.name}}' => e($user->name ?? $user->username),
                '{{user.username}}' => e($user->username),
                '{{user.email}}' => e($user->email),
                '{{user.id}}' => (string) $user->id,
            ];
        }

        return str_replace(array_keys($replacements), array_values($replacements), $content);
    }

    /**
     * Process server-related variables.
     */
    protected function processServerVariables(string $content, ?Server $server): string
    {
        if ($server === null) {
            // Replace with empty or placeholder if no server context
            $replacements = [
                '{{server.name}}' => '',
                '{{server.uuid}}' => '',
                '{{server.id}}' => '',
                '{{server.egg}}' => '',
                '{{server.node}}' => '',
                '{{server.memory}}' => '',
                '{{server.disk}}' => '',
                '{{server.cpu}}' => '',
            ];
        } else {
            $replacements = [
                '{{server.name}}' => e($server->name),
                '{{server.uuid}}' => e($server->uuid),
                '{{server.id}}' => (string) $server->id,
                '{{server.egg}}' => e($server->egg?->name ?? ''),
                '{{server.node}}' => e($server->node?->name ?? ''),
                '{{server.memory}}' => (string) ($server->memory ?? ''),
                '{{server.disk}}' => (string) ($server->disk ?? ''),
                '{{server.cpu}}' => (string) ($server->cpu ?? ''),
            ];
        }

        return str_replace(array_keys($replacements), array_values($replacements), $content);
    }

    /**
     * Process date/time variables.
     */
    protected function processDateVariables(string $content): string
    {
        $now = now();

        $replacements = [
            '{{date}}' => $now->format('Y-m-d'),
            '{{time}}' => $now->format('H:i'),
            '{{datetime}}' => $now->format('Y-m-d H:i'),
            '{{year}}' => $now->format('Y'),
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $content);
    }

    /**
     * Check if content contains any variables.
     */
    public function hasVariables(string $content): bool
    {
        return (bool) preg_match('/\{\{[a-z_.]+\}\}/i', $content);
    }

    /**
     * Extract all variables used in content.
     *
     * @return array<string>
     */
    public function extractVariables(string $content): array
    {
        preg_match_all('/\{\{([a-z_.]+)\}\}/i', $content, $matches);

        return array_unique($matches[0] ?? []);
    }
}
