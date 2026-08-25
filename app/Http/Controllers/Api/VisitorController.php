<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VisitorController extends Controller
{
    /**
     * List data pengunjung (dengan filter & pagination).
     * Mendukung query: ?date=YYYY-MM-DD, ?month=8&year=2025, ?purpose=...
     */
    public function index(Request $request)
    {
        $query = Visitor::query();

        // Filter tanggal spesifik (opsional)
        if ($request->filled('date')) {
            $query->whereDate('visit_date', $request->date);
        }

        // Filter by month and year
        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('visit_date', $request->month)
                ->whereYear('visit_date', $request->year);
        }

        // Filter by purpose
        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }

        if ($request->filled('name')) {
            $name = $request->name;
            $query->where('name', 'like', "%{$name}%");
        }

        $visitors = $query->orderBy('visit_date', 'desc')->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $visitors, // setiap item sudah menyertakan photo_url dari $appends di Model
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * Terima selfie base64 dataURL, simpan file di disk('public'), simpan path di DB.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'asal_daerah' => 'required|string|max:255',
            'purpose' => 'required|in:sekretariat,aplikasi_informatika,persandian_keamanan_informasi,informasi_komunikasi_publik,statistik',
            'notes' => 'required|string',
            'photo' => 'required|string', // base64 dataURL: data:image/jpeg;base64,...
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $data['visit_date'] = now();

        // Handle photo upload (dataURL base64)
        $photoData = $data['photo'] ?? null;
        if ($photoData) {
            $ext = 'jpg';

            // Ambil ekstensi dari dataURL bila ada
            if (preg_match('/^data:image\/(\w+);base64,/', $photoData, $m)) {
                $ext = strtolower($m[1]); // png|jpg|jpeg|webp|gif
                $photoData = substr($photoData, strpos($photoData, ',') + 1);
            }

            $binary = base64_decode($photoData);
            if ($binary === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Foto tidak valid (gagal decode base64)',
                ], 422);
            }

            // Simpan rapi per tahun/bulan
            $dir = 'photos/' . date('Y/m/');
            $photoName = 'visitor_' . uniqid() . '.' . $ext;
            $photoPath = $dir . $photoName;

            // Simpan ke storage/app/public/...
            Storage::disk('public')->put($photoPath, $binary);

            // Simpan path relatif ke DB (tanpa leading slash)
            $data['photo_path'] = $photoPath;
        }

        // Jangan simpan base64 di DB
        unset($data['photo']);

        $visitor = Visitor::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Visitor registered successfully',
            'data' => $visitor->fresh(), // akan menyertakan photo_url dari accessor Model
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $visitor = Visitor::find($id);

        if (! $visitor) {
            return response()->json([
                'success' => false,
                'message' => 'Visitor not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $visitor, // sudah ada photo_url
        ]);
    }

    /**
     * Update the specified resource in storage.
     * (tanpa ganti foto di sini; kalau perlu, bisa ditambah endpoint terpisah)
     */
    public function update(Request $request, string $id)
    {
        $visitor = Visitor::find($id);

        if (! $visitor) {
            return response()->json([
                'success' => false,
                'message' => 'Visitor not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'institution' => 'nullable|string|max:255',
            'purpose' => 'required|in:sekretariat,aplikasi_informatika,persandian_keamanan_informasi,informasi_komunikasi_publik,statistik',
            'notes' => 'nullable|string',
            'visit_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $visitor->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Visitor updated successfully',
            'data' => $visitor->fresh(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $visitor = Visitor::find($id);

        if (! $visitor) {
            return response()->json([
                'success' => false,
                'message' => 'Visitor not found',
            ], 404);
        }

        // Delete photo if exists
        if ($visitor->photo_path) {
            Storage::disk('public')->delete($visitor->photo_path);
        }

        $visitor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Visitor deleted successfully',
        ]);
    }

    /**
     * Get statistics (untuk kartu & grafik).
     * Mendukung ?month=&year=
     */
    public function statistics(Request $request)
    {
        $month = (int) $request->get('month'); // untuk donut
        $year = (int) $request->get('year');  // untuk donut & trend tahunan

        // Kartu default
        $total = Visitor::count();
        $today = Visitor::whereDate('visit_date', now()->toDateString())->count();
        $thisMonth = Visitor::whereMonth('visit_date', now()->month)
            ->whereYear('visit_date', now()->year)->count();

        // Donut purpose (ikut filter bila ada)
        $purposeBase = Visitor::query();
        if ($month && $year) {
            $purposeBase->whereMonth('visit_date', $month)->whereYear('visit_date', $year);
        }
        $purposeStats = $purposeBase
            ->selectRaw('purpose, COUNT(*) as count')
            ->groupBy('purpose')
            ->get();

        // Line chart
        if ($year) {
            $monthlyStats = Visitor::selectRaw('YEAR(visit_date) as year, MONTH(visit_date) as month, COUNT(*) as count')
                ->whereYear('visit_date', $year)
                ->groupBy('year', 'month')
                ->orderBy('month', 'asc')
                ->get();
        } else {
            // rolling 12 bulan terakhir
            $monthlyStats = Visitor::selectRaw('YEAR(visit_date) as year, MONTH(visit_date) as month, COUNT(*) as count')
                ->where('visit_date', '>=', now()->subMonths(11)->startOfMonth())
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')->orderBy('month', 'desc')
                ->limit(12)
                ->get();
        }

        return response()->json([
            'success' => true,
            'data' => [
                'total' => $total,
                'today' => $today,
                'this_month' => $thisMonth,
                'purpose_stats' => $purposeStats,
                'monthly_stats' => $monthlyStats,
            ],
        ]);
    }

    /**
     * Export visitors to PDF (opsional).
     */
    public function exportPdf(Request $request)
    {
        $query = Visitor::query();

        // Apply filters
        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }

        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('visit_date', $request->month)
                ->whereYear('visit_date', $request->year);
        }

        $visitors = $query->orderBy('visit_date', 'desc')->get();

        // Paper options
        $paperFormat = strtolower($request->get('format', 'a4'));
        $orientation = strtolower($request->get('orientation', 'portrait'));

        $allowedFormats = ['a4', 'f4', 'letter', 'legal'];
        $allowedOrientations = ['portrait', 'landscape'];

        if (! in_array($paperFormat, $allowedFormats)) {
            $paperFormat = 'a4';
        }
        if (! in_array($orientation, $allowedOrientations)) {
            $orientation = 'portrait';
        }

        // Generate PDF
        $pdf = Pdf::loadView('.buku_tamu.pdf.visitors', compact('visitors', 'paperFormat', 'orientation'));
        $pdf->setPaper($paperFormat, $orientation);

        $filename = 'laporan-pengunjung-' . $paperFormat . '-' . date('Y-m-d') . '.pdf';

        // Stream PDF in browser (not auto-download)
        return $pdf->stream($filename);
    }
}
