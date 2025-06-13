<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\JenisKamar;
use App\Models\Kamar;
use App\Models\FotoKamar;
use App\Models\FasilitasKamar;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'username' => 'admin',
            'email' => 'admin@hotel.com',
            'password' => Hash::make('password'),
            'nama' => 'Administrator',
            'alamat' => 'Jl. Admin No. 1',
            'telp' => '081234567890',
            'kota' => 'Jakarta',
            'jeniskelamin' => 'L',
            'tgllahir' => '1990-01-01',
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        // Create member user
        User::create([
            'username' => 'member1',
            'email' => 'member@hotel.com',
            'password' => Hash::make('password'),
            'nama' => 'Member Pertama',
            'alamat' => 'Jl. Member No. 1',
            'telp' => '081234567891',
            'kota' => 'Bandung',
            'jeniskelamin' => 'P',
            'tgllahir' => '1995-05-05',
            'role' => 'member',
            'status' => 'aktif',
        ]);
        
        // create a guest user for walk-in guests (EXTREMELY IMPORTANT)
        User::create([
            'username' => 'guest',
            
            'password' => Hash::make('password'),
            'nama' => 'guest',
            'alamat' => 'Jl. guest',
            'telp' => '0811453938',
            'kota' => 'Abyss',
            'jeniskelamin' => 'P',
            'tgllahir' => '1995-05-05',
            'role' => 'member',
            'status' => 'aktif',
        ]);
        // Create jenis kamar
        $jenis1 = JenisKamar::create([
            'nama_jenis' => 'Standard',
            'deskripsi' => 'Kamar standar dengan fasilitas dasar',
        ]);

        $jenis2 = JenisKamar::create([
            'nama_jenis' => 'Deluxe',
            'deskripsi' => 'Kamar deluxe dengan fasilitas lengkap',
        ]);

        // Create kamar
        $kamar1 = Kamar::create([
            'nomor_kamar' => '101',
            'jenis_kamar_id' => $jenis1->id,
            'harga' => 500000,
            'status' => 'tersedia',
        ]);

        $kamar2 = Kamar::create([
            'nomor_kamar' => '201',
            'jenis_kamar_id' => $jenis2->id,
            'harga' => 800000,
            'status' => 'tersedia',
        ]);

        // Create foto kamar
        FotoKamar::create([
            'kamar_id' => $kamar1->id,
            'url_foto' => 'kamar_fotos/standard1.jpg',
        ]);

        FotoKamar::create([
            'kamar_id' => $kamar2->id,
            'url_foto' => 'kamar_fotos/deluxe1.jpg',
        ]);

        // Create fasilitas kamar
        FasilitasKamar::create([
            'kamar_id' => $kamar1->id,
            'nama' => 'AC',
            'deskripsi' => 'Air Conditioner',
        ]);

        FasilitasKamar::create([
            'kamar_id' => $kamar1->id,
            'nama' => 'TV',
            'deskripsi' => 'Televisi 32 inch',
        ]);

        FasilitasKamar::create([
            'kamar_id' => $kamar2->id,
            'nama' => 'AC',
            'deskripsi' => 'Air Conditioner',
        ]);

        FasilitasKamar::create([
            'kamar_id' => $kamar2->id,
            'nama' => 'TV',
            'deskripsi' => 'Televisi 42 inch',
        ]);

        FasilitasKamar::create([
            'kamar_id' => $kamar2->id,
            'nama' => 'Mini Bar',
            'deskripsi' => 'Mini refrigerator',
        ]);
    }
}