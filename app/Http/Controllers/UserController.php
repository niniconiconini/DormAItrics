<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $admins = User::whereIn('user_type', ['Admin', 'Manager'])->get();

        $residents = Resident::with(['user', 'room']);
        if (request('view') === 'transient') {
            $residents->where('accommodation_type', 'Transient');
        } else {
            $residents->where('accommodation_type', 'Resident');
        }

        if (request('resident_type')) {
            $residents->where('resident_type', request('resident_type'));
        }
        $residents = $residents->get();

        return view('residents', ['admins' => $admins, 'residents' => $residents]);
    }
}
