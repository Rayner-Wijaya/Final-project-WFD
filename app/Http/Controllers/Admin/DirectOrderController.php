<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\HBooking;
use App\Models\DBooking;
use Carbon\Carbon;

class DirectOrderController extends Controller
{
    public function index()
    {
        $kamars = Kamar::where('status', 'tersedia')->get();
        return view('admin.direct-order', compact('kamars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'kamar_id' => 'required|exists:kamar,id',
            'tglcheckin' => 'required|date',
            'tglcheckout' => 'required|date|after:tglcheckin',
            'jumlah_tamu' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ]);

        // Generate booking number
        $nobooking = 'DIRECT-' . Carbon::now()->format('YmdHis');

        // Create header booking (without user)
        $hbooking = HBooking::create([
            'nobooking' => $nobooking,
            'tglbooking' => Carbon::now(),
            'username' => 'guest', // or create a guest user
            'status' => 'dibayar',
        ]);

        // Get kamar price
        $kamar = Kamar::find($request->kamar_id);
        $harga = $kamar->harga;

        // Create detail booking
        $dbooking = DBooking::create([
            'nobooking' => $nobooking,
            'nomerkamar' => $request->kamar_id,
            'tglcheckin' => $request->tglcheckin,
            'tglcheckout' => $request->tglcheckout,
            'harga' => $harga,
            'status' => 'dibayar',
        ]);

        // Update kamar status
        $kamar->status = 'dipesan';
        $kamar->save();

        // Prepare data for view
        $bookingData = [
            'nama_tamu' => $request->nama_tamu,
            'nomor_kamar' => $kamar->nomor_kamar,
            'tglcheckin' => $request->tglcheckin,
            'tglcheckout' => $request->tglcheckout,
            'jumlah_tamu' => $request->jumlah_tamu,
            'catatan' => $request->catatan,
            'harga' => $harga,
            'nobooking' => $nobooking,
        ];

        return view('admin.direct-order-success', compact('bookingData'));
    }
}