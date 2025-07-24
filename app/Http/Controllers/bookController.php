<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\book;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class bookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $books = book::when($search, function ($query, $search) {
                return $query->where('nama_buku', 'like', "%{$search}%")
                            ->orWhere('nama_pengarang', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);

        $categories = Category::all()->keyBy('id'); // untuk pencocokan manual

        return view('admin.book.books', compact('books', 'search', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $getCategory = category::all();
        return view('admin.book.addBook', compact('getCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'kategori' => 'required',
        'nama_buku' => 'required',
        'nama_pengarang' => 'required',
        'nama_penerbit' => 'required',
        'tahun_terbit' => 'nullable|numeric',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $data = $request->only(
        'kategori',
        'nama_buku',
        'nama_pengarang',
        'nama_penerbit',
        'tahun_terbit'
    );

    // Handle file upload 
    if ($request->hasFile('gambar')) {
        $file = $request->file('gambar');
        $filename = time() . '_' . $file->getClientOriginalName();

        $path = $file->storeAs('public/bookspict', $filename);

        $data['gambar'] = 'bookspict/' . $filename;
    }

    book::create($data);

    return redirect('/books')->with('success', 'buku berhasil disimpan');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = book::findOrFail($id);
        $getCategory = category::all();
        return view('admin.book.editBook', compact('book', 'getCategory'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori' => 'required',
            'nama_buku' => 'required',
            'nama_pengarang' => 'required',
            'nama_penerbit' => 'required',
            'tahun_terbit' => 'nullable|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $book = book::findOrFail($id);

        $data = $request->only([
            'kategori',
            'nama_buku',
            'nama_pengarang',
            'nama_penerbit',
            'tahun_terbit'
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/bookspict', $filename);
            $data['gambar'] = 'bookspict/' . $filename;
        }

        $book->update($data);

        return redirect('/books')->with('success', 'Buku berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = book::find($id);
        $delete->delete();

        Alert::success('OK', 'Buku berhasil dihapus!');
        return redirect('/books');
    }
}
