<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;
    protected $table = 'kamar'; 
    protected $fillable = ['nomor_kamar', 'jenis_kamar_id', 'harga', 'status'];

    public function jenisKamar()
    {
        return $this->belongsTo(JenisKamar::class, 'jenis_kamar_id');
    }

    public function fotoKamar()
    {
        return $this->hasMany(FotoKamar::class);
    }

    public function fasilitasKamar()
    {
        return $this->hasMany(FasilitasKamar::class);
    }

    public function detailBookings()
    {
        return $this->hasMany(DBooking::class, 'nomerkamar');
    }
}