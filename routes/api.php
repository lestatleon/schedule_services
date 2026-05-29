<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    'tenants' => TenantController::class,
    'users' => UserController::class,
    'customers' => CustomerController::class,
    'branches' => BranchController::class,
]);
