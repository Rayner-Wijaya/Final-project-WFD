<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKamar extends Model
{
    use HasFactory;

    protected $table = 'jenis_kamar';
    protected $fillable = ['nama_jenis', 'deskripsi'];

    public function kamar()
    {
        return $this->hasMany(Kamar::class, 'jenis_kamar_id');
    }
}