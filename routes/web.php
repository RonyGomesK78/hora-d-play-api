<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $string = 'hello world';
    return [
        'name' => $string,
        'details' => 'required'
    ];
});
