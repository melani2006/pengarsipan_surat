@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="['Transaksi', $surat->nomor_surat, 'Disposisi Surat']">
        <a href="{{ route('transaksi.disposisi.create', $surat) }}" class="btn btn-primary">Buat Disposisi</a>
    </x-breadcrumb>

    <div class="alert alert-primary alert-dismissible" role="alert">
        Disposisi untuk surat dengan nomor {{ $surat->nomor_surat }} telah dibuat. <a href="{{ route('transaksi.masuk.show', $surat) }}" class="fw-bold">Lihat</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    @foreach($data as $disposisi)
        <x-disposition-card
            :surat="$surat"
            :disposisi="$disposisi"
        />
    @endforeach

    {!! $data->appends(['search' => $search])->links() !!}
@endsection
