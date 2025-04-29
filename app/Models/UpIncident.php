<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpIncident extends Model
{
    protected $table = 'up_incident';

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}
