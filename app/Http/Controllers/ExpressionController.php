<?php

namespace App\Http\Controllers;

use App\Models\Expression;
use Illuminate\Http\Request;

class ExpressionController extends Controller
{
    public function index()
    {
        $expressions = Expression::latest()->get();

        return response()->json(['success' => true, 'data' => $expressions]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'expression' => 'required|string',
            'confidence' => 'nullable|numeric',
            'visitor_id' => 'nullable|exists:visitors,id',
        ]);

        $expression = Expression::create($validated);

        return response()->json(['success' => true, 'data' => $expression]);
    }
}
