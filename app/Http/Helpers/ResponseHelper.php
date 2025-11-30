<?php

if(!function_exists('success')){
    function success($data = null, $message = "Request was successful", $code = 200){
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
if(!function_exists('error')){
    function error($message = "An error occurred", $code = 400){
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $code);
    }
}