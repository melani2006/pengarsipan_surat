@extends('layout.main')

@push('script')
    <script>
        // Validasi form dengan pesan kustom
        function validateForm(form) {
            let isValid = true;
            $(form).find('input:not([type="file"]), select, textarea:not([name="catatan"])').each(function () {
                const input = $(this);
                const feedback = input.siblings('.invalid-feedback');

                // Reset pesan kesalahan
                input.removeClass('is-invalid');
                feedback.hide();

                if (!input.val()) {
                    isValid = false;
                    input.addClass('is-invalid'); // Tambah kelas invalid
                    feedback.show(); // Tampilkan pesan kesalahan
                    feedback.text(`${input.attr('name').replace('_', ' ')} tidak boleh kosong.`); // Pesan kustom
                }
            });
            return isValid;
        }

        // Cegah validasi HTML5 bawaan dan gunakan validasi kustom
        $('form').on('submit', function (e) {
            if (!validateForm(this)) {
                e.preventDefault(); // Cegah submit jika tidak valid
            }
        });
    </script>
@endpush

@section('content')
    <x-breadcrumb :values="['Transaksi', 'Surat Masuk', 'Edit Surat']"></x-breadcrumb>

    <div class="card mb-4">
        <form action="{{ route('transaksi.masuk.update', $data) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body row">
                <input type="hidden" name="id" value="{{ $data->id }}">
                <input type="hidden" name="type" value="{{ $data->type }}">

                <div class="col-sm-12 col-md-6 col-lg-4">
                    <x-input-form name="nomor_surat" label="Nomor Surat" :value="$data->nomor_surat"/>
                    <div class="invalid-feedback">Nomor Surat tidak boleh kosong.</div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4">
                    <x-input-form name="pengirim" label="Pengirim" :value="$data->pengirim"/>
                    <div class="invalid-feedback">Pengirim tidak boleh kosong.</div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4">
                    <x-input-form name="kegiatan" label="Kegiatan" :value="$data->kegiatan"/>
                    <div class="invalid-feedback">Kegiatan tidak boleh kosong.</div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <x-input-form name="tanggal_surat" label="Tanggal Surat" type="date" :value="date('Y-m-d', strtotime($data->tanggal_surat))"/>
                    <div class="invalid-feedback">Tanggal Surat tidak boleh kosong.</div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <x-input-form name="tanggal_diterima" label="Tanggal Diterima" type="date" :value="date('Y-m-d', strtotime($data->tanggal_diterima))"/>
                    <div class="invalid-feedback">Tanggal Diterima tidak boleh kosong.</div>
                </div>

                <div class="col-sm-12">
                    <x-input-textarea-form name="deskripsi" label="Deskripsi" :value="$data->deskripsi"/>
                    <div class="invalid-feedback">Deskripsi tidak boleh kosong.</div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="kategori_code" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori_code" name="kategori_code">
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->code }}" @selected(old('kategori_code', $data->kategori_code) == $kategori->code)>
                                    {{ $kategori->type }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Kategori tidak boleh kosong.</div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4">
                    <x-input-form name="catatan" label="Catatan" :value="$data->catatan"/>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4">
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
                                <span class="badge bg-danger rounded-pill cursor-pointer btn-remove-lampiran" data-id="{{ $lampiran->id }}">
                                    <i class="bx bx-trash"></i>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="card-footer pt-0">
                <button class="btn btn-primary" type="submit">Perbarui</button>
                <a href="{{ route('transaksi.masuk.index') }}" class="btn btn-secondary">Batal</a>
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
        $(document).on('click', '.btn-remove-lampiran', function () {
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
