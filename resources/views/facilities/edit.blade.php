@extends('layouts.app')

@section('title', 'Edit Fasilitas')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Fasilitas: {{ $facility->name }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('facilities.update', $facility) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nama Fasilitas *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $facility->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type">Jenis Fasilitas *</label>
                        <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="sekolah" {{ old('type', $facility->type) == 'sekolah' ? 'selected' : '' }}>Sekolah</option>
                            <option value="rumah_sakit" {{ old('type', $facility->type) == 'rumah_sakit' ? 'selected' : '' }}>Rumah Sakit</option>
                            <option value="puskesmas" {{ old('type', $facility->type) == 'puskesmas' ? 'selected' : '' }}>Puskesmas</option>
                            <option value="tempat_ibadah" {{ old('type', $facility->type) == 'tempat_ibadah' ? 'selected' : '' }}>Tempat Ibadah</option>
                            <option value="pasar" {{ old('type', $facility->type) == 'pasar' ? 'selected' : '' }}>Pasar</option>
                            <option value="lainnya" {{ old('type', $facility->type) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="latitude">Latitude *</label>
                        <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror" 
                               id="latitude" name="latitude" value="{{ old('latitude', $facility->latitude) }}" required>
                        @error('latitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="longitude">Longitude *</label>
                        <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror" 
                               id="longitude" name="longitude" value="{{ old('longitude', $facility->longitude) }}" required>
                        @error('longitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea class="form-control @error('address') is-invalid @enderror" 
                          id="address" name="address" rows="2">{{ old('address', $facility->address) }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="3">{{ old('description', $facility->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Fasilitas
            </button>
            <a href="{{ route('facilities.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Peta
            </a>
        </form>
    </div>
</div>
@endsection