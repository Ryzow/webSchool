<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\book;
use App\Models\category;
use Illuminate\Http\Request;

class bookCatalogueController extends Controller
{
    
    public function index(Request $request) {
        $kategori = $request->input('kategori');
        $tahun = $request->input('tahun');

        $query = book::with('getCategory');

        if($kategori) {
            $query->where('kategori', $kategori);
        }

        if($tahun) {
            $query->where('tahun_terbit', $tahun);
        }

        $books = $query->paginate()->withQueryString();

        $kategoriList = category::all();
        $tahunList = book::select('tahun_terbit')->distinct()->pluck('tahun_terbit');
        
        return view('screen.book', compact(
            'books',
            'kategoriList',
            'tahunList',
            'kategori',
            'tahun',
        ));
    }
}
