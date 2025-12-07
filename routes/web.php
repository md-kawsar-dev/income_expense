<?php

use Illuminate\Support\Facades\Route;

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::redirect('/', '/dashboard');
Route::view('/dashboard', 'welcome');
Route::view('/category', 'category');
Route::view('/budget-plan', 'budget_plan');
Route::view('/income-by', 'income_by');
Route::view('/expense', 'expense');
Route::view('/income', 'income');
Route::view('/budget', 'budget');
