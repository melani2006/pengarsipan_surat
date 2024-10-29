@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="['Riwayat', 'Surat Keluar']">
    </x-breadcrumb>

    <div class="card mb-5">
        <div class="card-header">
            <form action="{{ url()->current() }}">
                <input type="hidden" name="search" value="{{ $search ?? '' }}">
                <div class="row">
                    <div class="col">
                        <x-input-form name="tanggal" label="Tanggal" type="date"
                                      :value="$tanggal ? date('Y-m-d', strtotime($tanggal)) : ''"/>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="cari" class="form-label">Cari Berdasarkan</label>
                            <select class="form-select" id="cari" name="cari">
                                <option
                                    value="tanggal_surat" @selected(old('cari', $cari) == 'tanggal_surat')>Tanggal Surat</option>
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
                                    <button class="btn btn-primary" type="submit">Cari</button>
                                    <a href="{{ route('riwayat.keluar.print') . '?' . http_build_query(request()->query()) }}"
                                       target="_blank" class="btn btn-primary">Cetak</a>
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
                    <th>Perihal</th>
                    <th>Nomor Surat</th>
                    <th>Penerima</th>
                    <th>Tanggal Surat</th>
                </tr>
                </thead>
                @if($data->count())
                    <tbody>
                    @foreach($data as $riwayat)
                        <tr>
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                <strong>{{ $riwayat->perihal }}</strong></td>
                            <td>
                                <a href="{{ route('transaksi.keluar.show', $riwayat) }}">{{ $riwayat->nomor_surat }}</a>
                            </td>
                            <td>{{ $riwayat->penerima }}</td>
                            <td>{{ $riwayat->formatted_tanggal_surat }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                @else
                    <tbody>
                    <tr>
                        <td colspan="4" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                    </tbody>
                @endif
                <tfoot class="table-border-bottom-0">
                <tr>
                    <th>Perihal</th>
                    <th>Nomor Surat</th>
                    <th>Penerima</th>
                    <th>Tanggal Surat</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {!! $data->appends(['search' => $search, 'tanggal' => $tanggal, 'cari' => $cari])->links() !!}
@endsection
