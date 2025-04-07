<?php

use App\Http\Controllers\IncidentController;
use App\Livewire\Map;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', Welcome::class);
Route::get('/map', Map::class);
Route::get('/report/{code}', [IncidentController::class, 'show']);
