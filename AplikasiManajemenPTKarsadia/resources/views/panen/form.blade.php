@extends('layouts.app')

@section('content')
<div class="form-container">
    <div class="form-card">
        <h1>{{ isset($panen) ? 'Edit' : 'Tambah' }} Data Panen</h1>
        
        {{-- Error --}}
        @if($errors->any())
        <div class="alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <form method="POST" 
              action="{{ isset($panen) 
                ? route('update_panen', $panen->id_panen) 
                : route('store_panen') }}">
            @csrf

            {{-- UPDATE --}}
            @if(isset($panen))
                @method('PUT')
            @endif
            
            <!-- Tanggal Panen -->
            <div class="form-group">
                <label>Tanggal Panen *</label>
                <input type="date"
                       name="tanggal_panen"
                       value="{{ old('tanggal_panen', $panen->tanggal_panen ?? date('Y-m-d')) }}"
                       required>
            </div>
            
            <!-- Greenhouse -->
            <div class="form-group">
                <label>Greenhouse *</label>
                <select name="id_greenhouse" required>
                    <option value="">-- Pilih Greenhouse --</option>
                    @foreach($greenhouses as $gh)
                        <option value="{{ $gh->id_greenhouse }}"
                            {{ old('id_greenhouse', $panen->id_greenhouse ?? '') == $gh->id_greenhouse ? 'selected' : '' }}>
                            {{ $gh->nama ?? $gh->id_greenhouse }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Jumlah -->
            <div class="form-group">
                <label>Jumlah Panen *</label>
                <input type="number"
                       name="jumlah_panen"
                       min="1"
                       value="{{ old('jumlah_panen', $panen->jumlah_panen ?? '') }}"
                       required>
            </div>
            
            <!-- Kualitas -->
            <div class="form-group">
                <label>Kualitas *</label>
                <select name="kualitas" required>
                    <option value="">-- Pilih Kualitas --</option>
                    <option value="Baik" {{ old('kualitas', $panen->kualitas ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Sedang" {{ old('kualitas', $panen->kualitas ?? '') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="Buruk" {{ old('kualitas', $panen->kualitas ?? '') == 'Buruk' ? 'selected' : '' }}>Buruk</option>
                </select>
            </div>
            
            <!-- Tombol -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    {{ isset($panen) ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('panen.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
