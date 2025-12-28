<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')
    ->group(base_path('routes/v1/api.php'));
