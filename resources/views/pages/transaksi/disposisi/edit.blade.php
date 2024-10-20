@extends('layout.main')

@push('script')
    <script>
        // Validasi form dengan pesan kustom
        function validateForm(form) {
            let isValid = true;
            $(form).find('input, select, textarea').each(function () {
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
    <x-breadcrumb :values="['Transaksi', $surat->nomor_surat, 'Disposisi Surat', 'Edit']"></x-breadcrumb>

    <div class="card mb-4">
        <form action="{{ route('transaksi.disposisi.update', [$surat, $data]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <x-input-form name="penerima" :value="$data->penerima" label="Penerima"/>
                    <div class="invalid-feedback">Penerima tidak boleh kosong.</div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <x-input-form 
                        name="batas_waktu" 
                        :value="date('Y-m-d', strtotime($data->batas_waktu))" 
                        label="Batas Waktu" 
                        type="date"/>
                    <div class="invalid-feedback">Batas Waktu tidak boleh kosong.</div>
                </div>

                <div class="col-sm-12">
                    <x-input-textarea-form name="content" :value="$data->content" label="Isi Disposisi"/>
                    <div class="invalid-feedback">Isi Disposisi tidak boleh kosong.</div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="status_surat" class="form-label">Status Surat</label>
                        <select class="form-select" id="status_surat" name="status_surat">
                            @foreach($statuses as $status)
                                <option
                                    value="{{ $status->id }}"
                                    @selected(old('status_surat', $data->status_surat) == $status->id)>
                                    {{ $status->status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-8">
                    <x-input-form name="catatan" :value="$data->catatan ?? ''" label="Catatan"/>
                </div>
            </div>

            <div class="card-footer pt-0 d-flex justify-content-start">
                <button class="btn btn-primary me-2" type="submit">Update</button>
                <a href="{{ route('transaksi.disposisi.index', $surat) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
