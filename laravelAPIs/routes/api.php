<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get("/sort/{string?}", [ApiController::class, 'sortString']);
Route::get("/value/{num?}", [ApiController::class, 'placeValue']);
Route::post("/translate/{message?}", [ApiController::class, 'toProgrammer']);
Route::post("/evaluate/{expression?}", [ApiController::class, 'evaluatePrefix']);




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
