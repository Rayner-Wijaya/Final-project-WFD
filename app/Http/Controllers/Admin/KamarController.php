<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kamar;
use App\Models\FotoKamar;
use App\Models\JenisKamar;
use Illuminate\Http\Request;
use App\Models\FasilitasKamar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\StorageAttributes;
use Illuminate\Foundation\Console\StorageLinkCommand;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Illuminate\Container\Attributes\Storage as AttributesStorage;

class KamarController extends Controller
{
    public function index()
    {
        $kamars = Kamar::with('jenisKamar')->paginate(10);
        return view('admin.kamar.index', compact('kamars'));
    }

    public function create()
    {
        $jenisKamars = JenisKamar::all();
        return view('admin.kamar.create', compact('jenisKamars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_kamar' => 'required|unique:kamar',
            'jenis_kamar_id' => 'required|exists:jenis_kamar,id',
            'harga' => 'required|integer',
            'status' => 'required|in:tersedia,dipesan',
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'fasilitas_nama.*' => 'nullable|string',
            'fasilitas_deskripsi.*' => 'nullable|string',
        ]);

        $kamar = Kamar::create($request->only(['nomor_kamar', 'jenis_kamar_id', 'harga', 'status']));

        // Handle foto kamar
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $foto) {
                $path = $foto->store('kamar_fotos', 'public');
                FotoKamar::create([
                    'kamar_id' => $kamar->id,
                    'url_foto' => $path,
                ]);
            }
        }

        // Handle fasilitas kamar
        if ($request->fasilitas_nama) {
            foreach ($request->fasilitas_nama as $index => $nama) {
                if ($nama) {
                    FasilitasKamar::create([
                        'kamar_id' => $kamar->id,
                        'nama' => $nama,
                        'deskripsi' => $request->fasilitas_deskripsi[$index] ?? '',
                    ]);
                }
            }
        }

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kamar = Kamar::with(['fotoKamar', 'fasilitasKamar', 'jenisKamar'])->findOrFail($id);
        $jenisKamars = JenisKamar::all();
        return view('admin.kamar.edit', compact('kamar', 'jenisKamars'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_kamar' => 'required|unique:kamar,nomor_kamar,'.$id,
            'jenis_kamar_id' => 'required|exists:jenis_kamar,id',
            'harga' => 'required|integer',
            'status' => 'required|in:tersedia,dipesan',
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'fasilitas_nama.*' => 'nullable|string',
            'fasilitas_deskripsi.*' => 'nullable|string',
        ]);

        $kamar = Kamar::findOrFail($id);
        $kamar->update($request->only(['nomor_kamar', 'jenis_kamar_id', 'harga', 'status']));

        // Handle foto kamar
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $foto) {
                $path = $foto->store('kamar_fotos', 'public');
                FotoKamar::create([
                    'kamar_id' => $kamar->id,
                    'url_foto' => $path,
                ]);
            }
        }

        // Handle fasilitas kamar
        if ($request->fasilitas_nama) {
            // Delete existing facilities
            FasilitasKamar::where('kamar_id', $kamar->id)->delete();
            
            foreach ($request->fasilitas_nama as $index => $nama) {
                if ($nama) {
                    FasilitasKamar::create([
                        'kamar_id' => $kamar->id,
                        'nama' => $nama,
                        'deskripsi' => $request->fasilitas_deskripsi[$index] ?? '',
                    ]);
                }
            }
        }

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kamar = Kamar::findOrFail($id);
        $kamar->delete();
        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil dihapus');
    }

    public function deleteFoto($id)
    {
        $foto = FotoKamar::findOrFail($id);
        Storage::disk('public')->delete($foto->url_foto);
        $foto->delete();
        return back()->with('success', 'Foto berhasil dihapus');
    }
}