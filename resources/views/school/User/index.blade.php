@extends('school.main')

@section('content')
<div class="container mt-4">
    <h4>Nilai Saya</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mata Pelajaran</th>
                <th>Guru</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($nilais as $nilai)
                <tr>
                    <td>{{ $nilai->mapel->nama }}</td>
                    <td>{{ $nilai->guru->nama }}</td>
                    <td>{{ $nilai->nilai_uts }}</td>
                    <td>{{ $nilai->nilai_uas }}</td>
                    <td>{{ $nilai->nilai_akhir ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada data nilai.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
