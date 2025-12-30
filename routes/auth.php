<?php

use Illuminate\Support\Facades\Route;

Route::view('/terms-of-service', 'terms')->name('terms.show');
Route::view('/privacy-policy', 'policy')->name('policy.show');
