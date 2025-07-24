<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $categories = category::when($search, function($query, $search){
            return $query->where('category', 'like', "%{$search}%");
        })->latest()->paginate(5);

        $editCategory = null;
        if ($request->has('edit')){
            $editCategory = category::find($request->edit);
        }
        
        return view('admin.category.category', compact(
            'categories',
            'editCategory',
            'search'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'no_rak' => 'required',
        ], [
            'required' => 'Form wajib diisi'
        ]);

        category::create($request->only('category', 'no_rak'));

        return redirect('/category')->with(
            'message',
            
            'Kategori berhasil disimpan'
        );
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category' => 'required|string',
            'no_rak' => 'required'
        ]);

        $category = category::find($id);
        $category->update($request->only('category','no_rak'));

        toast('Berhasil', 'success');
        return redirect('/category');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = category::find($id);
        $delete->delete();

        Alert::success('OK', 'category berhasil dihapus!');
        return redirect('/category');
    }

}
