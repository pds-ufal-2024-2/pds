<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    public function history()
    {
        return $this->hasMany(IncidentHistory::class);
    }

    public function interested()
    {
        return $this->hasMany(Interested::class);
    }
}
