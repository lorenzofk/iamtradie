<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class HowItWorksController extends Controller
{
    /**
     * Display the How It Works page.
     */
    public function index(): Response
    {
        return Inertia::render('HowItWorks/Index');
    }
} 