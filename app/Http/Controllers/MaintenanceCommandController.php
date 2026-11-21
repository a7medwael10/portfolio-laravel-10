<?php

namespace App\Http\Controllers;

use Illuminate\Database\Seeder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MaintenanceCommandController extends Controller
{
    public function __invoke(Request $request, string $command): JsonResponse
    {
        $seederClass = null;

        if ($command === 'seed') {
            $seederClass = $this->resolveSeederClass(
                $request->validate([
                    'seeder' => [
                        'nullable',
                        'string',
                        'regex:/^[A-Za-z_][A-Za-z0-9_]*$/',
                    ],
                ])['seeder'] ?? null
            );
        }

        [$artisanCommand, $parameters] = match ($command) {
            'migrate' => ['migrate', ['--force' => true]],
            'migrate-fresh' => ['migrate:fresh', ['--force' => true]],
            'rollback' => ['migrate:rollback', ['--force' => true]],
            'seed' => ['db:seed', array_filter([
                '--class' => $seederClass,
                '--force' => true,
            ], static fn (mixed $value): bool => $value !== null)],
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
            default => throw new HttpException(422, 'Unsupported maintenance command.'),
        };

        $exitCode = Artisan::call($artisanCommand, $parameters);
        $output = trim(Artisan::output());

        if ($exitCode !== 0) {
            return response()->json([
                'success' => false,
                'message' => "The {$artisanCommand} command failed.",
                'errors' => ['output' => $output],
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => "The {$artisanCommand} command completed successfully.",
            'data' => [
                'command' => $artisanCommand,
                'seeder' => $seederClass,
                'output' => $output,
            ],
        ]);
    }

    /** @return class-string<Seeder>|null */
    private function resolveSeederClass(?string $seeder): ?string
    {
        if ($seeder === null) {
            return null;
        }

        $class = "Database\\Seeders\\{$seeder}";

        if (! class_exists($class) || ! is_subclass_of($class, Seeder::class)) {
            throw ValidationException::withMessages([
                'seeder' => ['The selected seeder does not exist.'],
            ]);
        }

        return $class;
    }
}
