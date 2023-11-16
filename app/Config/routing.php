<?php

namespace App\Config;

use Shadow\Kernel\Route;
use App\Config\AdminConfig;

Route::path('@get@post');

Route::path('test@put')
    ->matchStr('key', regex: ("/^" . AdminConfig::ADMIN_API_KEY . "$/"));

Route::run();
