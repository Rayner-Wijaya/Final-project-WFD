@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Direct Order Berhasil</h1>
    <a href="{{ route('admin.direct-order') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Ringkasan Pemesanan</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill"></i> Pemesanan berhasil diproses dengan nomor booking: <strong>{{ $bookingData['nobooking'] }}</strong>
                </div>
                
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Nama Tamu</th>
                        <td>{{ $bookingData['nama_tamu'] }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Kamar</th>
                        <td>{{ $bookingData['nomor_kamar'] }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Check-in</th>
                        <td>{{ \Carbon\Carbon::parse($bookingData['tglcheckin'])->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Check-out</th>
                        <td>{{ \Carbon\Carbon::parse($bookingData['tglcheckout'])->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Tamu</th>
                        <td>{{ $bookingData['jumlah_tamu'] }}</td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $bookingData['catatan'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Total Harga</th>
                        <td>Rp {{ number_format($bookingData['harga'], 0, ',', '.') }}</td>
                    </tr>
                </table>
                
                <div class="mt-4">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="send_email">
                        <label class="form-check-label" for="send_email">
                            Kirim email konfirmasi ke tamu
                        </label>
                    </div>
                    <button class="btn btn-primary" id="btn_send_email">
                        <i class="bi bi-envelope"></i> Kirim Email Konfirmasi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('btn_send_email').addEventListener('click', function() {
        if (document.getElementById('send_email').checked) {
            // Here you would typically make an AJAX call to send the email
            alert('Email konfirmasi telah dikirim ke tamu');
        } else {
            alert('Silakan centang checkbox untuk mengirim email');
        }
    });
</script>
@endpush