<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\SK;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_sk' => 0,
            'total_divisi' => Division::count(),
            'total_users' => 0,
            'sk_bulan_ini' => 0,
        ];

        if ($user->isAdmin()) {
            $stats['total_sk'] = SK::count();
            $stats['total_users'] = User::count();
            $stats['sk_bulan_ini'] = SK::whereMonth('created_at', now()->month)->count();

            $recent_sks = SK::with(['division', 'creator'])
                ->latest()
                ->take(5)
                ->get();
        } else {
            $stats['total_sk'] = SK::where('division_id', $user->division_id)->count();
            $stats['sk_bulan_ini'] = SK::where('division_id', $user->division_id)
                ->whereMonth('created_at', now()->month)
                ->count();

            $recent_sks = SK::with(['division', 'creator'])
                ->where('division_id', $user->division_id)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboard', compact('stats', 'recent_sks'));
    }
}
