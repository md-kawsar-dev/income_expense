<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    // Route::get('/users', [UserController::class, 'index']);
    Route::apiResource('/users', UserController::class);
   
    
    // expense item
    Route::apiResource('/expense-items',App\Http\Controllers\Api\ExpenseItemController::class);//multiple permissions handled in controller

    // dashboard
    Route::get('/dashboard/summary', [App\Http\Controllers\Api\DashboardController::class,'summary']);
    Route::get('/dashboard/monthly-trend', [App\Http\Controllers\Api\DashboardController::class,'monthlyTrend']);
    Route::get('/dashboard/expense-breakdown', [App\Http\Controllers\Api\DashboardController::class,'expenseBreakdown']);
    Route::get('/budget',[App\Http\Controllers\Api\BudgetController::class,'index']);
    // budget-plan
    Route::post('/budget-plan/add/previous-month', [App\Http\Controllers\Api\BudgetPlanController::class, 'previousMonthBudgetAdd']);
    Route::apiResource('/budget-plan',\App\Http\Controllers\Api\BudgetPlanController::class);
    // income
    Route::apiResource('/income',\App\Http\Controllers\Api\IncomeController::class);
    // expense
    Route::apiResource('/expense',\App\Http\Controllers\Api\ExpenseController::class);
});

