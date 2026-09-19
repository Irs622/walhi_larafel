<?php

namespace App\Console\Commands;

use App\Models\Content;
use Illuminate\Console\Command;

class FixEditorialTypos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'walhi:fix-typos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix known editorial typos in content titles and bodies across the database';

    /**
     * Known typo mapping: typo => correct.
     *
     * @var array<string, string>
     */
    private const TYPO_MAP = [
        'infomrasi' => 'informasi',
        'peternakkan' => 'peternakan',
        'katagori' => 'kategori',
        'dalalm' => 'dalam',
        'kirtis' => 'kritis',
        'menbelakangi' => 'membelakangi',
        'Kesekertariatan' => 'Kesekretariatan',
        'kesekertariatan' => 'kesekretariatan',
        'Kamis, (20/2/2024)' => 'Kamis, 20 Februari 2025',
        '(20/2/2024)' => '20 Februari 2025',
        'https://walhijabar.id/wp-content/uploads/' => '/storage/uploads/',
        'http://walhijabar.id/wp-content/uploads/' => '/storage/uploads/',
        'https://walhijabar.id/menyoal-kemitraan-transisi-energi-suntik-mati-pltu-hingga-ancaman-perangkap-hutang-dalam-skema-jetp/' => '/konten/kelas-pendidikan-energi-ruang-partisipasi-kawula-muda-mengenal-isu-keadilan-antargenerasi',
        'https://walhijabar.id/urgensi-keterlibatan-publik-dalam-menakar-dampak-solusi-semu-transisi-energi-berkeadilan/' => '/konten/kelas-pendidikan-energi-ruang-partisipasi-kawula-muda-mengenal-isu-keadilan-antargenerasi',
        'https://walhijabar.id/pltu-cirebon-dan-pltu-indramayu/' => '/konten/pltu-cirebon-dan-pltu-indramayu',
        'https://walhijabar.id/' => 'https://walhijabar.or.id/',
        'http://walhijabar.id/' => 'https://walhijabar.or.id/',
        'https://walhijabar.id' => 'https://walhijabar.or.id',
        'http://walhijabar.id' => 'https://walhijabar.or.id',
    ];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Scanning database for editorial typos and legacy domain references...');

        $updatedCount = 0;

        Content::chunk(100, function ($contents) use (&$updatedCount) {
            foreach ($contents as $content) {
                $changed = false;
                $title = $content->title;
                $body = $content->body;
                $imageUrl = $content->image_url;

                foreach (self::TYPO_MAP as $typo => $fix) {
                    if (str_contains($title, $typo)) {
                        $title = str_replace($typo, $fix, $title);
                        $changed = true;
                    }
                    if (str_contains($body, $typo)) {
                        $body = str_replace($typo, $fix, $body);
                        $changed = true;
                    }
                    if ($imageUrl && str_contains($imageUrl, $typo)) {
                        $imageUrl = str_replace($typo, $fix, $imageUrl);
                        $changed = true;
                    }
                }

                // Clean duplicated Google Drive links artifact
                if (str_contains($body, 'https://drive.google.com/file/d/1XiBmnf7LLGENuztB2oyJ9sD36gFqZVKX/view?usp=sharinghttps://drive.google.com/file/d/1XiBmnf7LLGENuztB2oyJ9sD36gFqZVKX/view?usp=sharing')) {
                    $body = str_replace('https://drive.google.com/file/d/1XiBmnf7LLGENuztB2oyJ9sD36gFqZVKX/view?usp=sharinghttps://drive.google.com/file/d/1XiBmnf7LLGENuztB2oyJ9sD36gFqZVKX/view?usp=sharing', 'https://drive.google.com/file/d/1XiBmnf7LLGENuztB2oyJ9sD36gFqZVKX/view?usp=sharing', $body);
                    $changed = true;
                }
                if (str_contains($body, 'https://drive.google.com/file/d/1qr5QAeSrUx4f98qZ-AlXb1Qwbdr9iPud/view?usp=sharinghttps://drive.google.com/file/d/1qr5QAeSrUx4f98qZ-AlXb1Qwbdr9iPud/view?usp=sharinghttps://drive.google.com/file/d/1qr5QAeSrUx4f98qZ-AlXb1Qwbdr9iPud/view?usp=sharing')) {
                    $body = str_replace('https://drive.google.com/file/d/1qr5QAeSrUx4f98qZ-AlXb1Qwbdr9iPud/view?usp=sharinghttps://drive.google.com/file/d/1qr5QAeSrUx4f98qZ-AlXb1Qwbdr9iPud/view?usp=sharinghttps://drive.google.com/file/d/1qr5QAeSrUx4f98qZ-AlXb1Qwbdr9iPud/view?usp=sharing', 'https://drive.google.com/file/d/1qr5QAeSrUx4f98qZ-AlXb1Qwbdr9iPud/view?usp=sharing', $body);
                    $changed = true;
                }

                if ($changed) {
                    $content->title = $title;
                    $content->body = $body;
                    $content->image_url = $imageUrl;
                    $content->saveQuietly();
                    $updatedCount++;
                    $this->line("  [FIXED] Content ID {$content->id}: {$content->slug}");
                }
            }
        });

        $this->info("Completed: {$updatedCount} content record(s) fixed.");

        return Command::SUCCESS;
    }
}
