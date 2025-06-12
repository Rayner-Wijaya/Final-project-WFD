@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Direct Order</h1>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Formulir Pemesanan Cepat</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.direct-order.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_tamu" class="form-label">Nama Tamu</label>
                        <input type="text" class="form-control" id="nama_tamu" name="nama_tamu" required>
                    </div>
                    
                    <div class="mb-3">
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
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tglcheckin" class="form-label">Tanggal Check-in</label>
                            <input type="date" class="form-control" id="tglcheckin" name="tglcheckin" required min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="tglcheckout" class="form-label">Tanggal Check-out</label>
                            <input type="date" class="form-control" id="tglcheckout" name="tglcheckout" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="jumlah_tamu" class="form-label">Jumlah Tamu</label>
                        <input type="number" class="form-control" id="jumlah_tamu" name="jumlah_tamu" min="1" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan Tambahan</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Proses Pemesanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set min date for checkout when checkin date changes
        document.getElementById('tglcheckin').addEventListener('change', function() {
            document.getElementById('tglcheckout').min = this.value;
        });
    });
</script>
@endpush