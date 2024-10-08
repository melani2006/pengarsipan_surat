@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="['Transaksi', 'Surat Keluar', 'tambah']">
    </x-breadcrumb>

    <div class="card mb-4">
        <form action="{{ route('transaksi.keluar.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body row">
                <input type="hidden" name="type" value="keluar">
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form name="nomor_surat" label="Nomor Surat"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form name="penerima" label="Penerima"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form name="kegiatan" label="Kegiatan"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-12">
                    <x-input-form name="tanggal_surat" label="Tanggal Surat" type="date"/>
                </div>
                <div class="col-sm-12 col-12 col-md-12 col-lg-12">
                    <x-input-textarea-form name="deskripsi" label="Deskripsi"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="kategori_code" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori_code" name="kategori_code">
                            @foreach($kategoris as $kategori)
                                <option
                                    value="{{ $kategori->code }}"
                                    @selected(old('kategori_code') == $kategori->code)>
                                    {{ $kategori->type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form name="catatan" label="catatan"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="lampirans" class="form-label">Lampiran</label>
                        <input type="file" class="form-control @error('lampirans') is-invalid @enderror" id="lampirans" name="lampirans[]" multiple />
                        <span class="error invalid-feedback">{{ $errors->first('lampirans') }}</span>
                    </div>
                </div>
            </div>
            <div class="card-footer pt-0">
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
@endsection
