<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'nis', 'jk', 'kelas_id', 'tanggal_lahir', 'tahun_ajaran'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function nilais() {
        return $this->hasMany(Nilai::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
