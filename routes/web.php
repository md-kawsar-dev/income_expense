<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::redirect('/', '/dashboard');
Route::get('/dashboard', function () {
    return view('welcome');
});
Route::get('/category', function () {
    return view('category');
});
Route::get('/budget-plan', function () {
    return view('budget_plan');
});
Route::get('/income-by', function () {
    return view('income_by');
});
Route::get('/expense', function () {
    return view('expense');
});
Route::get('/income', function () {
    return view('income');
});
