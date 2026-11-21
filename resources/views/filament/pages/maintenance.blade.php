<x-filament-panels::page>
    <div class="space-y-6">
        <x-filament::section
            icon="heroicon-m-command-line"
            icon-color="primary"
        >
            <x-slot name="heading">
                Run Artisan Command
            </x-slot>

            <x-slot name="description">
                Choose a maintenance command from the list and configure its options before running.
            </x-slot>

            <form wire:submit="execute" class="space-y-6">
                {{ $this->form }}

                <div class="flex items-center gap-3">
                    <x-filament::button
                        type="submit"
                        icon="heroicon-m-play"
                        :color="in_array($data['command'] ?? '', ['rollback', 'migrate-fresh'], true) ? 'danger' : 'primary'"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove wire:target="execute">Run Command</span>
                        <span wire:loading wire:target="execute">Running...</span>
                    </x-filament::button>
                </div>
            </form>
        </x-filament::section>

        @if ($lastCommand !== null)
            <x-filament::section
                :icon="$lastSuccess ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle'"
                :icon-color="$lastSuccess ? 'success' : 'danger'"
            >
                <x-slot name="heading">
                    Output: php artisan {{ $lastCommand }}
                </x-slot>

                <x-slot name="headerEnd">
                    <x-filament::button
                        type="button"
                        size="sm"
                        color="gray"
                        icon="heroicon-m-clipboard-document"
                        x-data="{ copied: false }"
                        x-on:click="navigator.clipboard.writeText($refs.commandOutput.innerText); copied = true; setTimeout(() => copied = false, 2000)"
                    >
                        <span x-show="!copied">Copy Output</span>
                        <span x-show="copied" x-cloak>Copied!</span>
                    </x-filament::button>
                </x-slot>

                <pre x-ref="commandOutput" class="overflow-x-auto rounded-lg bg-gray-950 p-4 text-xs font-mono text-gray-100 whitespace-pre-wrap">{{ $lastOutput }}</pre>
            </x-filament::section>
        @endif
    </div>
</x-filament-panels::page>
