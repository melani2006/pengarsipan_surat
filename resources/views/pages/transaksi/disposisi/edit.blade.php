@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="['Transaksi', $surat->nomor_surat, 'Disposisi Surat', 'Edit']">
    </x-breadcrumb>

    <div class="alert alert-primary alert-dismissible" role="alert">
        Disposisi untuk surat dengan nomor {{ $surat->nomor_surat }} telah dibuat. <a
            href="{{ route('transaksi.masuk.show', $surat) }}" class="fw-bold">Lihat</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="card mb-4">
        <form action="{{ route('transaksi.disposisi.update', [$surat, $data]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body row">
                <div class="col-sm-12 col-12 col-md-6 col-lg-6">
                    <x-input-form name="penerima" :value="$data->penerima" label="Penerima"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-6">
                    <x-input-form name="batas_waktu" :value="date('Y-m-d', strtotime($data->batas_waktu))" label="Batas Waktu" type="date"/>
                </div>
                <div class="col-sm-12 col-12 col-md-12 col-lg-12">
                    <x-input-textarea-form name="content" :value="$data->content" label="Isi Disposisi"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="status_surat" class="form-label">Status Surat</label>
                        <select class="form-select" id="status_surat" name="status_surat">
                            @foreach($statuses as $status)
                                <option
                                    value="{{ $status->id }}"
                                    @selected(old('status_surat', $data->status_surat) == $status->id)>
                                    {{ $status->status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-8">
                    <x-input-form name="catatan" :value="$data->catatan ?? ''" label="Catatan"/>
                </div>
            </div>
            <div class="card-footer pt-0">
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>
    </div>
@endsection
