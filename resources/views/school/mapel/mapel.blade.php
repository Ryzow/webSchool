@extends('school.main')

@section('content')
    <div class="bg-light border-start border-5 border-primary rounded px-4 py-3 mb-4 mt-4 shadow-sm">
        <h2 class="mb-0 text-dark">
            <i class="bi bi-journals me-2 text-primary"></i> Daftar Mapel
        </h2>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tombol + Search -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 my-3">
        <button type="button" class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#modalCreate">
            <i class="bi bi-plus-lg"></i> Tambah Mapel
        </button>

        <form action="{{ route('mapel.index') }}" method="GET" class="d-flex gap-2 search-modern" role="search" style="min-width: 300px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau kode..."
                value="{{ request('search') }}" autocomplete="off">
            <button type="submit" class="btn btn-outline-primary btn-modern" title="Cari">
                <i class="bi bi-search"></i>
            </button>
            <button type="button" id="btnRefresh" class="btn btn-outline-secondary btn-modern" title="Refresh">
                <i class="bi bi-arrow-clockwise"></i>
            </button>
        </form>
    </div>

    <!-- Tabel di dalam Card -->
    <div class="card card-custom mt-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-modern mb-0">
                <thead class="text-center">
                    <tr>
                        <th style="width:5%;">No</th>
                        <th>Nama</th>
                        <th style="width:15%;">Kode</th>
                        <th style="width:15%;">Tingkatan</th>
                        <th style="width:15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mapels as $index => $mapel)
                        <tr class="text-center">
                            <td>{{ $mapels->firstItem() + $index }}</td>
                            <td class="text-start">{{ $mapel->nama }}</td>
                            <td><span class="fw-semibold">{{ $mapel->kode }}</span></td>
                            <td><span class="badge-tingkatan">{{ $mapel->tingkatan }}</span></td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm me-1 btn-modern" title="Edit"
                                    data-bs-target="#modalEdit" data-bs-toggle="modal" data-id="{{ $mapel->id }}"
                                    data-nama="{{ $mapel->nama }}" data-kode="{{ $mapel->kode }}"
                                    data-tingkatan="{{ $mapel->tingkatan }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('mapel.destroy', $mapel->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin mau hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm btn-modern" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center fst-italic text-muted">Belum ada data mapel.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $mapels->links() }}
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formCreateMapel" action="{{ route('mapel.store') }}" method="POST" novalidate>
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCreateLabel">Tambah Mapel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_create" class="form-label">Nama</label>
                            <input type="text" id="nama_create" name="nama" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="kode_create" class="form-label">Kode</label>
                            <input type="text" id="kode_create" name="kode" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="tingkatan_create" class="form-label">Tingkatan</label>
                            <select id="tingkatan_create" name="tingkatan" class="form-select" required>
                                <option value="" disabled selected>Pilih Tingkatan</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnCreateSubmit">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"
                                id="spinnerCreate"></span>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEditMapel" method="POST" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditLabel">Edit Mapel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_edit" class="form-label">Nama</label>
                            <input type="text" id="nama_edit" name="nama" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="kode_edit" class="form-label">Kode</label>
                            <input type="text" id="kode_edit" name="kode" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="tingkatan_edit" class="form-label">Tingkatan</label>
                            <select id="tingkatan_edit" name="tingkatan" class="form-select" required>
                                <option value="" disabled selected>Pilih Tingkatan</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success" id="btnEditSubmit">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"
                                id="spinnerEdit"></span>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<style>
    /* Card & Table */
    .card-custom {
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .table-modern thead {
        background: linear-gradient(90deg, #004dd1, #2563eb);
        color: white;
        font-weight: bold;
    }

    .table-modern tbody tr:hover {
        background-color: rgba(0, 77, 209, 0.05);
        transition: background 0.3s ease;
    }

    .badge-tingkatan {
        background: linear-gradient(135deg, #6366f1, #3b82f6);
        color: white;
        padding: 5px 10px;
        font-size: 0.85rem;
        border-radius: 8px;
    }

    /* Search Bar & Buttons */
    .search-modern input {
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .btn-modern {
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .btn-modern:hover {
        transform: translateY(-1px);
    }

    /* Modal Modern */
    .modal-content {
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .modal-header {
        background: linear-gradient(90deg, #004dd1, #2563eb);
        color: white;
        border-bottom: none;
    }
    .modal-footer {
        border-top: none;
    }
</style>



@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tooltip init
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Modal Edit data population
            const modalEdit = document.getElementById('modalEdit');
            const baseUrl = "{{ url('data/mapel') }}";

            modalEdit.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');
                const kode = button.getAttribute('data-kode');
                const tingkatan = button.getAttribute('data-tingkatan');

                document.getElementById('nama_edit').value = nama;
                document.getElementById('kode_edit').value = kode;
                document.getElementById('tingkatan_edit').value = tingkatan;

                const form = document.getElementById('formEditMapel');
                form.action = `${baseUrl}/${id}`;

                // Remove spinner and enable button on modal open
                toggleButtonSpinner('btnEditSubmit', 'spinnerEdit', false);
            });

            // Reset form on modalCreate open
            const modalCreate = document.getElementById('modalCreate');
            modalCreate.addEventListener('show.bs.modal', function() {
                const formCreate = document.getElementById('formCreateMapel');
                formCreate.reset();
                toggleButtonSpinner('btnCreateSubmit', 'spinnerCreate', false);
            });

            // Show spinner on submit form Create
            document.getElementById('formCreateMapel').addEventListener('submit', function() {
                toggleButtonSpinner('btnCreateSubmit', 'spinnerCreate', true);
            });

            // Show spinner on submit form Edit
            document.getElementById('formEditMapel').addEventListener('submit', function() {
                toggleButtonSpinner('btnEditSubmit', 'spinnerEdit', true);
            });

            // Refresh button clears search input and submits form
            document.getElementById('btnRefresh').addEventListener('click', function() {
                const form = this.closest('form');
                form.querySelector('input[name="search"]').value = '';
                form.submit();
            });

            // Fungsi toggle spinner dan disable button
            function toggleButtonSpinner(buttonId, spinnerId, isLoading) {
                const btn = document.getElementById(buttonId);
                const spinner = document.getElementById(spinnerId);
                if (isLoading) {
                    btn.setAttribute('disabled', 'disabled');
                    spinner.classList.remove('d-none');
                } else {
                    btn.removeAttribute('disabled');
                    spinner.classList.add('d-none');
                }
            }
        });
    </script>
@endsection
