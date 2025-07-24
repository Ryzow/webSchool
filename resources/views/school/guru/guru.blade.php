@extends('school.main')

@section('content')

    {{-- ================= LOGIN GURU ================= --}}
    @if (!session('guru_id') && !session('admin_id'))
        {{-- FORM LOGIN --}}
        <div class="card shadow-sm p-4 mb-4">
            <h4 class="mb-3">Login Guru</h4>
            @if (session('login_error'))
                <div class="alert alert-danger">{{ session('login_error') }}</div>
            @endif
            <form action="{{ route('guru.login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="login" class="form-label">Nama atau NIP</label>
                    <input type="text" name="login" id="login" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button class="btn btn-success">Login</button>
            </form>
        </div>

        @elseif (session('admin_id'))
        {{-- ================= HANYA UNTUK ADMIN ================= --}}
        <div class="bg-light border-start border-5 border-success rounded px-4 py-2 mb-4 mt-4 shadow-sm">
            <h2 class="mb-0 text-dark">
                <i class="bi bi-person-vcard text-success me-2"></i> Daftar Guru
            </h2>
        </div>

        <div class="card shadow-sm p-4 mb-4">
            <h5 class="mb-3">Atur Guru Mengajar di Kelas</h5>
            <form action="{{ route('guru.relasimapel') }}" method="POST">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Guru</label>
                        <select name="guru_id" class="form-select" required>
                            <option value="" disabled selected>Pilih Guru</option>
                            @foreach ($gurus as $g)
                                <option value="{{ $g->id }}">{{ $g->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Mapel</label>
                        <select name="mapel_id" class="form-select" required>
                            <option value="" disabled selected>Pilih Mapel</option>
                            @foreach ($mapels as $m)
                                <option value="{{ $m->id }}">{{ $m->nama }} - {{ $m->kode }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kelas</label>
                        <select name="kelas_id" class="form-select" required>
                            @foreach (\App\Models\Kelas::all() as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-success w-100"><i class="bi bi-check2"></i></button>
                    </div>
                </div>
            </form>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center flex-wrap my-3 gap-2">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCreate">
                <i class="bi bi-plus-lg"></i> Tambah Guru
            </button>

            <form action="{{ route('guru.index') }}" method="GET" class="d-flex gap-2" style="min-width: 300px;">
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau NIP..."
                    value="{{ request('search') }}" autocomplete="off">
                <button type="submit" class="btn btn-outline-success">
                    <i class="bi bi-search"></i>
                </button>
                <button type="button" id="btnRefresh" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise"></i>
                </button>
            </form>
        </div>

        <div class="table-responsive shadow-sm rounded">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-success text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Mata Pelajaran</th>
                        <th>Jenis Kelamin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($gurus as $index => $guru)
                        <tr class="text-center align-middle">
                            <td>{{ $gurus->firstItem() + $index }}</td>
                            <td class="text-start">{{ $guru->nama }}</td>
                            <td>{{ $guru->nip }}</td>
                            <td>{{ $guru->mapel->nama ?? '-' }} - {{ $guru->mapel->kode }}</td>
                            <td>
                                <span class="badge bg-{{ $guru->jk === 'Laki-laki' ? 'primary' : 'warning' }} text-white">
                                    {{ $guru->jk }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal"
                                    data-bs-target="#modalEdit"
                                    data-id="{{ $guru->id }}"
                                    data-nama="{{ $guru->nama }}"
                                    data-nip="{{ $guru->nip }}"
                                    data-mapel="{{ $guru->mapel_id }}"
                                    data-sejak="{{ $guru->mengajar_sejak }}"
                                    data-jk="{{ $guru->jk }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('guru.destroy', $guru->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin hapus guru ini?')">
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
                            <td colspan="6" class="text-center fst-italic">Belum ada data guru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <form action="{{ route('guru.logout') }}" method="POST">
            @csrf
            <button class="btn btn-danger">Logout</button>
        </form>

        <div class="d-flex justify-content-center mt-3">
            {{ $gurus->links() }}
        </div>

    {{-- ================= UNTUK GURU BIASA ================= --}}
    @elseif (session('guru_id'))
        <div class="card shadow-sm p-4 mb-4 d-flex flex-md-row align-items-center gap-4">
            <img src="{{ asset('storage/foto/' . session('guru_foto')) }}" alt="Foto Guru" class="rounded-circle"
                width="80" height="80">
            <div>
                <h4 class="mb-1">{{ session('guru_nama') }}</h4>
                <p class="mb-0 text-muted">Mengajar sejak {{ session('guru_sejak') ?? '-' }}</p>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">Kelas yang Diajarkan</div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelasMapelGuru as $item)
                            <tr>
                                <td>{{ $item->kelas->nama }}</td>
                                <td>{{ $item->mapel->nama }}</td>
                                <td>
                                    <a href="{{ route('nilai.kelola', ['kelas' => $item->kelas->id, 'mapel' => $item->mapel->id]) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        Kelola Nilai
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <form action="{{ route('guru.logout') }}" method="POST">
            @csrf
            <button class="btn btn-danger">Logout</button>
        </form>
    @endif

    <!-- Modal Create -->
    <div class="modal fade @if ($errors->any() && old('_open_modal') === 'create') show d-block @endif" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true" style="@if ($errors->any() && old('_open_modal') === 'create') display:block; background-color:rgba(0,0,0,.5); @endif">
        <div class="modal-dialog">
            <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
                @csrf
                <input type="hidden" name="_open_modal" value="create">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateLabel">Tambah Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_create" class="form-label">Nama</label>
                        <input type="text" id="nama_create" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nip_create" class="form-label">NIP</label>
                        <input type="text" id="nip_create" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}" required>
                        @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_create" class="form-label">Password</label>
                        <input type="password" id="password_create" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mengajar_sejak_create" class="form-label">Mengajar Sejak</label>
                        <input type="number" id="mengajar_sejak_create" name="mengajar_sejak" class="form-control @error('mengajar_sejak') is-invalid @enderror" min="2000" max="{{ date('Y') }}" value="{{ old('mengajar_sejak') }}">
                        @error('mengajar_sejak') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="foto_create" class="form-label">Foto (Opsional)</label>
                        <input type="file" id="foto_create" name="foto" class="form-control @error('foto') is-invalid @enderror">
                        @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mapel_create" class="form-label">Mata Pelajaran</label>
                        <select name="mapel_id" id="mapel_create" class="form-select @error('mapel_id') is-invalid @enderror" required>
                            <option value="" disabled selected>Pilih Mapel</option>
                            @foreach ($mapels as $mapel)
                                <option value="{{ $mapel->id }}" {{ old('mapel_id') == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->nama }} - {{ $mapel->kode }}
                                </option>
                            @endforeach
                        </select>
                        @error('mapel_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jk_create" class="form-label">Jenis Kelamin</label>
                        <select name="jk" id="jk_create" class="form-select @error('jk') is-invalid @enderror" required>
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jk') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jk') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success" type="submit" id="btnCreateSubmit">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="spinnerCreate"></span>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="formEditGuru" class="modal-content" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Edit Guru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label for="nama_edit" class="form-label">Nama</label>
                    <input type="text" id="nama_edit" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="nip_edit" class="form-label">NIP</label>
                    <input type="text" id="nip_edit" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}">
                    @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="mapel_edit" class="form-label">Mata Pelajaran</label>
                    <select name="mapel_id" id="mapel_edit" class="form-select @error('mapel_id') is-invalid @enderror">
                        @foreach ($mapels as $mapel)
                            <option value="{{ $mapel->id }}" {{ old('mapel_id') == $mapel->id ? 'selected' : '' }}>
                                {{ $mapel->nama }} - {{ $mapel->kode }}
                            </option>
                        @endforeach
                    </select>
                    @error('mapel_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="password_edit" class="form-label">Password</label>
                    <input type="password" name="password" id="password_edit" class="form-control @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak diubah">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="mengajar_sejak_edit" class="form-label">Mengajar Sejak</label>
                    <input type="number" id="mengajar_sejak_edit" name="mengajar_sejak" class="form-control @error('mengajar_sejak') is-invalid @enderror" min="2000" max="{{ date('Y') }}" value="{{ old('mengajar_sejak') }}">
                    @error('mengajar_sejak') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="foto_edit" class="form-label">Foto (Opsional)</label>
                    <input type="file" id="foto_edit" name="foto" class="form-control @error('foto') is-invalid @enderror">
                    @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="jk_edit" class="form-label">Jenis Kelamin</label>
                    <select name="jk" id="jk_edit" class="form-select @error('jk') is-invalid @enderror">
                        <option value="Laki-laki" {{ old('jk') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jk') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-success" type="submit" id="btnEditSubmit">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="spinnerEdit"></span>
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')

    @if ($errors->any() && old('_open_modal') === 'create')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var modalCreate = new bootstrap.Modal(document.getElementById('modalCreate'));
                modalCreate.show();
            });
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalEdit = document.getElementById('modalEdit');
            const modalCreate = document.getElementById('modalCreate');
            const formEdit = document.getElementById('formEditGuru');
            const formCreate = document.querySelector('form[action="{{ route('guru.store') }}"]');
            const baseUrl = "{{ url('data/guru') }}";

            // Saat modal Edit muncul, isi datanya
            modalEdit.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');
                const nip = button.getAttribute('data-nip');
                const mapelId = button.getAttribute('data-mapel');
                const sejak = button.getAttribute('data-sejak');
                const jk = button.getAttribute('data-jk');


                formEdit.action = `${baseUrl}/${id}`;
                document.getElementById('mengajar_sejak_edit').value = sejak ?? '';
                document.getElementById('jk_edit').value = jk;
                document.getElementById('nama_edit').value = nama;
                document.getElementById('nip_edit').value = nip;
                document.getElementById('mapel_edit').value = mapelId;

                toggleButtonSpinner('btnEditSubmit', 'spinnerEdit', false);
            });

            // Saat modal Create dibuka, reset form-nya
            modalCreate.addEventListener('show.bs.modal', function() {
                formCreate.reset();
                toggleButtonSpinner('btnCreateSubmit', 'spinnerCreate', false);
            });

            // Saat form Create disubmit
            formCreate.addEventListener('submit', function() {
                toggleButtonSpinner('btnCreateSubmit', 'spinnerCreate', true);
            });

            // Saat form Edit disubmit
            formEdit.addEventListener('submit', function() {
                toggleButtonSpinner('btnEditSubmit', 'spinnerEdit', true);
            });

            // Tombol refresh menghapus input pencarian dan submit
            document.getElementById('btnRefresh').addEventListener('click', function() {
                const form = this.closest('form');
                form.querySelector('input[name="search"]').value = '';
                form.submit();
            });

            // Fungsi toggle loading button + spinner
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
