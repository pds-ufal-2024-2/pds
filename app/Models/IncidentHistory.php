<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncidentHistory extends Model
{
    protected $table = 'incident_history';

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}
