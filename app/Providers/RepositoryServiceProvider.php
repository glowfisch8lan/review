<?php

namespace App\Providers;

use App\Modules\Shop\Repositories\Interfaces\ProductRepositoryInterface;
use App\Modules\Shop\Repositories\ProductRepository;
use App\Modules\Site\Repositories\Interfaces\PageRepositoryInterface;
use App\Modules\Site\Repositories\PageRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 * @author Denis Grigorov
 */
class RepositoryServiceProvider extends ServiceProvider
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
            ProductRepositoryInterface::class,
            ProductRepository::class
        );
        $this->app->bind(
            PageRepositoryInterface::class,
            PageRepository::class
        );
    }
}
