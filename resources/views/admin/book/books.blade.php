@extends('main')

@section('content')
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col">

                <div class="row mb-3">
                    <div class="col">
                        <div class="text-end">
                            <a href="{{ url('/books/add') }}" class="btn btn-primary">
                                <i class="bi bi-plus"></i> Add Book
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><strong>Daftar Buku</strong></div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-4 ms-auto d-flex align-items-center">
                                <form action="{{ url('/books') }}" class="d-flex w-100 gap-2" method="get">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="form-control me-2" placeholder="Search...">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a href="{{ url('/books') }}" class="btn btn-warning">Refresh</a>
                                </form>
                            </div>
                        </div>

                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Picture</th>
                                    <th>Judul</th>
                                    <th>Pengarang</th>
                                    <th>Penerbit</th>
                                    <th>Tahun Terbit</th>
                                    <th>Category</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($books as $index => $book)
                                    <tr class="text-center">
                                        <td>{{ ($books->currentPage() - 1) * $books->perPage() + $loop->iteration }}</td>
                                        <td>
                                            @if (Str::startsWith($book->gambar, ['http://', 'https://']))
                                                <img src="{{ $book->gambar }}" alt="" width="60">
                                            @else
                                                <img src="{{ asset('storage/'. $book->gambar) }}" alt="" width="60">

                                            @endif
                                        </td>
                                        <td class="text-center">{{ $book->nama_buku }}</td>
                                        <td class="text-center">{{ $book->nama_pengarang }}</td>
                                        <td class="text-center">{{ $book->nama_penerbit }}</td>
                                        <td class="text-center">{{ $book->tahun_terbit }}</td>
                                        <td class="text-center">{{ $categories[$book->kategori]->category ?? 'Tidak diketahui' }}</td>
                                        <td class="text-center">
                                            <a href="{{ url('/books/edit/' . $book->id) }}" class="btn btn-warning btn-sm"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ url('/books/'.$book->id) }}" method="post"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus" onclick="return confirm('Yakin ingin menghapus buku ini?')"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data buku.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-3">
                            {{ $books->links() }}
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
