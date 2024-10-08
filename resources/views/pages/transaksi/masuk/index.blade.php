@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="['Transaksi', 'Surat Masuk']">
        <a href="{{ route('transaksi.masuk.create') }}" class="btn btn-primary">tambah</a>
    </x-breadcrumb>

    @foreach($data as $surat)
        <x-surat-card
            :surat="$surat"
        />
    @endforeach

    {!! $data->appends(['search' => $search])->links() !!}
@endsection