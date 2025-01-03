@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="['Transaksi', 'Surat Keluar']">
        <a href="{{ route('transaksi.keluar.create') }}" class="btn btn-primary">Tambah</a>
    </x-breadcrumb>

    @foreach($data as $surat)
        <x-surat-card
            :surat="$surat"
        />
    @endforeach

    {!! $data->appends(['search' => $search])->links() !!}
@endsection