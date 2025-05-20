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

// Route::post('/logout', function (Request $request) {
//     console.log('entrou no back')
//     Auth::logout(); // encerra a sessão
//     $request->session()->invalidate(); // invalida a sessão
//     $request->session()->regenerateToken(); // regenera CSRF token
//     return response()->json(['message' => 'Logout feito com sucesso']);
// })->middleware(['web', 'auth']);
