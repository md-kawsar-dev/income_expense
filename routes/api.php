<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users', [UserController::class, 'index']);

    // category
    Route::apiResource('/category',App\Http\Controllers\Api\CategoryController::class);

    // budget
    Route::post('/budget/add/previous-month', [App\Http\Controllers\Api\BudgetController::class, 'previousMonthBudgetAdd']);
    Route::apiResource('/budget',\App\Http\Controllers\Api\BudgetController::class);

    // income by
    Route::apiResource('/income-by',\App\Http\Controllers\Api\IncomeByController::class);
    // income
    Route::apiResource('/income',\App\Http\Controllers\Api\IncomeController::class);
    // expense
    Route::apiResource('/expense',\App\Http\Controllers\Api\ExpenseController::class);
});

