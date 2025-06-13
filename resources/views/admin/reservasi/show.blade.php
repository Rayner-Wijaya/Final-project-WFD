@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Reservasi</h1>
    <a href="{{ route('reservasi.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        Informasi Reservasi
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">No. Booking</th>
                        <td>{{ $booking->nobooking }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Booking</th>
                        <td>{{ $booking->tglbooking }}</td>
                    </tr>
                    <tr>
                        <th>Nama Tamu</th>
                        <td>{{ $booking->user->nama }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $booking->user->email }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $booking->user->telp }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <form action="{{ route('admin.reservasi.update-status', $booking->nobooking) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Status Reservasi</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="pending" value="pending" {{ $booking->status == 'pending' ? 'checked' : '' }}>
                                <label class="form-check-label" for="pending">Pending</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="dibayar" value="dibayar" {{ $booking->status == 'dibayar' ? 'checked' : '' }}>
                                <label class="form-check-label" for="dibayar">Dibayar</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="batal" value="batal" {{ $booking->status == 'batal' ? 'checked' : '' }}>
                                <label class="form-check-label" for="batal">Batal</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        Detail Kamar
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No. Kamar</th>
                        <th>Tipe Kamar</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($booking->detailBookings as $detail)
                        <tr>
                            <td>{{ $detail->kamar->nomor_kamar }}</td>
                            <td>{{ $detail->kamar->jenisKamar->nama_jenis }}</td>
                            <td>{{ $detail->tglcheckin }}</td>
                            <td>{{ $detail->tglcheckout }}</td>
                            <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td>
                                @if($detail->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($detail->status == 'dibayar')
                                    <span class="badge bg-success">Dibayar</span>
                                @else
                                    <span class="badge bg-danger">Batal</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection