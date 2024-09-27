@extends('layout.main')

@section('content')
    <x-breadcrumb :values="['Transaksi', 'Surat Masuk', 'Lihat']">
    </x-breadcrumb>

    <x-letter-card :surat="$data">
        <div class="mt-2">
            <div class="divider">
                <div class="divider-text">Detail Surat</div>
            </div>
            <dl class="row mt-3">

                <dt class="col-sm-3">Tanggal Surat</dt>
                <dd class="col-sm-9">{{ $data->formatted_tanggal_surat }}</dd>

                <dt class="col-sm-3">Tanggal Diterima</dt>
                <dd class="col-sm-9">{{ $data->formatted_tanggal_diterima }}</dd>

                <dt class="col-sm-3">Nomor Surat</dt>
                <dd class="col-sm-9">{{ $data->nomor_surat }}</dd>

                <dt class="col-sm-3">Nomor Riwayat</dt>
                <dd class="col-sm-9">{{ $data->nomor_riwayat }}</dd>

                <dt class="col-sm-3">Kode Kategori</dt>
                <dd class="col-sm-9">{{ $data->kategori_code }}</dd>

                <dt class="col-sm-3">Tipe Kategori</dt>
                <dd class="col-sm-9">{{ $data->kategori?->type }}</dd>

                <dt class="col-sm-3">Pengirim</dt>
                <dd class="col-sm-9">{{ $data->pengirim }}</dd>

                <dt class="col-sm-3">Dibuat Oleh</dt>
                <dd class="col-sm-9">{{ $data->user?->name }}</dd>

                <dt class="col-sm-3">Dibuat Pada</dt>
                <dd class="col-sm-9">{{ $data->formatted_created_at }}</dd>

                <dt class="col-sm-3">Diperbarui Pada</dt>
                <dd class="col-sm-9">{{ $data->formatted_updated_at }}</dd>
            </dl>
        </div>
    </x-letter-card>

@endsection
