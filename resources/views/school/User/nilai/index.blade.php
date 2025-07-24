@extends('school.main')

@section('content')
<div class="card shadow-sm p-4">
    <h4>Cek Nilai Siswa</h4>
    <form action="{{ route('user.nilai.cari') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="kelas_id">Pilih Kelas:</label>
            <select name="kelas_id" class="form-select" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelasList as $kelas)
                    <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="nama">Nama Siswa:</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Cari Nilai</button>
    </form>
</div>
@endsection
