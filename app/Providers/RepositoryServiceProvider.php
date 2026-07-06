<?php

namespace App\Providers;

use App\Repositories\Contracts\ElectricityRepositoryInterface;
use App\Repositories\Contracts\FastagRepositoryInterface;
use App\Repositories\Contracts\RechargeRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\ElectricityRepository;
use App\Repositories\Eloquent\FastagRepository;
use App\Repositories\Eloquent\RechargeRepository;
use App\Repositories\Eloquent\TransactionRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register repository bindings.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ElectricityRepositoryInterface::class, ElectricityRepository::class);
        $this->app->bind(FastagRepositoryInterface::class, FastagRepository::class);
        $this->app->bind(RechargeRepositoryInterface::class, RechargeRepository::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
    }
}
