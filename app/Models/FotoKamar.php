<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoKamar extends Model
{
    use HasFactory;

    protected $table = 'foto_kamar';
    protected $fillable = ['kamar_id', 'url_foto'];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
}