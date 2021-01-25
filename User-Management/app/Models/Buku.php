<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'userpost_id',
        'cover',
        'cover_path',
        'pdf',
        'pdf_path',
        'judul',
        'jumlah',
        'pengarang',
        'penerbit',
        'terbit',
        'tebal_buku',
        'harga',
        'harga_sebelumnya',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
