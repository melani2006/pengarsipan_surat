@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="['Transaksi', 'Surat Keluar', 'Edit']">
    </x-breadcrumb>

    <div class="card mb-4">
        <form action="{{ route('transaksi.keluar.update', $data) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body row">
                <input type="hidden" name="id" value="{{ $data->id }}">
                <input type="hidden" name="type" value="{{ $data->type }}">
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form :value="$data->nomor_surat" name="nomor_surat" label="Nomor Surat"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form :value="$data->penerima" name="penerima" label="Penerima"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form :value="$data->nomor_riwayat" name="nomor_riwayat" label="Nomor Riwayat"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-12">
                    <x-input-form :value="date('Y-m-d', strtotime($data->tanggal_surat))" name="tanggal_surat" label="Tanggal Surat" type="date"/>
                </div>
                <div class="col-sm-12 col-12 col-md-12 col-lg-12">
                    <x-input-textarea-form :value="$data->deskripsi" name="deskripsi" label="Deskripsi"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="kategori_code" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori_code" name="kategori_code">
                            @foreach($kategoris as $kategori)
                                <option
                                    @selected(old('kategori_code', $data->kategori_code) == $kategori->code)
                                    value="{{ $kategori->code }}">
                                    {{ $kategori->type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <x-input-form :value="$data->catatan ?? ''" name="catatan" label="catatan"/>
                </div>
                <div class="col-sm-12 col-12 col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="lampirans" class="form-label">Lampiran</label>
                        <input type="file" class="form-control @error('lampirans') is-invalid @enderror" id="lampirans"
                               name="lampirans[]" multiple/>
                        <span class="error invalid-feedback">{{ $errors->first('lampirans') }}</span>
                    </div>
                    <ul class="list-group">
                        @foreach($data->lampirans as $lampiran)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{ $lampiran->path_url }}" target="_blank">{{ $lampiran->filename }}</a>
                                <span
                                    class="badge bg-danger rounded-pill cursor-pointer btn-remove-lampiran"
                                    data-id="{{ $lampiran->id }}">
                                        <i class="bx bx-trash"></i>
                                    </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="card-footer pt-0">
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>
    </div>
    <form action="{{ route('lampiran.destroy') }}" method="post" id="form-to-remove-lampiran">
        @csrf
        @method('DELETE')
        <input type="hidden" name="id" id="lampiran-id-to-remove">
    </form>
@endsection

@push('script')
    <script>
        $(document).on('click', '.btn-remove-lampiran', function (req) {
            $('input#lampiran-id-to-remove').val($(this).data('id'));
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus lampiran ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#696cff',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('form#form-to-remove-lampiran').submit();
                }
            })
        });
    </script>
@endpush
