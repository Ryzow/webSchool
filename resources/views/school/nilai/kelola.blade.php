@extends('school.main')

@section('content')
    <div class="card shadow-sm p-4">
        <h4 class="fw-bold mb-3 text-dark">
            <i class="bi bi-pencil-square me-2"></i> Kelola Nilai - {{ $mapel->nama }} ({{ $kelas->nama }})
        </h4>

        @if (session('success'))
            <div class="alert alert-success mt-2 shadow-sm">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif

        <form action="{{ route('nilai.simpan', [$kelas->id, $mapel->id]) }}" method="POST">
            @csrf
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-success text-center">
                        <tr>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Harian</th>
                            <th>Tugas</th>
                            <th>UTS</th>
                            <th>UAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswas as $siswa)
                            <tr class="text-center">
                                <td class="text-start">{{ $siswa->nama }}</td>
                                <td>{{ $siswa->nis }}</td>
                                <td>
                                    <input type="number" name="nilai[{{ $siswa->id }}][harian]" class="form-control form-control-sm"
                                        value="{{ old("nilai.{$siswa->id}.harian", $nilaiMap[$siswa->id]->harian ?? '') }}" min="0" max="100">
                                </td>
                                <td>
                                    <input type="number" name="nilai[{{ $siswa->id }}][tugas]" class="form-control form-control-sm"
                                        value="{{ old("nilai.{$siswa->id}.tugas", $nilaiMap[$siswa->id]->tugas ?? '') }}" min="0" max="100">
                                </td>
                                <td>
                                    <input type="number" name="nilai[{{ $siswa->id }}][uts]" class="form-control form-control-sm"
                                        value="{{ old("nilai.{$siswa->id}.uts", $nilaiMap[$siswa->id]->uts ?? '') }}" min="0" max="100">
                                </td>
                                <td>
                                    <input type="number" name="nilai[{{ $siswa->id }}][uas]" class="form-control form-control-sm"
                                        value="{{ old("nilai.{$siswa->id}.uas", $nilaiMap[$siswa->id]->uas ?? '') }}" min="0" max="100">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-success mt-3 shadow-sm" data-bs-toggle="tooltip" title="Simpan semua perubahan nilai siswa">
                <i class="bi bi-save me-1"></i> Simpan Nilai
            </button>
        </form>
    </div>
@endsection
