<?php

use Illuminate\Support\Facades\Auth;

if(!function_exists('scope_id')){
    function scope_id(){
        $user = Auth::user();
        return $user?($user->scope_id?:$user->id):null;
    }
}