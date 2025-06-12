<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DBooking extends Model
{
    use HasFactory;

    protected $table = 'd_booking';
    protected $primaryKey = 'nodetail';
    protected $fillable = ['nobooking', 'nomerkamar', 'tglcheckin', 'tglcheckout', 'harga', 'status'];

    public function headerBooking()
    {
        return $this->belongsTo(HBooking::class, 'nobooking');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'nomerkamar');
    }
}