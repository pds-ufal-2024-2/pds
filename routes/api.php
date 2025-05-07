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

Route::get('/incidents/{code}', function ($code) {
    $incident = \App\Models\Incident::with(['history', 'interested', 'up'])->where('code', $code)->first();
    if (!$incident) {
        return response()->json(['message' => 'Incident not found'], 404);
    }
    return response()->json($incident);
})->middleware('auth:sanctum');

Route::put('/incidents/{code}', function (Request $request, $code) {
    $incident = \App\Models\Incident::where('code', $code)->first();
    if (!$incident) {
        return response()->json(['message' => 'Incident not found'], 404);
    }

    $incident->update($request->all());
    return response()->json($incident);
})->middleware('auth:sanctum');