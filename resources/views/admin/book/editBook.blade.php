@extends('main')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/books') }}">Book</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Book</li>
        </ol>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Form</div>
                    <div class="card-body">
                        <form action="{{ url('/books/edit/' . $book->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')


                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="kategori">Kategori</label>
                                    <select name="kategori" id="kategori" class="form-control">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($getCategory as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $book->kategori == $item->id ? 'selected' : '' }}>
                                                {{ $item->category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="nama_buku">Nama Buku</label>
                                    <input type="text" name="nama_buku" id="nama_buku"
                                        class="form-control @error('nama_buku') is-invalid @enderror"
                                        value="{{ old('nama_buku', $book->nama_buku) }}">
                                    @error('nama_buku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="nama_pengarang">Nama Pengarang</label>
                                    <input type="text" name="nama_pengarang" id="nama_pengarang"
                                        class="form-control @error('nama_pengarang') is-invalid @enderror"
                                        value="{{ old('nama_pengarang', $book->nama_pengarang) }}">
                                    @error('nama_pengarang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="nama_penerbit">Nama Penerbit</label>
                                    <input type="text" name="nama_penerbit" id="nama_penerbit"
                                        class="form-control @error('nama_penerbit') is-invalid @enderror"
                                        value="{{ old('nama_penerbit', $book->nama_penerbit) }}">
                                    @error('nama_penerbit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="tahun_terbit">Tahun Terbit</label>
                                    <select name="tahun_terbit" id="tahun_terbit"
                                        class="form-control @error('tahun_terbit') is-invalid @enderror">
                                        <option value="">Pilih Tahun Terbit</option>
                                        @for ($i = date('Y'); $i >= 1900; $i--)
                                            <option value="{{ $i }}"
                                                {{ $book->tahun_terbit == $i ? 'selected' : '' }}>{{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('tahun_terbit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="gambar">Upload Gambar Buku</label>
                                    <input type="file" name="gambar" accept="image/*" class="form-control"
                                        onchange="previewImage(event)">
                                    @if ($book->gambar)
                                        <img src="{{ asset('storage/' . $book->gambar) }}" alt="Preview" class="mt-3"
                                            style="max-height: 200px;">
                                    @endif
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ url('/books') }}" class="btn btn-warning">Kembali</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(e) {
            const input = e.target;
            const previewImage = document.getElementById('gambar-preview');
            const reader = new FileReader();

            reader.onload = function() {
                previewImage.src = reader.result;
                previewImage.style.display = 'block';
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
