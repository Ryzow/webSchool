@extends('school.main')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 fw-bold text-center">📊 Dashboard Sekolah</h1>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card shadow border-0 text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Siswa</h5>
                            <p class="fs-2">{{ $jumlahSiswa }}</p>
                        </div>
                        <i class="bi bi-people-fill fs-1"></i>
                    </div>
                    <a href="{{ route('siswa.index') }}" class="btn btn-sm btn-light mt-3">Kelola Siswa</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0 text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Guru</h5>
                            <p class="fs-2">{{ $jumlahGuru }}</p>
                        </div>
                        <i class="bi bi-person-badge-fill fs-1"></i>
                    </div>
                    <a href="{{ route('guru.index') }}" class="btn btn-sm btn-light mt-3">Kelola Guru</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0 text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Kelas</h5>
                            <p class="fs-2">{{ $jumlahKelas }}</p>
                        </div>
                        <i class="bi bi-door-open-fill fs-1"></i>
                    </div>
                    <a href="{{ route('kelas.index') }}" class="btn btn-sm btn-light mt-3">Kelola Kelas</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0 text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Mapel</h5>
                            <p class="fs-2">{{ $jumlahMapel }}</p>
                        </div>
                        <i class="bi bi-journal-bookmark-fill fs-1"></i>
                    </div>
                    <a href="{{ route('mapel.index') }}" class="btn btn-sm btn-light mt-3">Kelola Mapel</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-light fw-bold">Statistik Sekolah</div>
                <div class="card-body">
                    <canvas id="schoolChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('schoolChart').getContext('2d');
    const schoolChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: 'Jumlah Data',
                data: {!! json_encode($chartData['data']) !!},
                backgroundColor: [
                    'rgba(13, 110, 253, 0.7)',
                    'rgba(25, 135, 84, 0.7)',
                    'rgba(13, 202, 240, 0.7)',
                    'rgba(255, 193, 7, 0.7)'
                ],
                borderColor: [
                    'rgba(13, 110, 253, 1)',
                    'rgba(25, 135, 84, 1)',
                    'rgba(13, 202, 240, 1)',
                    'rgba(255, 193, 7, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
