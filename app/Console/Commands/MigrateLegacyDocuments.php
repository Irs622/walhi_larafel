<?php

namespace App\Console\Commands;

use App\Models\Content;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrateLegacyDocuments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'walhi:migrate-documents {--delete-legacy : Delete legacy files from public storage after successful copy}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate legacy documents from public storage to private storage and normalize database records';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting legacy document migration to private storage...');

        $publicDisk = Storage::disk('public');
        $localDisk = Storage::disk('local');

        $migratedCount = 0;
        $dbUpdatedCount = 0;

        // 1. Scan files in public disk 'documents/' folder
        if ($publicDisk->exists('documents')) {
            $files = $publicDisk->files('documents');
            $this->info(sprintf('Found %d file(s) in public/documents.', count($files)));

            foreach ($files as $publicPath) {
                $filename = basename($publicPath);
                $privatePath = 'documents/'.$filename;

                // Ensure documents directory exists in private storage
                if (! $localDisk->exists('documents')) {
                    $localDisk->makeDirectory('documents');
                }

                // Copy file to local private storage
                $content = $publicDisk->get($publicPath);
                if ($content !== null) {
                    $localDisk->put($privatePath, $content);
                    $migratedCount++;

                    if ($this->option('delete-legacy')) {
                        $publicDisk->delete($publicPath);
                        $this->line("  [MIGRATED & REMOVED] {$filename}");
                    } else {
                        $this->line("  [COPIED] {$filename}");
                    }
                }
            }
        } else {
            $this->info('No public documents folder found on public disk.');
        }

        // 2. Normalize database records
        $legacyContents = Content::whereNotNull('image_url')
            ->where(function ($q) {
                $q->where('image_url', 'like', '/storage/documents/%')
                    ->orWhere('image_url', 'like', 'storage/documents/%');
            })
            ->get();

        foreach ($legacyContents as $item) {
            $raw = (string) $item->getRawOriginal('image_url');
            $cleanFilename = basename($raw);
            $normalizedPath = 'documents/'.$cleanFilename;

            $item->image_url = $normalizedPath;
            $item->saveQuietly();
            $dbUpdatedCount++;
        }

        $this->info("Migration completed successfully!");
        $this->info("Files copied to private storage: {$migratedCount}");
        $this->info("Database records normalized: {$dbUpdatedCount}");

        return Command::SUCCESS;
    }
}
