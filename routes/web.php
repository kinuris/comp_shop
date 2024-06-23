<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PaymentTransactionController;
use Illuminate\Support\Facades\Route;
use App\Models\Discount;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;

Route::get('/', [HomepageController::class, 'index'])
    ->middleware('auth');

// Route::post('/order/process', [HomepageController::class, 'process_order'])
//     ->can('process', Product::class);

Route::get('/history', [UserController::class, 'history'])
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/password-change/{user}', [UserController::class, 'view_change_password']);
    Route::put('/password-change/{user}', [UserController::class, 'change_password']);
});

// Route::middleware(['role:admin'])->group(function () {
//     Route::get('/admin', function () {
//         return 'Hello admin!';
//     });
// });
//
// Route::middleware(['role:manager'])->group(function () {
//     Route::get('/manager', function () {
//         return 'Hello manager!';
//     });
// });

// Route::get('/search', ProductSearch::class);
Route::get('/test/{transaction}', [PaymentTransactionController::class, 'html_generate_modal']);

// NOTE: Manager related controller

Route::controller(ProductController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/product', 'index')->can('viewAny', Product::class);
        Route::get('/product/show/{product}', 'show')->can('view', Product::class);

        Route::get('/product/create', 'create')->can('create', Product::class);
        Route::post('/product/create', 'store')->can('create', Product::class);

        Route::get('/product/restock/{product}', 'restock_view')->can('update', Product::class);
        Route::post('/product/restock/{product}', 'restock')->can('update', Product::class);

        Route::get('/product/update/{product}', 'edit')->can('update', Product::class);
        Route::put('/product/update/{product}', 'update')->can('update', Product::class);

        Route::get('/product/avail/toggle/{product}', 'toggle_availability')->can('delete', Product::class);
    });

Route::controller(AnalyticsController::class);

// NOTE: Admin related controllersData-Driven Strategy: Organizations might prioritize collecting and analyzing data to inform their business decisions, aiming to improve efficiency, customer experience, and drive innovation

Route::controller(PaymentMethodController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/payment-method', 'index')->can('viewAny', PaymentMethod::class);
        Route::get('/payment-method/show/{paymentMethod}', 'show')->can('view', PaymentMethod::class);

        Route::get('/payment-method/create', 'create')->can('create', PaymentMethod::class);
        Route::get('/payment-method/update/{paymentMethod}', 'edit')->can('update', PaymentMethod::class);
        Route::get('/payment-method/delete/{paymentMethod}', 'delete')->can('delete', PaymentMethod::class);
    });

Route::controller(UserController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/employee', 'index')->can('viewAny', User::class);
        Route::get('/employee/show/{user}', 'show')->can('view', User::class);

        Route::get('/history/{user}', 'peek_history')->can('view', User::class);

        Route::get('/employee/create', 'create')->can('create', User::class);
        Route::post('/employee/create', 'store')->can('create', User::class);

        Route::get('/employee/update/{user}', 'edit')->can('update,user', User::class);
        Route::put('/employee/update/{user}', 'update')->can('update,user', User::class);

        Route::get('/employee/suspend/{user}', 'suspend')->can('delete,user', User::class);
    });

Route::controller(DiscountController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/discount', 'index')->can('viewAny', Discount::class);
        Route::get('/discount/show/{discount}', 'show')->can('view', Discount::class);

        Route::get('/discount/create', 'create')->can('create', Discount::class);
        Route::post('/discount/create', 'store')->can('create', Discount::class);

        Route::get('/discount/update/{discount}', 'edit')->can('update', Discount::class);
        Route::post('/discount/update/{discount}', 'update')->can('update', Discount::class);

        Route::get('/discount/disable/{discount}', 'disable')->can('update', Discount::class);

        Route::get('/discount/delete/{discount}', 'delete')->can('delete', Discount::class);
    });

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [UserController::class, 'login_view'])->name('login');
    Route::post('/login', [UserController::class, 'login']);
});
