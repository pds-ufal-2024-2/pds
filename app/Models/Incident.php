<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'image',
        'description',
        'category',
        'latitude',
        'longitude',
    ];

    public function history()
    {
        return $this->hasMany(IncidentHistory::class);
    }

    public function interested()
    {
        return $this->hasMany(Interested::class);
    }

    public function up()
    {
        return $this->hasMany(UpIncident::class);
    }
}
