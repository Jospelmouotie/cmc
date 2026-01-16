<?php

use Illuminate\Http\Request;
use App\Http\Controllers\EventsController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



