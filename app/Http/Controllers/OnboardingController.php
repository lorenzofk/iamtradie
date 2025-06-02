<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class OnboardingController extends Controller
{
    public function show(string $plan): Response
    {
        return Inertia::render('Public/Onboarding/index', [
            'plan' => $plan,
        ]);
    }
} 