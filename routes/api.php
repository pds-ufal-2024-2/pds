<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/incidents', function (Request $request) {
    $incidents = \App\Models\Incident::with(['history', 'interested', 'up'])->get();
    return response()->json($incidents);
})->middleware('auth:sanctum');
