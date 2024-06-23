<?php

namespace App\Providers;

use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;
use App\Policies\EmployeePolicy;
use App\Policies\PaymentMethodPolicy;
use App\Policies\ProductPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Livewire::setScriptRoute(function ($handle) {
        //     return Route::get('/vendor/livewire/livewire.js', $handle);
        // });

        Paginator::useBootstrap();

        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(User::class, EmployeePolicy::class);
        Gate::policy(PaymentMethod::class, PaymentMethodPolicy::class);
    }
}
