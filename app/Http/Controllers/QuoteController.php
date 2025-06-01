<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Exception;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index(): Response
    {
        $quotes = Auth::user()->quotes()->latest()->get();

        $props = [
            'quotes' => $quotes,
        ];

        return Inertia::render('Quotes/index', $props);
    }

    public function show(Quote $quote): Response
    {
        $props = [
            'quote' => $quote,
        ];

        return Inertia::render('Quotes/Show', $props);
    }

    public function destroy(Quote $quote): JsonResponse
    {
        try {
            $quote->delete();
        } catch (Exception) {
            return response()->json(['message' => 'Error deleting quote'], status: 500);
        }

        return response()->json(status: 204);
    }

    public function update(Quote $quote, Request $request): JsonResponse
    {
        $request->validate([
            'edited_response' => 'required|string',
        ]);

        $quote->update([
            'edited_response' => $request->edited_response,
        ]);

        return response()->json($quote);
    }
} 