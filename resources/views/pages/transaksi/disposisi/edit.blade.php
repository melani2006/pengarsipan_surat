@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="['Transaksi', $letter->reference_number, 'Surat Disposisi', 'Ubah']">
    </x-breadcrumb>

    <div class="alert alert-primary alert-dismissible" role="alert">
        {{ 'Perhatikan nomor referensi ' . $letter->reference_number }} <a
            href="{{ route('transaksi.masuk.show', $letter) }}" class="fw-bold">Lihat</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>

    <div class="card mb-4">
        <form action="{{ route('transaksi.disposisi.update', [$letter, $data]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body row">
                <div class="col-sm-12 col-12 col-md-6 col-lg-6">
                    <x-input-form name="to" :value="$data->to" :label="'penerima'"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-6">
                    <x-input-form name="due_date" :value="date('Y-m-d', strtotime($data->due_date))" :label="'Tanggal Jatuh Tempo'" type="date"/>
                </div>
                <div class="col-sm-12 col-12 col-md-12 col-lg-12">
                    <x-input-textarea-form name="content" :value="$data->content" :label="'Konten'"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="letter_status" class="form-label">Status</label>
                        <select class="form-select" id="letter_status" name="letter_status">
                            @foreach($statuses as $status)
                                <option
                                    value="{{ $status->id }}"
                                    @selected(old('letter_status', $data->letter_status) == $status->id)>
                                    {{ $status->status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-8">
                    <x-input-form name="Catatan" :value="$data->Catatan ?? ''" :label="'Catatan'"/>
                </div>
            </div>
            <div class="card-footer pt-0">
                <button class="btn btn-primary" type="submit">Perbarui</button>
            </div>
        </form>
    </div>
@endsection
