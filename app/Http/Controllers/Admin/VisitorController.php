<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitor;

class VisitorController extends Controller
{
    public function index()
    {
        $visitors = Visitor::latest()->paginate(50);
        
        // Analytics data
        $totalVisitors = Visitor::count();
        $totalVisits = Visitor::sum('visit_count');
        $uniqueIPs = Visitor::distinct('ip_address')->count('ip_address');
        
        // Visitor per hari (7 hari terakhir)
        $dailyVisitors = Visitor::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Top visitors berdasarkan visit count
        $topVisitors = Visitor::orderBy('visit_count', 'desc')
            ->take(10)
            ->get();
        
        return view('admin.visitors.index', compact('visitors', 'totalVisitors', 'totalVisits', 'uniqueIPs', 'dailyVisitors', 'topVisitors'));
    }

    public function destroy(Visitor $visitor)
    {
        $visitor->delete();

        return redirect()->route('admin.visitors.index')->with('success', 'Visitor deleted successfully');
    }
}
