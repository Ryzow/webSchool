@extends('school.main')

@section('content')
    <div class="bg-light border-start border-5 border-info rounded px-4 py-2 mb-4 mt-4 shadow-sm">
        <h2 class="mb-0 text-dark">
            <i class="bi bi-people-fill text-info me-2"></i> Daftar Siswa
        </h2>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap my-3 gap-2">
        <button class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#modalCreate">
            <i class="bi bi-plus-lg"></i> Tambah Siswa
        </button>

        <form action="{{ route('siswa.index') }}" method="GET" class="d-flex gap-2" style="min-width: 300px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau NIS..."
                value="{{ request('search') }}" autocomplete="off">
            <button type="submit" class="btn btn-outline-info">
                <i class="bi bi-search"></i>
            </button>
            <button type="button" id="btnRefresh" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-clockwise"></i>
            </button>
        </form>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-info text-center">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>Kelas</th>
                    <th>Tahun Ajaran</th>
                    <th style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($siswas as $index => $siswa)
                    <tr class="text-center align-middle">
                        <td>{{ $siswas->firstItem() + $index }}</td>
                        <td class="text-start">{{ $siswa->nama }}</td>
                        <td>{{ $siswa->nis }}</td>
                        <td>
                            <span class="badge bg-{{ $siswa->jk === 'Laki-laki' ? 'primary' : 'warning' }} text-white">
                                {{ $siswa->jk }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') }}</td>
                        <td>{{ $siswa->kelas->nama ?? '-' }}</td>
                        <td>{{ $siswa->tahun_ajaran }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modalEdit"
                                data-id="{{ $siswa->id }}" data-nama="{{ $siswa->nama }}" data-nis="{{ $siswa->nis }}"
                                data-jk="{{ $siswa->jk }}" data-tanggal_lahir="{{ $siswa->tanggal_lahir }}"
                                data-kelas_id="{{ $siswa->kelas_id }}" data-tahun_ajaran="{{ $siswa->tahun_ajaran }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin hapus siswa ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center fst-italic">Belum ada data siswa.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $siswas->links() }}
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('siswa.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateLabel">Tambah Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIS</label>
                        <input type="text" name="nis" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jk" class="form-select" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <select name="kelas_id" class="form-select" required>
                            <option value="" disabled selected>Pilih Kelas</option>
                            @foreach ($kelases as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-info text-white" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formEditSiswa" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" id="edit_nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIS</label>
                        <input type="text" name="nis" id="edit_nis" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jk" id="edit_jk" class="form-select" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="edit_tanggal_lahir" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <select name="kelas_id" id="edit_kelas_id" class="form-select" required>
                            @foreach ($kelases as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" id="edit_tahun_ajaran" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-info text-white" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalEdit = document.getElementById('modalEdit');
            const formEdit = document.getElementById('formEditSiswa');
            const baseUrl = "{{ url('data/siswa') }}";

            modalEdit.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                document.getElementById('edit_nama').value = button.getAttribute('data-nama');
                document.getElementById('edit_nis').value = button.getAttribute('data-nis');
                document.getElementById('edit_jk').value = button.getAttribute('data-jk');
                document.getElementById('edit_tanggal_lahir').value = button.getAttribute('data-tanggal_lahir');
                document.getElementById('edit_kelas_id').value = button.getAttribute('data-kelas_id');
                document.getElementById('edit_tahun_ajaran').value = button.getAttribute('data-tahun_ajaran');
                formEdit.action = `${baseUrl}/${id}`;
            });

            document.getElementById('btnRefresh').addEventListener('click', function () {
                const form = this.closest('form');
                form.querySelector('input[name="search"]').value = '';
                form.submit();
            });
        });
    </script>
@endsection