@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="['Menu Transaksi', 'Surat Masuk', 'Lihat']">
    </x-breadcrumb>

    <x-letter-card :letter="$data">
        <div class="mt-2">
            <div class="divider">
                <div class="divider-text">Lihat</div>
            </div>
            <dl class="row mt-3">

                <dt class="col-sm-3">Tanggal Surat</dt>
                <dd class="col-sm-9">{{ $data->formatted_Tanggal_Surat }}</dd>

                <dt class="col-sm-3">Tanggal Diterima</dt>
                <dd class="col-sm-9">{{ $data->formatted_Tanggal_Diterima }}</dd>

                <dt class="col-sm-3">Nomor Referensi</dt>
                <dd class="col-sm-9">{{ $data->reference_number }}</dd>

                <dt class="col-sm-3">Nomor Agenda</dt>
                <dd class="col-sm-9">{{ $data->agenda_number }}</dd>

                <dt class="col-sm-3">Kode Klasifikasi</dt>
                <dd class="col-sm-9">{{ $data->classification_code }}</dd>

                <dt class="col-sm-3">Jenis Klasifikasi</dt>
                <dd class="col-sm-9">{{ $data->classification?->type }}</dd>

                <dt class="col-sm-3">Pengirim</dt>
                <dd class="col-sm-9">{{ $data->from }}</dd>

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
