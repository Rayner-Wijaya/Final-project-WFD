<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HBooking;
use App\Models\DBooking;
use App\Models\Kamar;
use App\Models\User;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    public function index()
    {
        $bookings = HBooking::with(['user', 'detailBookings.kamar'])->paginate(10);
        return view('admin.reservasi.index', compact('bookings'));
    }

    public function create()
    {
        $users = User::where('role', 'member')->get();
        $kamars = Kamar::where('status', 'tersedia')->get();
        return view('admin.reservasi.create', compact('users', 'kamars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
            'kamar_id' => 'required|exists:kamar,id',
            'tglcheckin' => 'required|date',
            'tglcheckout' => 'required|date|after:tglcheckin',
        ]);

        // Generate booking number
        $nobooking = 'BOOK-' . Carbon::now()->format('YmdHis');

        // Create header booking
        $hbooking = HBooking::create([
            'nobooking' => $nobooking,
            'tglbooking' => Carbon::now(),
            'username' => $request->username,
            'status' => 'dibayar',
        ]);

        // Get kamar price
        $kamar = Kamar::find($request->kamar_id);
        $harga = $kamar->harga;

        // Create detail booking
        DBooking::create([
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

        return redirect()->route('reservasi.index')->with('success', 'Reservasi berhasil dibuat');
    }

    public function show($id)
    {
        $booking = HBooking::with(['user', 'detailBookings.kamar'])->findOrFail($id);
        return view('admin.reservasi.show', compact('booking'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,dibayar,batal',
        ]);

        $booking = HBooking::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        // Update detail bookings status
        DBooking::where('nobooking', $id)->update(['status' => $request->status]);

        // If status is batal, update kamar status to tersedia
        if ($request->status === 'batal') {
            $detailBookings = DBooking::where('nobooking', $id)->get();
            foreach ($detailBookings as $detail) {
                Kamar::where('id', $detail->nomerkamar)->update(['status' => 'tersedia']);
            }
        }

        return back()->with('success', 'Status reservasi berhasil diperbarui');
    }
}