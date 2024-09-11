@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="['Menu Transaksi', 'Surat Keluar']">
        <a href="{{ route('transaksi.keluar.create') }}" class="btn btn-primary">Buat</a>
    </x-breadcrumb>

    @foreach($data as $letter)
        <x-letter-card
            :letter="$letter"
        />
    @endforeach

    {!! $data->appends(['search' => $search])->links() !!}
@endsection
