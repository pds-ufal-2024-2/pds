<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpIncident extends Model
{
    use HasFactory;

    protected $table = 'up_incident';

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}
