<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Throwable;

class Maintenance extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Maintenance';

    protected static ?string $title = 'Server Maintenance';

    protected static ?int $navigationSort = 99;

    protected static string $view = 'filament.pages.maintenance';

    public ?string $lastCommand = null;

    public ?string $lastOutput = null;

    public ?bool $lastSuccess = null;

    public function runCommand(string $command, array $parameters = []): void
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

    protected function getHeaderActions(): array
    {
        return [
            Action::make('migrate')
                ->label('Run Migrate')
                ->icon('heroicon-m-circle-stack')
                ->color('primary')
                ->requiresConfirmation()
                ->modalDescription('Run pending database migrations with --force.')
                ->action(fn () => $this->runCommand('migrate', ['--force' => true])),

            Action::make('optimizeClear')
                ->label('Optimize Clear')
                ->icon('heroicon-m-sparkles')
                ->color('info')
                ->action(fn () => $this->runCommand('optimize:clear')),

            Action::make('seed')
                ->label('Run Seed')
                ->icon('heroicon-m-beaker')
                ->color('warning')
                ->form([
                    TextInput::make('seeder')
                        ->label('Seeder Class (Optional)')
                        ->placeholder('DatabaseSeeder')
                        ->helperText('Leave empty to run DatabaseSeeder, or enter class name under Database\\Seeders\\.'),
                ])
                ->action(function (array $data): void {
                    $seeder = trim((string) ($data['seeder'] ?? ''));

                    if ($seeder !== '') {
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

                    $this->runCommand('db:seed', ['--force' => true]);
                }),

            Action::make('storageLink')
                ->label('Storage Link')
                ->icon('heroicon-m-link')
                ->color('gray')
                ->action(fn () => $this->runCommand('storage:link')),

            Action::make('queueWork')
                ->label('Queue Work')
                ->icon('heroicon-m-play')
                ->color('success')
                ->action(fn () => $this->runCommand('queue:work', [
                    '--stop-when-empty' => true,
                    '--tries' => 1,
                    '--timeout' => 30,
                    '--sleep' => 1,
                ])),

            Action::make('queueRestart')
                ->label('Queue Restart')
                ->icon('heroicon-m-arrow-path')
                ->color('gray')
                ->action(fn () => $this->runCommand('queue:restart')),

            Action::make('rollback')
                ->label('Rollback')
                ->icon('heroicon-m-arrow-uturn-left')
                ->color('danger')
                ->requiresConfirmation()
                ->modalDescription('This will roll back the last batch of migrations on the server.')
                ->action(fn () => $this->runCommand('migrate:rollback', ['--force' => true])),

            Action::make('migrateFresh')
                ->label('Migrate Fresh')
                ->icon('heroicon-m-exclamation-triangle')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Drop all tables and re-run migrations?')
                ->modalDescription('WARNING: This permanently deletes all database data and recreates all tables.')
                ->action(fn () => $this->runCommand('migrate:fresh', ['--force' => true])),
        ];
    }
}
