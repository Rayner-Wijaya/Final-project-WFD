@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Kamar</h1>
    <a href="{{ route('kamar.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<form action="{{ route('kamar.update', $kamar->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    Informasi Kamar
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nomor_kamar" class="form-label">Nomor Kamar</label>
                        <input type="text" class="form-control @error('nomor_kamar') is-invalid @enderror" id="nomor_kamar" name="nomor_kamar" value="{{ old('nomor_kamar', $kamar->nomor_kamar) }}" required>
                        @error('nomor_kamar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kamar_id" class="form-label">Tipe Kamar</label>
                        <select class="form-select @error('jenis_kamar_id') is-invalid @enderror" id="jenis_kamar_id" name="jenis_kamar_id" required>
                            <option value="">Pilih Tipe Kamar</option>
                            @foreach($jenisKamars as $jenis)
                                <option value="{{ $jenis->id }}" {{ old('jenis_kamar_id', $kamar->jenis_kamar_id) == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama_jenis }}</option>
                            @endforeach
                        </select>
                        @error('jenis_kamar_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga', $kamar->harga) }}" required>
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="tersedia" value="tersedia" {{ old('status', $kamar->status) == 'tersedia' ? 'checked' : '' }}>
                                <label class="form-check-label" for="tersedia">Tersedia</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="dipesan" value="dipesan" {{ old('status', $kamar->status) == 'dipesan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="dipesan">Dipesan</label>
                            </div>
                        </div>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    Foto Kamar
                </div>
                <div class="card-body">
                    @if($kamar->fotoKamar->count() > 0)
                        <div class="row mb-3">
                            @foreach($kamar->fotoKamar as $foto)
                                <div class="col-md-4 mb-2">
                                    <img src="{{ asset('storage/' . $foto->url_foto) }}" class="img-thumbnail" style="width: 100%; height: 100px; object-fit: cover;">
                                    <div class="text-center mt-1">
                                        <form action="{{ route('admin.kamar.delete-foto', $foto->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="foto" class="form-label">Upload Foto Tambahan</label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto[]" multiple accept="image/*">
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Anda dapat memilih beberapa foto sekaligus</small>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Fasilitas Kamar
                </div>
                <div class="card-body">
                    <div id="fasilitas-container">
                        @if(old('fasilitas_nama'))
                            @foreach(old('fasilitas_nama') as $index => $nama)
                                <div class="fasilitas-item mb-3">
                                    <div class="row g-2">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="fasilitas_nama[]" value="{{ $nama }}" placeholder="Nama fasilitas">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="fasilitas_deskripsi[]" value="{{ old('fasilitas_deskripsi.' . $index) }}" placeholder="Deskripsi">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger btn-sm remove-fasilitas">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @foreach($kamar->fasilitasKamar as $fasilitas)
                                <div class="fasilitas-item mb-3">
                                    <div class="row g-2">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="fasilitas_nama[]" value="{{ $fasilitas->nama }}" placeholder="Nama fasilitas">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="fasilitas_deskripsi[]" value="{{ $fasilitas->deskripsi }}" placeholder="Deskripsi">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger btn-sm remove-fasilitas">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        @if($kamar->fasilitasKamar->count() === 0 && !old('fasilitas_nama'))
                            <div class="fasilitas-item mb-3">
                                <div class="row g-2">
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="fasilitas_nama[]" placeholder="Nama fasilitas">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="fasilitas_deskripsi[]" placeholder="Deskripsi">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-fasilitas" disabled>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="tambah-fasilitas" class="btn btn-sm btn-primary mt-2">
                        <i class="bi bi-plus"></i> Tambah Fasilitas
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="text-end mt-3">
        <button type="submit" class="btn btn-primary">Update Kamar</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add facility
        document.getElementById('tambah-fasilitas').addEventListener('click', function() {
            const container = document.getElementById('fasilitas-container');
            const newItem = document.createElement('div');
            newItem.className = 'fasilitas-item mb-3';
            newItem.innerHTML = `
                <div class="row g-2">
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="fasilitas_nama[]" placeholder="Nama fasilitas">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="fasilitas_deskripsi[]" placeholder="Deskripsi">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm remove-fasilitas">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(newItem);
            
            // Enable remove buttons if there are more than one
            if (document.querySelectorAll('.fasilitas-item').length > 1) {
                document.querySelectorAll('.remove-fasilitas').forEach(btn => {
                    btn.disabled = false;
                });
            }
        });
        
        // Remove facility
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-fasilitas')) {
                const item = e.target.closest('.fasilitas-item');
                item.remove();
                
                // Disable remove button if only one left
                if (document.querySelectorAll('.fasilitas-item').length === 1) {
                    document.querySelector('.remove-fasilitas').disabled = true;
                }
            }
        });
    });
</script>
@endpush