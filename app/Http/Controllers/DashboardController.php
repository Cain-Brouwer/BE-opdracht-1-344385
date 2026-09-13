<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('dashboard', [
            'user' => Auth::user(),
        ]);
    }

    public function admin(): \Illuminate\Contracts\View\View
    {
        return view('admin.index', [
            'users' => \App\Models\User::with('roles')->get(),
        ]);
    }
}