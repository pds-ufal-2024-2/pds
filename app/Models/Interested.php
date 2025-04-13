<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interested extends Model
{
    protected $table = 'interested';

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}
