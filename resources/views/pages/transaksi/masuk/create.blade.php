@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="['Transaksi', 'Surat Masuk', 'Tambah']">
    </x-breadcrumb>

    <div class="card mb-4">
        <form action="{{ route('transaksi.masuk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body row">
                <input type="hidden" name="type" value="incoming">
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form name="reference_number" :label="'Nomor Referensi'"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form name="from" :label="'pengirim'"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form name="recipient" label="Penerima"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form name="agenda_number" :label="'Nomor Agenda'"/>
                </div>
                <!-- Samakan ukuran kolom untuk Tanggal Surat dan Tanggal Diterima -->
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form name="Tanggal_Surat" :label="'Tanggal Surat'" type="date"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form name="Tanggal_Diterima" :label="'Tanggal Diterima'" type="date"/>
                </div>
                <div class="col-sm-12 col-12 col-md-12 col-lg-12">
                    <x-input-textarea-form name="deskripsi" :label="'Deskripsi'"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="classification_code" class="form-label">Kode Klasifikasi</label>
                        <select class="form-select" id="classification_code" name="classification_code">
                            @foreach($kategoris as $classification)
                                <option
                                    value="{{ $classification->code }}"
                                    @selected(old('kategori_code') == $classification->code)>
                                    {{ $classification->type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form name="Catatan" :label="'Catatan'"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="attachments" class="form-label">Lampiran</label>
                        <input type="file" class="form-control @error('attachments') is-invalid @enderror" id="attachments"
                               name="attachments[]" multiple/>
                        <span class="error invalid-feedback">{{ $errors->first('attachments') }}</span>
                    </div>
                </div>
            </div>
            <div class="card-footer pt-0">
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
@endsection
