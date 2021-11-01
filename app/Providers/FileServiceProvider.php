<?php

namespace App\Providers;


use App\Modules\Site\Services\FileService;
use App\Modules\Site\Services\ImageService;
use App\Modules\Site\Services\Interfaces\FileServiceInterface;
use App\Modules\Site\Services\Interfaces\ImageServiceInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Class FileServiceProvider
 * @package App\Providers
 */
class FileServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            FileServiceInterface::class,
            FileService::class
        );
        $this->app->bind(
            ImageServiceInterface::class,
            ImageService::class
        );
    }
}
