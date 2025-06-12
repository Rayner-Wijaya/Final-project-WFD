<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HBooking extends Model
{
    use HasFactory;

    protected $table = 'h_booking';
    protected $primaryKey = 'nobooking';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nobooking', 'tglbooking', 'username', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function detailBookings()
    {
        return $this->hasMany(DBooking::class, 'nobooking');
    }
}