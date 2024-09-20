@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="['Transaksi', 'Surat Masuk']">
        <a href="{{ route('transaksi.masuk.create') }}" class="btn btn-primary">Buat Surat</a>
    </x-breadcrumb>

    @foreach($data as $surat)
        <x-letter-card
            :surat="$surat"
        />
    @endforeach

    {!! $data->appends(['search' => $search])->links() !!}
@endsection
