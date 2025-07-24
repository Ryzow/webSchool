@extends('main')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/books') }}">Book</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Book</li>
        </ol>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Form</div>
                    <div class="card-body">
                        <form action="{{ url('/books/add') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="kategori">Kategori</label>
                                    <select name="kategori" id="kategori"
                                        class="form-control @error('kategori') is-invalid @enderror">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($getCategory as $item)
                                            <option value="{{ $item->id }}">{{ $item->category }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="nama_buku">Nama Buku</label>
                                    <input type="text" name="nama_buku" id="nama_buku"
                                        class="form-control @error('nama_buku') is-invalid @enderror">
                                    @error('nama_buku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="nama_pengarang">Nama Pengarang</label>
                                    <input type="text" name="nama_pengarang" id="nama_pengarang"
                                        class="form-control @error('nama_pengarang') is-invalid @enderror">
                                    @error('nama_pengarang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="nama_penerbit">Nama Penerbit</label>
                                    <input type="text" name="nama_penerbit" id="nama_penerbit"
                                        class="form-control @error('nama_penerbit') is-invalid @enderror">
                                    @error('nama_penerbit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="tahun_terbit">Tahun Terbit</label>
                                    <select name="tahun_terbit" id="tahun_terbit"
                                        class="form-control @error('tahun_terbit') is-invalid @enderror">
                                        <option value="">Pilih Tahun Terbit</option>
                                        @for ($i = date('Y'); $i >= 1800; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
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
                                    <img src="" alt="Preview Gambar" id="gambar-preview" class="mt-3"
                                        style="display: none; max-height: 200px;">
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="reset" class="btn btn-warning">Reset</button>
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
