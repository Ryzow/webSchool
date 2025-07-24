@extends('school.main')

@section('content')
<div class="container py-4">
    <!-- Header Card -->
    <div class="card shadow-sm border-0 mb-4 bg-success-subtle">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h3 class="fw-bold text-success-emphasis mb-1">
                    <i class="bi bi-mortarboard-fill me-2"></i> Nilai Siswa
                </h3>
                <p class="mb-0 text-muted fw-medium">
                    {{ $siswa->nama }} &bull; Kelas {{ $kelas->nama }}
                </p>
            </div>
            <a href="{{ route('user.nilai.index') }}" class="btn btn-outline-success mt-2 mt-md-0">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-success text-center">
                        <tr>
                            <th class="text-start">Mata Pelajaran</th>
                            <th>Harian</th>
                            <th>Tugas</th>
                            <th>UTS</th>
                            <th>UAS</th>
                            <th>Rata‑rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nilais as $nilai)
                            @php
                                $avg = ($nilai->harian + $nilai->tugas + $nilai->uts + $nilai->uas) / 4;
                                $bg   = $avg >= 90 ? 'success' : ($avg >= 75 ? 'primary' : ($avg >= 60 ? 'warning' : 'danger'));
                            @endphp
                            <tr class="text-center">
                                <td class="text-start fw-medium">{{ $nilai->mapel->nama }}</td>
                                <td>{{ $nilai->harian }}</td>
                                <td>{{ $nilai->tugas }}</td>
                                <td>{{ $nilai->uts }}</td>
                                <td>{{ $nilai->uas }}</td>
                                <td>
                                    <span class="badge bg-{{ $bg }} bg-opacity-75 fs-6">
                                        {{ number_format($avg, 2) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada nilai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
