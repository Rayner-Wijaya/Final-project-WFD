<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FasilitasKamar extends Model
{
    use HasFactory;

    protected $table = 'fasilitas_kamar';
    protected $fillable = ['kamar_id', 'nama', 'deskripsi'];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
}