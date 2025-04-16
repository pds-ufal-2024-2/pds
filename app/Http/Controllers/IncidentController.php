<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    /**
     * Show the reported incident details.
     */
    public function show(string $code)
    {
        $incident = Incident::where('code', $code)->with('history')->firstOrFail();

        return view('incidents.show', [
            'incident' => $incident,
        ]);
    }
}
