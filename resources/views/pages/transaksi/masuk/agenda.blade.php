@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="['Agenda', 'Surat Masuk']">
    </x-breadcrumb>

    <div class="card mb-5">
        <div class="card-header">
            <form action="{{ url()->current() }}">
                <input type="hidden" name="search" value="{{ $search ?? '' }}">
                <div class="row">
                    <div class="col">
                        <x-input-form name="since" label="Tanggal Mulai" type="date"
                                      :value="$since ? date('Y-m-d', strtotime($since)) : ''"/>
                    </div>
                    <div class="col">
                        <x-input-form name="until" label="Tanggal Selesai" type="date"
                                      :value="$until ? date('Y-m-d', strtotime($until)) : ''"/>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="cari" class="form-label">Cari Berdasarkan</label>
                            <select class="form-select" id="cari" name="cari">
                                <option
                                    value="tanggal_surat" @selected(old('cari', $cari) == 'tanggal_surat')>Tanggal Surat</option>
                                <option
                                    value="tanggal_diterima" @selected(old('cari', $cari) == 'tanggal_diterima')>Tanggal Diterima</option>
                                <option
                                    value="created_at" @selected(old('cari', $cari) == 'created_at')>Tanggal Dibuat</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label">Aksi</label>
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-primary"
                                            type="submit">Cari</button>
                                    <a
                                        href="{{ route('agenda.masuk.print') . '?' . $query }}"
                                        target="_blank"
                                        class="btn btn-primary">
                                        Cetak
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>Nomor Agenda</th>
                    <th>Nomor Surat</th>
                    <th>Pengirim</th>
                    <th>Tanggal Surat</th>
                </tr>
                </thead>
                @if($data)
                    <tbody>
                    @foreach($data as $agenda)
                        <tr>
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                <strong>{{ $agenda->nomor_agenda }}</strong></td>
                            <td>
                                <a href="{{ route('transaksi.masuk.show', $agenda) }}">{{ $agenda->nomor_surat }}</a>
                            </td>
                            <td>{{ $agenda->pengirim }}</td>
                            <td>{{ $agenda->formatted_tanggal_surat }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                @else
                    <tbody>
                    <tr>
                        <td colspan="4" class="text-center">
                            Tidak ada data
                        </td>
                    </tr>
                    </tbody>
                @endif
                <tfoot class="table-border-bottom-0">
                <tr>
                    <th>Nomor Agenda</th>
                    <th>Nomor Surat</th>
                    <th>Pengirim</th>
                    <th>Tanggal Surat</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {!! $data->appends(['search' => $search, 'since' => $since, 'until' => $until, 'cari' => $cari])->links() !!}
@endsection
