@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="['Transaksi', $surat->nomor_surat, 'Disposisi Surat', 'tambah']">
    </x-breadcrumb>

    <div class="card mb-4">
        <form action="{{ route('transaksi.disposisi.store', $surat) }}" method="POST">
            @csrf
            <div class="card-body row">
                <div class="col-sm-12 col-12 col-md-6 col-lg-6">
                    <x-input-form name="penerima" label="Penerima"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-6">
                    <x-input-form name="batas_waktu" label="Batas Waktu" type="date"/>
                </div>
                <div class="col-sm-12 col-12 col-md-12 col-lg-12">
                    <x-input-textarea-form name="content" label="Isi Disposisi"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="status_surat" class="form-label">Status Surat</label>
                        <input type="text" class="form-control" id="status_surat" name="status_surat" value="{{ old('status_surat') }}" />
                    </div>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-8">
                    <x-input-form name="catatan" label="Catatan"/>
                </div>
            </div>
            <div class="card-footer pt-0">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a href="{{ route('transaksi.disposisi.index', $surat) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
