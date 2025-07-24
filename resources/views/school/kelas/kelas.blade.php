@extends('school.main')

@section('content')
    <div class="bg-light border-start border-5 border-success rounded px-4 py-2 mb-4 mt-4 shadow-sm">
        <h2 class="mb-0 text-dark">
            <i class="bi bi-building text-success me-2"></i> Daftar Kelas
        </h2>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tambah + Search -->
    <div class="d-flex justify-content-between align-items-center flex-wrap my-3 gap-2">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCreate">
            <i class="bi bi-plus-lg"></i> Tambah Kelas
        </button>

        <form action="{{ route('kelas.index') }}" method="GET" class="d-flex gap-2" style="min-width: 300px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau jurusan..."
                value="{{ request('search') }}" autocomplete="off">
            <button type="submit" class="btn btn-outline-success"><i class="bi bi-search"></i></button>
            <button type="button" id="btnRefresh" class="btn btn-outline-secondary"><i
                    class="bi bi-arrow-clockwise"></i></button>
        </form>
    </div>

    <!-- Statistik -->
    <hr class="my-4">

    <div class="row mb-4 mt-5">
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success">Total Siswa</h5>
                    <h3>{{ $totalSiswa }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary">Total Kelas</h5>
                    <h3>{{ $totalKelas }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-warning">Total Angkatan</h5>
                    <h3>{{ $totalAngkatan }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-dark shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Siswa Kelas 10</h5>
                    <h3>{{ $totalSiswaX }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-dark shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Siswa Kelas 11</h5>
                    <h3>{{ $totalSiswaXI }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-dark shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Siswa Kelas 12</h5>
                    <h3>{{ $totalSiswaXII }}</h3>
                </div>
            </div>
        </div>
    </div>



    <div class="table-responsive shadow-sm rounded">
        <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-success text-center">
                <tr>
                    <th style="width:5%">No</th>
                    <th>Nama</th>
                    <th style="width:10%">Tingkat</th>
                    <th>Jurusan</th>
                    <th style="width:15%">Tahun Ajaran</th>
                    <th style="width:15%">Wali Kelas</th>
                    <th style="width:15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas as $idx => $k)
                    <tr class="text-center align-middle">
                        <td>{{ $kelas->firstItem() + $idx }}</td>
                        <td class="text-start">{{ $k->nama }}</td>
                        <td>{{ $k->tingkatan }}</td>
                        <td>{{ $k->jurusan }}</td>
                        <td>{{ $k->tahun_ajaran }}</td>
                        <td>{{ $k->wali_kelas ? $k->wali_kelas->nama : '-' }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modalEdit"
                                data-id="{{ $k->id }}" data-nama="{{ $k->nama }}"
                                data-tingkatan="{{ $k->tingkatan }}" data-jurusan="{{ $k->jurusan }}"
                                data-wali="{{ $k->wali_kelas_id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('kelas.destroy', $k->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin hapus kelas ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center fst-italic">Belum ada data kelas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $kelas->links() }}
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('kelas.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_create" class="form-label">Nama Kelas</label>
                        <input type="text" id="nama_create" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="tingkatan_create" class="form-label">Tingkatan</label>
                        <select id="tingkatan_create" name="tingkatan" class="form-select" required>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jurusan_create" class="form-label">Jurusan</label>
                        <input type="text" id="jurusan_create" name="jurusan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="tahun_create" class="form-label">Tahun Ajaran</label>
                        <input type="text" id="tahun_create" name="tahun_ajaran" class="form-control" required
                            value="{{ date('Y') }}/{{ date('Y') + 1 }}">
                    </div>

                    <div class="mb-3">
                        <label for="wali_create" class="form-label">Wali Kelas</label>
                        <select name="wali_kelas_id" id="wali_create" class="form-select">
                            <option value="" selected>-- Tidak Ada --</option>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success" type="submit" id="btnCreateSubmit">
                        <span class="spinner-border spinner-border-sm d-none" role="status" id="spinnerCreate"></span>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formEditKelas" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_edit" class="form-label">Nama Kelas</label>
                        <input type="text" id="nama_edit" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="tingkatan_edit" class="form-label">Tingkatan</label>
                        <select id="tingkatan_edit" name="tingkatan" class="form-select" required>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jurusan_edit" class="form-label">Jurusan</label>
                        <input type="text" id="jurusan_edit" name="jurusan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="tahun_edit" class="form-label">Tahun Ajaran</label>
                        <input type="text" id="tahun_edit" name="tahun_ajaran" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="wali_edit" class="form-label">Wali Kelas</label>
                        <select name="wali_kelas_id" id="wali_edit" class="form-select">
                            <option value="">-- Tidak Ada --</option>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success" type="submit" id="btnEditSubmit">
                        <span class="spinner-border spinner-border-sm d-none" role="status" id="spinnerEdit"></span>
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modalEdit = document.getElementById('modalEdit');
            const modalCreate = document.getElementById('modalCreate');
            const formCreate = modalCreate.querySelector('form');
            const formEdit = document.getElementById('formEditKelas');
            const base = "{{ url('data/kelas') }}";

            modalEdit.addEventListener('show.bs.modal', e => {
                const btn = e.relatedTarget;
                formEdit.action = "{{ route('kelas.update', ':id') }}".replace(':id', btn.dataset.id);
                document.getElementById('nama_edit').value = btn.dataset.nama;
                document.getElementById('tingkatan_edit').value = btn.dataset.tingkatan;
                document.getElementById('jurusan_edit').value = btn.dataset.jurusan;
                document.getElementById('wali_edit').value = btn.dataset.wali || '';
                toggleSpinner('btnEditSubmit', 'spinnerEdit', false);
            });

            modalCreate.addEventListener('show.bs.modal', () => {
                formCreate.reset();
                toggleSpinner('btnCreateSubmit', 'spinnerCreate', false);
            });

            formCreate.addEventListener('submit', () => toggleSpinner('btnCreateSubmit', 'spinnerCreate', true));
            formEdit.addEventListener('submit', () => toggleSpinner('btnEditSubmit', 'spinnerEdit', true));

            document.getElementById('btnRefresh').addEventListener('click', () => {
                const f = document.querySelector('form[action="{{ route('kelas.index') }}"]');
                f.search.value = '';
                f.submit();
            });

            function toggleSpinner(btnId, spnId, loading) {
                const btn = document.getElementById(btnId);
                const spn = document.getElementById(spnId);
                btn.disabled = loading;
                spn.classList.toggle('d-none', !loading);
            }
        });
    </script>
@endsection
