@extends('main')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Katalog Buku</h2>

    {{-- Form Filter --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-md-end align-items-md-end gap-2">
                <form method="GET" action="{{ url('/book') }}" class="d-flex flex-column flex-md-row gap-2 w-100 w-md-auto">
                    <select name="kategori" class="form-select" style="min-width: 180px;">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->category }}
                            </option>
                        @endforeach
                    </select>

                    <select name="tahun" class="form-select" style="min-width: 150px;">
                        <option value="">-- Semua Tahun --</option>
                        @foreach($tahunList as $th)
                            <option value="{{ $th }}" {{ request('tahun') == $th ? 'selected' : '' }}>
                                {{ $th }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>

                <a href="{{ url('/book') }}" class="btn btn-warning">Refresh</a>
            </div>
        </div>
    </div>


    {{-- Katalog Buku --}}
    <div class="row">
        @forelse($books as $book)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow rounded">
                    <div class="container d-flex justify-content-center mt-2">
                        @if(Str::startsWith($book->gambar, ['http://', 'https://']))
                            <img src="{{ $book->gambar }}" class="card-img-top shadow" alt="{{ $book->nama_buku }}"
                                style="object-fit: cover; width: 150px; height: 200px;">
                        @else
                            <img src="{{ asset('storage/' . $book->gambar) }}" class="card-img-top shadow" alt="{{ $book->nama_buku }}"
                                style="object-fit: cover; width: 150px; height: 200px;">
                        @endif
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">{{ $book->nama_buku }}</h5>
                        <p class="card-text">
                            <strong>Tahun Terbit:</strong> {{ $book->tahun_terbit }}<br>
                        </p>
                    </div>
                    
                    <div class="card-footer text-end bg-white border-0">
                        <a href="javascript:void(0)" 
                            class="btn btn-sm btn-primary btn-detail-buku"
                            data-bs-toggle="modal" 
                            data-bs-target="#detailBukuModal"
                            data-id="{{ $book->id }}"
                            data-nama="{{ $book->nama_buku }}"
                            data-pengarang="{{ $book->nama_pengarang }}"
                            data-penerbit="{{ $book->nama_penerbit }}"
                            data-tahun="{{ $book->tahun_terbit }}"
                            data-kategori="{{ $book->getCategory->category }}"
                            data-gambar="{{ Str::startsWith($book->gambar, ['http://', 'https://']) ? $book->gambar : asset('storage/' . $book->gambar) }}">
                            Lihat Detail
                        </a>
                        @include('screen.detailbook')
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Tidak ada buku yang ditemukan dengan filter tersebut.
                </div>
            </div>
        @endforelse
    </div>
        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $books->links() }}
        </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const detailButtons = document.querySelectorAll('.btn-detail-buku');

        detailButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('modalNama').textContent = this.dataset.nama;
                document.getElementById('modalPengarang').textContent = this.dataset.pengarang;
                document.getElementById('modalPenerbit').textContent = this.dataset.penerbit;
                document.getElementById('modalTahun').textContent = this.dataset.tahun;
                document.getElementById('modalKategori').textContent = this.dataset.kategori;
                document.getElementById('modalGambar').src = this.dataset.gambar;
            });
        });
    });
</script>

@endsection