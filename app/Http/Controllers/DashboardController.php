<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'user' => auth()->user(),
        ]);
    }

    public function admin(): View
    {
        return view('admin.index', [
            'users' => User::with('roles')->orderBy('name')->get(),
        ]);
    }
}
