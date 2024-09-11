@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="['Pengaturan']">
    </x-breadcrumb>

    <div class="row">
        <div class="col">
            {{-- Tab --}}
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.show') }}">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0);">Pengaturan</a>
                </li>
            </ul>

            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            @foreach($configs as $config)
                                @continue($config->code == 'language')
                                <div class="col-md-6">
                                    <x-input-form :name="$config->code" :value="$config->value ?? ''" :label="ucfirst(str_replace('_', ' ', $config->code))"/>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Perbarui</button>
                            <button type="reset" class="btn btn-outline-secondary">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
