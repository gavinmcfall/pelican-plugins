<div class="prose prose-sm dark:prose-invert max-w-none">
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
        {{ trans('server-documentation::strings.permission_guide.intro') }}
    </p>

    <h4 class="text-sm font-medium text-gray-900 dark:text-white mt-4 mb-2">
        {{ trans('server-documentation::strings.visibility.server') }}
    </h4>
    <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">
        {{ trans('server-documentation::strings.permission_guide.server_description') }}
    </p>
    <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1 list-disc list-inside mb-4">
        <li><strong>{{ trans('server-documentation::strings.labels.all_servers') }}</strong> &mdash; {{ trans('server-documentation::strings.permission_guide.all_servers_desc') }}</li>
        <li><strong>{{ trans('server-documentation::strings.labels.eggs') }}</strong> &mdash; {{ trans('server-documentation::strings.permission_guide.eggs_desc') }}</li>
        <li><strong>{{ trans('server-documentation::strings.form.assign_to_servers') }}</strong> &mdash; {{ trans('server-documentation::strings.permission_guide.servers_desc') }}</li>
    </ul>

    <h4 class="text-sm font-medium text-gray-900 dark:text-white mt-4 mb-2">
        {{ trans('server-documentation::strings.visibility.person') }}
    </h4>
    <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">
        {{ trans('server-documentation::strings.permission_guide.person_description') }}
    </p>
    <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1 list-disc list-inside mb-4">
        <li><strong>{{ trans('server-documentation::strings.labels.roles') }}</strong> &mdash; {{ trans('server-documentation::strings.permission_guide.roles_desc') }}</li>
        <li><strong>{{ trans('server-documentation::strings.labels.users') }}</strong> &mdash; {{ trans('server-documentation::strings.permission_guide.users_desc') }}</li>
        <li><strong>{{ trans('server-documentation::strings.visibility.everyone') }}</strong> &mdash; {{ trans('server-documentation::strings.permission_guide.everyone_desc') }}</li>
    </ul>

    <p class="text-xs text-gray-400 dark:text-gray-500 mt-4">
        {{ trans('server-documentation::strings.permission_guide.admin_note') }}
    </p>
</div>
