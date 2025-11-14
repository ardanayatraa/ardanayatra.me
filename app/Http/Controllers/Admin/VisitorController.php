<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitor;

class VisitorController extends Controller
{
    public function index()
    {
        $visitors = Visitor::latest()->paginate(50);
        
        return view('admin.visitors.index', compact('visitors'));
    }
}
