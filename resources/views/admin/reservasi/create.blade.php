@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Reservasi</h1>
    <a href="{{ route('reservasi.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<form action="{{ route('reservasi.store') }}" method="POST">
    @csrf
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Informasi Tamu
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="username" class="form-label">Nama Tamu</label>
                <select class="form-select" id="username" name="username" required>
                    <option value="">Pilih Tamu</option>
                    @foreach($users as $user)
                        <option value="{{ $user->username }}">{{ $user->nama }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Detail Reservasi
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kamar_id" class="form-label">Nomor Kamar</label>
                    <select class="form-select" id="kamar_id" name="kamar_id" required>
                        <option value="">Pilih Kamar</option>
                        @foreach($kamars as $kamar)
                            <option value="{{ $kamar->id }}" data-harga="{{ $kamar->harga }}">
                                {{ $kamar->nomor_kamar }} - {{ $kamar->jenisKamar->nama_jenis }} (Rp {{ number_format($kamar->harga, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="text" class="form-control" id="harga" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tglcheckin" class="form-label">Tanggal Check-in</label>
                    <input type="date" class="form-control" id="tglcheckin" name="tglcheckin" required min="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tglcheckout" class="form-label">Tanggal Check-out</label>
                    <input type="date" class="form-control" id="tglcheckout" name="tglcheckout" required>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-end">
        <button type="submit" class="btn btn-primary">Simpan Reservasi</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update harga when kamar is selected
        document.getElementById('kamar_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const harga = selectedOption.getAttribute('data-harga');
            document.getElementById('harga').value = 'Rp ' + new Intl.NumberFormat('id-ID').format(harga);
        });
        
        // Set min date for checkout
        document.getElementById('tglcheckin').addEventListener('change', function() {
            document.getElementById('tglcheckout').min = this.value;
        });
    });
</script>
@endpush