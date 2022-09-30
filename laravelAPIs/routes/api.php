<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get("/sort/{string?}", [ApiController::class, 'sortString']);
Route::get("/value/{num?}", [ApiController::class, 'placeValue']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
