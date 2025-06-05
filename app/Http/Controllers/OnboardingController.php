<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class OnboardingController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('Public/Onboarding/index', [
            'plan' => 'Founders Plan',
        ]);
    }
} 