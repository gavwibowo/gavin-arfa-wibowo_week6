<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->query('category');
        $keyword = $request->query('q');
        $query = DB::table('campaigns');
        
        if (!empty($kategori) && $kategori !== 'Semua') {
            $query->where('category', $kategori);
        }
        
        if (!empty($keyword)) {
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%");
            });
        }
        
        $campaigns = $query->orderBy('id', 'desc')->get();
        
        $categories = DB::table('campaigns')
        ->whereNotNull('category')
        ->where('category', '!=', '')
        ->distinct()
        ->pluck('category');
        
        return view('campaigns.index', compact('campaigns', 'categories', 'keyword', 'kategori'));
    }
}