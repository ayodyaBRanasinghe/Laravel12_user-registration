<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\EmployeeRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
