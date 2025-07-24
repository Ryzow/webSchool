<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class book extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori',
        'nama_buku',
        'nama_pengarang',
        'nama_penerbit',
        'tahun_terbit',
        'gambar'
    ];

    /**
     * Get the getCategory that owns the book
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getCategory(): BelongsTo
    {
        return $this->belongsTo(category::class, 'kategori', 'id');
    }
}
