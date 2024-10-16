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
    <x-breadcrumb :values="['Transaksi', 'Surat Masuk', 'tambah']"></x-breadcrumb>

    <div class="card mb-4">
        <form action="{{ route('transaksi.masuk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body row">
                <input type="hidden" name="type" value="masuk">

                <div class="col-sm-12 col-md-6 col-lg-4">
                    <x-input-form name="nomor_surat" label="Nomor Surat"/>
                    <div class="invalid-feedback">Nomor Surat tidak boleh kosong.</div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4">
                    <x-input-form name="pengirim" label="Pengirim"/>
                    <div class="invalid-feedback">Pengirim tidak boleh kosong.</div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4">
                    <x-input-form name="kegiatan" label="Kegiatan"/>
                    <div class="invalid-feedback">Kegiatan tidak boleh kosong.</div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <x-input-form name="tanggal_surat" label="Tanggal Surat" type="date"/>
                    <div class="invalid-feedback">Tanggal Surat tidak boleh kosong.</div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <x-input-form name="tanggal_diterima" label="Tanggal Diterima" type="date"/>
                    <div class="invalid-feedback">Tanggal Diterima tidak boleh kosong.</div>
                </div>

                <div class="col-sm-12">
                    <x-input-textarea-form name="deskripsi" label="Deskripsi"/>
                    <div class="invalid-feedback">Deskripsi tidak boleh kosong.</div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="kategori_code" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori_code" name="kategori_code">
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->code }}" @selected(old('kategori_code') == $kategori->code)>
                                    {{ $kategori->type }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Kategori tidak boleh kosong.</div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4">
                    <x-input-form name="catatan" label="Catatan"/>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="lampirans" class="form-label">Lampiran</label>
                        <input type="file" class="form-control @error('lampirans') is-invalid @enderror" id="lampirans" 
                               name="lampirans[]" multiple/>
                    </div>
                </div>
            </div>

            <div class="card-footer pt-0 d-flex justify-content-start">
                <button class="btn btn-primary me-2" type="submit">Simpan</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
