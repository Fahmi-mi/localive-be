<?php

namespace App\Providers;

use App\Services\ImagePipelineService;
use Illuminate\Support\ServiceProvider;

class ImagePipelineServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ImagePipelineService::class, function () {
            return new ImagePipelineService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
