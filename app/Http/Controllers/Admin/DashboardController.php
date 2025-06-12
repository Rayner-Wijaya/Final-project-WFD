<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kamar;

class DashboardController extends Controller
{
    public function index()
    {
        $kamars=Kamar::all();
        return view('admin.dashboard')->with('kamars', $kamars);
    }

    public function updateKamarStatus(Request $request)
    {
        $request->validate([
            'kamar_id' => 'required|exists:kamar,id',
            'status' => 'required|in:tersedia,dipesan',
        ]);

        $kamar = Kamar::find($request->kamar_id);
        $kamar->status = $request->status;
        $kamar->save();

        return back()->with('success', 'Status kamar berhasil diperbarui');
    }
}