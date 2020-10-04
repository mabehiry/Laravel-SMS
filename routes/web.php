<?php

use Illuminate\Support\Facades\Route;
use Mabehiry\Sms\Controllers\Sms;

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/sms/settings', [Sms::class, 'showSettings']);
    Route::post('/sms/settings', [Sms::class, 'updateSettings']);
});