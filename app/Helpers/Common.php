<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

if (!function_exists('validation')) {

    function validation($rules, $message = [])
    {
        try {
            
            $validator = validator()->make(request()->all(), $rules, $message);

            if ($validator->fails()) {

                return implode(', ', $validator->messages()->all());

            }

            return null;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

if (!function_exists('post_request')) {

    function post_request($request)
    {
        return $request->method() == 'POST';
    }
}

if (!function_exists('api_response')) {

    function api_response($statusCode = 200, $success = true, $message = null, $data = null, $pagination = null)
    {
        $response['success'] = $success;
        $response['message'] = $message;

        if ($pagination) {
            $response['pagination'] = $pagination;
        }

        if ($data) {
            $response['data'] = $data;
        }

		return response()->json($response, $statusCode);
    }

}

if (!function_exists('format_phone')) {

    function format_phone($phoneNumber, $append = null)
    {
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        if (substr($phoneNumber, 0, 1) === '+') {
            $phoneNumber = substr($phoneNumber, 1);
        }

        if (substr($phoneNumber, 0, 2) === '62') {
            $phoneNumber = substr($phoneNumber, 2);
        }

        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = substr($phoneNumber, 1);
        }

        return ($append ?? '') . $phoneNumber;
    }
}

if (!function_exists('rupiah')) {

    function rupiah($angka, $prefix = true)
    {
        $formatted = number_format($angka, 0, ',', '.');
        return $prefix ? 'Rp. ' . $formatted : $formatted;
    }
}

if (!function_exists('encrypt')) {

    function encrypt($value)
    {
        $value = Crypt::encryptString($value);
        return $value;
    }
}

if (!function_exists('decrypt')) {

    function decrypt($value)
    {
        $value = Crypt::decryptString($value);
        return $value;
    }
}

if (!function_exists('generateToken')) {

    function generateToken($length = 10)
    {
        $token = Str::random($length);
        $token = encrypt($token);
        return $token;
    }
}

if (!function_exists('isMenuRoute')) {

    function isMenuRoute($routeName, $menu)
    {
        return Str::startsWith($routeName, $menu.'.');
    }
}