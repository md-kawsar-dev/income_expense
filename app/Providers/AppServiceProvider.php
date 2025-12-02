<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('apiResponse',function($e,$data=[], $message='',$code=500){
            $exception = $e->getMessage().' in '.$e->getFile().' at line '.$e->getLine();
            $data['data'] = $data;
            $data['status'] = false;
            $data['message'] = $message ?: 'An error occurred';
            $data['error'] = config('app.debug') ? $exception : null;
            return response()->json($data,$code);
        });
    }
}
