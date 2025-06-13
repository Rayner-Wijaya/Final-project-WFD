@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Pengaturan Ketersediaan Kamar</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.dashboard.update-kamar-status') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="kamar_id" class="form-label">Nomor Kamar</label>
                    <select class="form-select" id="kamar_id" name="kamar_id" required>
                        <option value="">Pilih Kamar</option>
                        @foreach($kamars as $kamar)
                            <option value="{{ $kamar->id }}">{{ $kamar->nomor_kamar }} - {{ $kamar->jenisKamar->nama_jenis }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <div class="mt-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="tersedia" value="tersedia" checked>
                            <label class="form-check-label" for="tersedia">Tersedia</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="dipesan" value="dipesan">
                            <label class="form-check-label" for="dipesan">Dipesan</label>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Daftar Kamar</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>No. Kamar</th>
                        <th>Tipe</th>
                        <th>Harga</th>
                        <th>Fasilitas</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kamars as $kamar)
                        <tr>
                            <td>
                                @if($kamar->FotoKamar)
                                    @foreach ($kamar->FotoKamar as $foto)
                                        <img src="{{ asset('storage/' . $foto->url_foto) }}" alt="Kamar {{ $kamar->nomor_kamar }}" class="img-thumbnail" style="width: 100px; height: auto;">
                                    @endforeach                                    
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{ $kamar->nomor_kamar }}</td>
                            <td>{{ $kamar->jenisKamar->nama_jenis }}</td>
                            <td>Rp {{ number_format($kamar->harga, 0, ',', '.') }}</td>
                            <td>
                                @if($kamar->fasilitasKamar && $kamar->fasilitasKamar->count() > 0)
                                    <ul class="list-unstyled mb-0">
                                        @foreach($kamar->fasilitasKamar as $fasilitas)
                                            <li>
                                                <i class="fas fa-check-circle text-primary me-1"></i>
                                                {{ $fasilitas->nama }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">Tidak ada fasilitas</span>
                                @endif
                            </td>
                            <td>
                                @if($kamar->status == 'tersedia')
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-warning text-dark">Dipesan</span>
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

@push('styles')
<style>
    .img-thumbnail {
        object-fit: cover;
    }
    .table td {
        vertical-align: middle;
    }
</style>
@endpush

@push('scripts')
<script>
    // You can add JavaScript here if needed
</script>
@endpush