<?php

namespace App\Config;

use Shadow\Kernel\Route;

Route::path('@get@post');

Route::path('test');
    //->matchStr('key', regex: "/^33c5f49c9ce7393a2c34462bb1179$/");

Route::run();
