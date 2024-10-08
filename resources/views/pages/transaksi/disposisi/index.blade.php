@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="['Transaksi', $surat->nomor_surat, 'Disposisi Surat']">
        <a href="{{ route('transaksi.disposisi.create', $surat) }}" class="btn btn-primary">Tambah</a>
    </x-breadcrumb>

    

    @foreach($data as $disposisi)
        <x-disposisi-card
            :surat="$surat"
            :disposisi="$disposisi"
        />
    @endforeach

    {!! $data->appends(['search' => $search])->links() !!}
@endsection
