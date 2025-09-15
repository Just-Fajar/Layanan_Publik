<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    /**
     * Generate QR Code for visitor registration
     */
    public function generateVisitorQR()
    {
        // Get the base URL for visitor registration
        $visitorUrl = url('/');
        
        // Generate QR code
        $qrCode = QrCode::format('svg')
                        ->size(300)
                        ->margin(2)
                        ->generate($visitorUrl);
        
        return response($qrCode)
               ->header('Content-Type', 'image/svg+xml');
    }
    
    /**
     * Show QR code page for admin
     */
    public function showQRPage()
{
    return view('buku_tamu.admin.qrcode');
}

    
    /**
     * Generate QR code as downloadable PNG
     */
    public function downloadQR()
    {
        $visitorUrl = url('/');
        
        $qrCode = QrCode::format('png')
                        ->size(400)
                        ->margin(3)
                        ->generate($visitorUrl);
        
        return response($qrCode)
               ->header('Content-Type', 'image/png')
               ->header('Content-Disposition', 'attachment; filename="qr-buku-tamu.png"');
    }
}
