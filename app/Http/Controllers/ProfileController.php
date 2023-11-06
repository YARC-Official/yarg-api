<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function getProfile(User $user)
    {
        $user = $user->load('instrument');
        return Inertia::render('PublicProfile/Index', [
            'user' => $user
        ]);
    }
}
