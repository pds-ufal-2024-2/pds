<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

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
        'status',
        'incident',
        'entity',
        'counter',
        'bairro',
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

    protected static function booted()
    {
        static::creating(function ($incident) {
            if ($incident->latitude && $incident->longitude && !$incident->bairro) {
                $bairro = self::buscarBairro($incident->latitude, $incident->longitude);
                if ($bairro) {
                    $incident->bairro = strtoupper($bairro);
                }
            }
        });
    }

    private static function buscarBairro($lat, $lon)
    {
        $url = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=$lat&lon=$lon";

        try {
            $res = Http::withHeaders([
                'User-Agent' => 'LaravelApp/1.0'
            ])->get($url);
            if ($res->successful()) {
                $data = $res->json();
                return $data['address']['suburb'] ?? $data['address']['neighbourhood'] ?? null;
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }
}
