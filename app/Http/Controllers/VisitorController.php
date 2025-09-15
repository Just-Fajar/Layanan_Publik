<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class VisitorController extends Controller
{
    // Target coordinates
    private const TARGET_LATITUDE = -7.632269349111827;
    private const TARGET_LONGITUDE = 111.5301320107111;
    private const MAX_DISTANCE_KM = 0.5; // 500 meters radius

    /**
     * Store a new visitor entry.
     */
    public function store(Request $request)
    {
        // Validate coordinates first
        if (!$this->isWithinRange($request->latitude, $request->longitude)) {
            return response()->json([
                'success' => false,
                'message' => 'Maaf, Anda berada di luar area yang diizinkan. Silahkan datang ke lokasi untuk mengisi buku tamu.'
            ], 403);
        }

        // Regular validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'asal_daerah' => 'nullable|string|max:255',
            'purpose' => 'required|string|in:' . implode(',', array_keys(Visitor::PURPOSE_OPTIONS)),
            'notes' => 'required|string',
            'photo' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        try {
            // Process the base64 image
            $photo = $request->photo;
            $photo = str_replace('data:image/jpeg;base64,', '', $photo);
            $photo = str_replace(' ', '+', $photo);
            
            $imageName = time() . '_' . uniqid() . '.jpg';
            Storage::disk('public')->put('visitors/' . $imageName, base64_decode($photo));

            // Create visitor record
            $visitor = Visitor::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'asal_daerah' => $request->asal_daerah,
                'purpose' => $request->purpose,
                'notes' => $request->notes,
                'photo_path' => 'visitors/' . $imageName,
                'visit_date' => Carbon::now(),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data kunjungan berhasil disimpan.',
                'data' => $visitor
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if the given coordinates are within allowed range.
     */
    private function isWithinRange($latitude, $longitude)
    {
        if (!$latitude || !$longitude) {
            return false;
        }

        // Calculate distance using Haversine formula
        $earthRadius = 6371; // Earth's radius in kilometers

        $latFrom = deg2rad(self::TARGET_LATITUDE);
        $lonFrom = deg2rad(self::TARGET_LONGITUDE);
        $latTo = deg2rad($latitude);
        $lonTo = deg2rad($longitude);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        $distance = $angle * $earthRadius;

        return $distance <= self::MAX_DISTANCE_KM;
    }
}