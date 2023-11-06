<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class TestController extends Controller
{
    public function getTest(): Response
    {
        return Inertia::render('Test');
    }
}
