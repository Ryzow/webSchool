{{-- @for ($i = 0; $i < 20; $i++)
        <a href="{{ url('/dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }} mb-3">
            <i class="bi bi-house"></i> Dashboard
        </a>
    @endfor --}}

<a href="{{ url('/dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }} mb-3">
    <i class="bi bi-house"></i> Dashboard
</a>

<hr>

{{-- <p class="text-center bg-primary rounded text-dark">Master Data</p> --}}

<a href="{{ url('/data/mapel') }}" class="{{ Request::is('data/mapel') ? 'active' : '' }}">
    <i class="bi bi-journals"></i> Data Mapel
</a>

<a href="{{ url('/data/guru') }}" class="{{ Request::is('data/guru*') ? 'active' : '' }}">
    <i class="bi bi-mortarboard"></i> Data Guru
</a>

<a href="{{ url('/data/kelas') }}" class="{{ Request::is('data/kelas*') ? 'active' : '' }}">
    <i class="bi bi-database"></i> Data Kelas
</a>


{{-- <p class="text-center bg-primary rounded text-dark">Siswa</p> --}}

<a href="{{ url('/data/siswa') }}" class="{{ Request::is('data/siswa*') ? 'active' : '' }}">
    <i class="bi bi-people-fill"></i> Data Siswa
</a>

<hr>

<a href="{{ url('/user/nilai') }}" class="{{ Request::is('user/nilai') ? 'active' : '' }}">
    <i class="bi bi-file-earmark-medical"></i> Nilai Saya
</a>

<a href="{{ url('/kegiatan') }}" class="{{ Request::is('kegiatan') ? 'active' : '' }}">
    <i class="bi bi-book"></i> Data Kegiatan
</a>

<a href="{{ url('/admin/feedback') }}" class="{{ Request::is('admin/feedback') ? 'active' : '' }}">
    <i class="bi bi-book"></i> Data Feedback
</a>

<hr>

<a href="{{ url('/book') }}" class="{{ Request::is('book') ? 'active' : '' }}">
    <i class="bi bi-plus"></i> Data Buku
</a>
