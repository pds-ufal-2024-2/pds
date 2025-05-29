<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Incident;
use Illuminate\Support\Facades\Auth;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/incidents', function (Request $request) {
    // Log::info('Fetching incidents', ['user' => $request->user()]);
    $incidents = Incident::with(['history', 'interested', 'up'])->get();
    return response()->json($incidents);
})->middleware('auth:sanctum');

Route::get('/incidents/{code}', function ($code) {
    $incident = \App\Models\Incident::with(['history', 'interested', 'up'])->where('code', $code)->first();
    if (!$incident) {
        return response()->json(['message' => 'Incident not found'], 404);
    }
    return response()->json($incident);
})->middleware('auth:sanctum');

// Route::put('/incidents/{code}', function (Request $request, $code) {
//     $incident = \App\Models\Incident::where('code', $code)->first();
//     if (!$incident) {
//         return response()->json(['message' => 'Incident not found'], 404);
//     }

//     $incident->update($request->all());
//     return response()->json($incident);
// })->middleware('auth:sanctum');
Route::put('/incidents/{id}', function (Request $request, $id) {
    $incident = \App\Models\Incident::findOrFail($id);
    $incident->update($request->all());
    return response()->json(['message' => 'Atualizado com sucesso']);
});


Route::post('/login', function (Request $request) {
    // Log::info('Login attempt', ['email' => $request->input('email')]);
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        // Log::info('Login successful', ['user_id' => $user->id]);
        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
        return response()->json([
            'access_token' => $token,
        ]);
    } else {
        // Log::warning('Login failed', ['email' => $request->input('email')]);
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
});

Route::post('/logout', function (Request $request) {
    $user = $request->user();
    // Log::info('Logout attempt', ['user_id' => $user?->id]);

    $user?->currentAccessToken()?->delete();

    return response()->json(['message' => 'Logout feito com sucesso']);
})->middleware('auth:sanctum');


Route::get('/test-incidents', function () {
    return response()->json([
        'count' => \App\Models\Incident::count(),
        'sample' => \App\Models\Incident::all()
    ]);
});
