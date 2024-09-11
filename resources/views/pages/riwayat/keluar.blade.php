@extends('layout.main')

@section('z')
    <x-breadcrumb
        :values="['riwayat', 'Surat Keluar']">
    </x-breadcrumb>

    <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
        @foreach($data as $lampiran)
            <div class="col">
                <x-gallery-card
                    :filename="$lampiran->filename"
                    :extension="$lampiran->extension"
                    :path="$lampiran->path_url"
                    :letter="$lampiran->letter"
                />
            </div>
        @endforeach
    </div>

    {!! $data->appends(['search' => $search])->links() !!}

@endsection
