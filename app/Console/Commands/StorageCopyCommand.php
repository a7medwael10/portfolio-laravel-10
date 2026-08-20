<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class StorageCopyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:copy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy files from storage/app/public directly to public/storage (useful for hosts like InfinityFree without symlink support)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $target = public_path('storage');
        $source = storage_path('app/public');

        if (!File::exists($source)) {
            $this->error("Source directory {$source} does not exist.");
            return 1;
        }

        // If target exists and is a symlink, delete the symlink first
        if (is_link($target)) {
            $this->info("Removing existing symlink at {$target}...");
            File::delete($target);
        }

        if (!File::exists($target)) {
            File::makeDirectory($target, 0755, true);
        }

        $this->info("Copying files from {$source} to {$target}...");
        File::copyDirectory($source, $target);

        $this->info("Files copied successfully to public/storage!");
        return 0;
    }
}
