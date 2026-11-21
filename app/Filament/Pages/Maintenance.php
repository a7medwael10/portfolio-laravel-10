<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Throwable;

class Maintenance extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Maintenance';

    protected static ?string $title = 'Server Maintenance';

    protected static ?int $navigationSort = 99;

    protected static string $view = 'filament.pages.maintenance';

    public ?array $data = [];

    public ?string $lastCommand = null;

    public ?string $lastOutput = null;

    public ?bool $lastSuccess = null;

    public function mount(): void
    {
        $this->form->fill([
            'command' => 'migrate',
            'seeder' => null,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('command')
                    ->label('Command')
                    ->options([
                        'migrate' => 'migrate — Run pending migrations',
                        'optimize-clear' => 'optimize:clear — Clear all caches',
                        'seed' => 'db:seed — Run database seeders',
                        'storage-link' => 'storage:link — Create storage symlink',
                        'queue-work' => 'queue:work — Process pending queue jobs',
                        'queue-restart' => 'queue:restart — Restart queue workers',
                        'rollback' => 'migrate:rollback — Rollback last migration batch',
                        'migrate-fresh' => 'migrate:fresh — Drop all tables & re-run migrations (DANGEROUS)',
                    ])
                    ->required()
                    ->live()
                    ->native(false),

                Select::make('seeder')
                    ->label('Seeder Class')
                    ->placeholder('All (DatabaseSeeder)')
                    ->options($this->availableSeeders())
                    ->visible(fn (Get $get): bool => $get('command') === 'seed')
                    ->helperText('Leave empty to run DatabaseSeeder, or select a specific seeder.')
                    ->native(false),
            ])
            ->statePath('data');
    }

    public function execute(): void
    {
        $state = $this->form->getState();
        $command = $state['command'] ?? null;

        if (! is_string($command) || $command === '') {
            Notification::make()->title('Please select a command')->danger()->send();

            return;
        }

        $seeder = $state['seeder'] ?? null;

        if ($command === 'seed' && is_string($seeder) && $seeder !== '') {
            if (! preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $seeder)) {
                Notification::make()->title('Invalid seeder class name')->danger()->send();

                return;
            }

            $class = "Database\\Seeders\\{$seeder}";
            if (! class_exists($class) || ! is_subclass_of($class, Seeder::class)) {
                Notification::make()->title("Seeder {$seeder} does not exist")->danger()->send();

                return;
            }

            $this->runCommand('db:seed', ['--class' => $class, '--force' => true]);

            return;
        }

        [$artisanCommand, $parameters] = match ($command) {
            'migrate' => ['migrate', ['--force' => true]],
            'migrate-fresh' => ['migrate:fresh', ['--force' => true]],
            'rollback' => ['migrate:rollback', ['--force' => true]],
            'seed' => ['db:seed', ['--force' => true]],
            'optimize-clear' => ['optimize:clear', []],
            'queue-work' => [
                'queue:work',
                [
                    '--stop-when-empty' => true,
                    '--tries' => 1,
                    '--timeout' => 30,
                    '--sleep' => 1,
                ],
            ],
            'queue-restart' => ['queue:restart', []],
            'storage-link' => ['storage:link', []],
            default => [null, []],
        };

        if ($artisanCommand === null) {
            Notification::make()->title('Unsupported command')->danger()->send();

            return;
        }

        $this->runCommand($artisanCommand, $parameters);
    }

    /**
     * @return array<string, string>
     */
    protected function availableSeeders(): array
    {
        $seedersPath = database_path('seeders');

        if (! File::isDirectory($seedersPath)) {
            return [];
        }

        $options = [];

        foreach (File::files($seedersPath) as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $name = $file->getFilenameWithoutExtension();
            $options[$name] = $name;
        }

        ksort($options);

        return $options;
    }

    protected function runCommand(string $command, array $parameters = []): void
    {
        try {
            $exitCode = Artisan::call($command, $parameters);
            $output = trim(Artisan::output());

            $this->lastCommand = $command;
            $this->lastOutput = $output !== '' ? $output : 'Command finished with no output.';
            $this->lastSuccess = $exitCode === 0;

            if ($exitCode === 0) {
                Notification::make()
                    ->title("Command `{$command}` completed")
                    ->success()
                    ->send();
            } else {
                Notification::make()
                    ->title("Command `{$command}` failed (exit {$exitCode})")
                    ->danger()
                    ->send();
            }
        } catch (Throwable $exception) {
            $this->lastCommand = $command;
            $this->lastOutput = $exception->getMessage();
            $this->lastSuccess = false;

            Notification::make()
                ->title("Command `{$command}` failed")
                ->body($exception->getMessage())
                ->danger()
                ->send();
        }
    }
}
