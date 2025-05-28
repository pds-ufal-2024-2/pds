<?php declare(strict_types=1);

namespace App;

use Illuminate\Support\Facades\Http;

class OpenStreetMaps
{
    public static function buscarBairro(float $lat, float $lon): ?string
    {
        $response = Http::withHeader('User-Agent', config('app.name') . '/1.0')
            ->get("https://nominatim.openstreetmap.org/reverse?lat={$lat}&lon={$lon}&format=jsonv2");

        if ($response->failed()) {
            return null;
        }

        $responseData = $response->json();
        if (isset($responseData['address']['suburb'])) {
            return strtoupper($responseData['address']['suburb']);
        }
        
        return null;
    }
}