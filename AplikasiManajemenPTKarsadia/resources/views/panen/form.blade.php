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
            

            <!-- Jumlah per Kualitas -->
            <div class="form-group">
                <label>Jumlah per Kualitas</label>
                <div class="grade-wrapper">
                    <input type="number" name="jumlah_grade_a" min="0" required placeholder="Grade A">
                    <input type="number" name="jumlah_grade_b" min="0" required placeholder="Grade B">
                    <input type="number" name="jumlah_grade_c" min="0" required placeholder="Grade C">
                </div>
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
