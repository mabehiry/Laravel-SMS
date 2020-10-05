<?php
use Illuminate\Support\Facades\Route;
use Mabehiry\Sms\Http\Controllers\SmsController;

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/sms/settings', [SmsController::class, 'showSettings']);
    Route::post('/sms/settings', [SmsController::class, 'updateSettings']);
});