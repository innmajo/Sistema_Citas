<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Servicio;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_servicios' => Servicio::count(),
            'admins' => User::where('role', 'admin')->count(),
            'editors' => User::where('role', 'editor')->count(),
            'usuarios' => User::where('role', 'usuario')->count(),
        ];

        return view('admin.index', compact('stats'));
    }
}
