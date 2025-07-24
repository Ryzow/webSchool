@extends('main')

@section('content')
    <div class="container">
        
        <h2 class="text-center">Ini Halaman Book Category</h2>
    
        <div class="row mb-3">
            <div class="col-6 offset-3">
                    <div class="card">
                        <div class="card-header">
                            {{ isset($editCategory) ? 'Edit Book Category' : 'Add Book Category' }}
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($editCategory) ? url('/category/'.$editCategory->id) : url('/category') }}" method="post">
                                @csrf
                                @if(isset($editCategory))
                                    @method('PUT')
                                @endif

                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="category">Type Category</label>
                                        <input type="text" name="category" value="{{ old('category', $editCategory->category ?? '')}}" class="form-control @error('category') is-invalid @enderror">
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col mb-3">
                                        <label for="no_rak">No Rak</label>
                                        <input type="text" name="no_rak" value="{{ old('no_rak', $editCategory->no_rak ?? '' )}}" class="form-control @error('no_rak') is-invalid @enderror">
                                        @error('no_rak')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm" >Save</button>
                                <button type="reset" class="btn btn-warning btn-sm" >Cancel</button>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Daftar Category</div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-4 ms-auto d-flex align-items-center">
                                <form action="{{ url('/category') }}" class="d-flex w-100">
                                    <input type="text" name="search" value="{{ $search }}" class="form-control me-2" placeholder="search">
                                    <button type="submit" class="btn btn-primary">Search</button>

                                    <a href="{{ url('/category') }}" class="btn btn-warning mx-2">
                                        refresh
                                    </a>

                                </form>
                            </div>
                        </div>

                        <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Category</th>
                                    <th>No Rak</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $key => $item)
                                <tr>
                                    <td>{{ (($categories->currentPage()- 1) * $categories->perPage()) + $loop->iteration }}</td>
                                    <td>{{ $item->category }}</td>
                                    <td>RAK - {{ $item->no_rak}}</td>
                                    <td class="text-center">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ url('/category?edit='.$item->id) }}" class="btn btn-warning btn-sm" title="edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        {{-- TombolHapus --}}
                                        <form action="{{ url('/category/'.$item->id) }}" method="post" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Hapus Kategori ini?')" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>    
                                 </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Data Tidak ditemukan!!!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $categories->links() }}
                        {{-- Pagination --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection