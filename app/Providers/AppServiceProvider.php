<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Statamic\Statamic;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootTelescope();

        // Statamic::script('app', 'cp');
        // Statamic::style('app', 'cp');
    }

    protected function bootTelescope()
    {
        if (config('telescope.enabled') && Schema::hasTable('cache')) {
            if (! Schema::hasTable('telescope_entries')) {
                Artisan::call('migrate', [
                    '--force' => true,
                    '--path' => '/vendor/laravel/telescope/database/migrations/2018_08_08_100000_create_telescope_entries_table.php',
                ]);
            }

            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }
}
