@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="['Transaksi', $letter->reference_number, 'Surat Disposisi']">
        <a href="{{ route('transaksi.disposisi.create', $letter) }}" class="btn btn-primary">Tambah</a>
    </x-breadcrumb>

    <div class="alert alert-primary alert-dismissible" role="alert">
        {{ 'Perhatikan nomor referensi ' . $letter->reference_number }} <a href="{{ route('transaksi.masuk.show', $letter) }}" class="fw-bold">Lihat</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>

    @foreach($data as $disposition)
        <x-disposition-card
            :letter="$letter"
            :disposition="$disposition"
        />
    @endforeach

    {!! $data->appends(['search' => $search])->links() !!}
@endsection
