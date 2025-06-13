@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Daftar Reservasi</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('reservasi.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Reservasi
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No. Booking</th>
                        <th>Nama Tamu</th>
                        <th>No. Kamar</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->nobooking }}</td>
                            <td>{{ $booking->user->nama }}</td>
                            <td>
                                @foreach($booking->detailBookings as $detail)
                                    {{ $detail->kamar->nomor_kamar }}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach($booking->detailBookings as $detail)
                                    {{ $detail->tglcheckin }}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach($booking->detailBookings as $detail)
                                    {{ $detail->tglcheckout }}<br>
                                @endforeach
                            </td>
                            <td>
                                @if($booking->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($booking->status == 'dibayar')
                                    <span class="badge bg-success">Dibayar</span>
                                @else
                                    <span class="badge bg-danger">Batal</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('reservasi.show', $booking->nobooking) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection