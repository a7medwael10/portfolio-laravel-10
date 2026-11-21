<x-filament-panels::page>
    <div class="space-y-6">
        <x-filament::section
            icon="heroicon-m-command-line"
            icon-color="primary"
        >
            <x-slot name="heading">
                Artisan Maintenance Commands
            </x-slot>

            <x-slot name="description">
                Run Artisan commands from the dashboard when SSH / terminal access is unavailable on the server.
            </x-slot>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-xl border border-gray-200 dark:border-gray-800 p-4 space-y-2">
                    <h3 class="text-sm font-semibold text-gray-950 dark:text-white">Database</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Use <strong>Run Migrate</strong> after deploying new migrations, or <strong>Run Seed</strong> to seed data.
                    </p>
                </div>

                <div class="rounded-xl border border-gray-200 dark:border-gray-800 p-4 space-y-2">
                    <h3 class="text-sm font-semibold text-gray-950 dark:text-white">Cache &amp; Optimization</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Use <strong>Optimize Clear</strong> to clear config, route, view, and application caches.
                    </p>
                </div>

                <div class="rounded-xl border border-gray-200 dark:border-gray-800 p-4 space-y-2">
                    <h3 class="text-sm font-semibold text-gray-950 dark:text-white">Queues</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Use <strong>Queue Work</strong> to process pending jobs once, or <strong>Queue Restart</strong> to restart workers.
                    </p>
                </div>

                <div class="rounded-xl border border-gray-200 dark:border-gray-800 p-4 space-y-2">
                    <h3 class="text-sm font-semibold text-gray-950 dark:text-white">Storage</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Use <strong>Storage Link</strong> if symlinks are supported on your hosting environment.
                    </p>
                </div>
            </div>
        </x-filament::section>

        @if ($lastCommand !== null)
            <x-filament::section
                :icon="$lastSuccess ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle'"
                :icon-color="$lastSuccess ? 'success' : 'danger'"
            >
                <x-slot name="heading">
                    Output: php artisan {{ $lastCommand }}
                </x-slot>

                <pre class="overflow-x-auto rounded-lg bg-gray-950 p-4 text-xs font-mono text-gray-100 whitespace-pre-wrap">{{ $lastOutput }}</pre>
            </x-filament::section>
        @endif
    </div>
</x-filament-panels::page>
