<?php

namespace App\Providers;

use App\Domain\Repositories\ProductRepositoryInterface;
use App\Domain\Repositories\UserProductRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Services\ProductServiceInterface;
use App\Domain\Services\UserProductServiceInterface;
use App\Domain\Services\UserServiceInterface;
use App\Repositories\ProductRepository;
use App\Repositories\UserProductRepository;
use App\Repositories\UserRepository;
use App\Services\ProductService;
use App\Services\UserProductService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(UserProductServiceInterface::class, UserProductService::class);
        $this->app->bind(UserProductRepositoryInterface::class, UserProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
