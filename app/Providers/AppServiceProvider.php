<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Rate limiting for web routes (general)
        RateLimiter::for('web', function (Request $request) {
            return Limit::perMinute(120)->by($request->user()?->id ?: $request->ip());
        });

        // Rate limiting for login attempts
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->input('email') . '|' . $request->ip());
        });

        // Rate limiting for search/filter endpoints
        RateLimiter::for('search', function (Request $request) {
            return Limit::perMinute(30)->by($request->ip());
        });

        // Rate limiting for admin actions (store/update/delete)
        RateLimiter::for('admin-actions', function (Request $request) {
            return Limit::perMinute(30)->by($request->user()?->id ?: $request->ip());
        });

        // Share global contact and campaign data loaded dynamically from the database
        view()->composer('*', function ($view) {
            $contactData = [
                'email' => 'walhijabar@gmail.com',
                'whatsapp' => '+62 821-1982-1159',
                'address' => 'Jl. Simponi No.29, Turangga, Kec. Lengkong, Kota Bandung, Jawa Barat 40264',
                'facebook' => 'https://facebook.com/walhi.jabar',
                'instagram' => 'https://instagram.com/walhi.jabar',
                'youtube' => 'https://www.youtube.com/@walhijabar',
            ];

            $campaignData = [
                'title' => 'Kampanye Darurat: Hentikan Tambang Ilegal',
                'url' => '#',
            ];

            try {
                if (\Schema::hasTable('contents')) {
                    $kontak = \App\Models\Content::where('category', 'kontak')
                        ->where('status', 'published')
                        ->first();

                    if ($kontak) {
                        $lines = explode("\n", str_replace("\r", "", $kontak->body));
                        foreach ($lines as $line) {
                            if (strpos($line, ':') !== false) {
                                list($key, $value) = explode(':', $line, 2);
                                $key = strtolower(trim($key));
                                $value = trim($value);
                                if (array_key_exists($key, $contactData)) {
                                    $contactData[$key] = $value;
                                }
                            }
                        }
                    }

                    $campaign = \App\Models\Content::where('category', 'kampanye-darurat')
                        ->where('status', 'published')
                        ->first();

                    if ($campaign) {
                        $campaignData['title'] = $campaign->title;
                        $campaignData['url'] = $campaign->tags ?: '#';
                    }
                }
            } catch (\Exception $e) {
                // Fail silently to prevent breaking during migrations/CLI
            }

            $view->with('globalContact', (object) $contactData);
            $view->with('globalCampaign', (object) $campaignData);
        });
    }
}
