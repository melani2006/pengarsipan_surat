@extends('layout.main')

@push('script')
    <script>
        // Mengisi data saat tombol edit diklik
        $(document).on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            $('#editModal form').attr('action', '{{ route('reference.kategori.index') }}/' + id);
            $('#editModal input:hidden#id').val(id);
            $('#editModal input#code').val($(this).data('code'));
            $('#editModal input#type').val($(this).data('type'));
        });

        // Validasi form sebelum submit dengan pesan kustom
        function validateForm(form) {
            let isValid = true;
            $(form).find('input').each(function () {
                const input = $(this);
                const feedback = input.siblings('.invalid-feedback');

                // Reset pesan kesalahan
                input.removeClass('is-invalid');
                feedback.hide();

                if (!input.val()) {
                    isValid = false;
                    input.addClass('is-invalid'); // Tambah kelas invalid
                    feedback.show(); // Tampilkan pesan kesalahan
                    feedback.text(`${input.attr('name')} tidak boleh kosong.`); // Pesan kustom
                }
            });
            return isValid;
        }

        // Cegah validasi HTML5 bawaan
        $('#createModal form, #editModal form').on('submit', function (e) {
            if (!validateForm(this)) {
                e.preventDefault(); // Mencegah submit jika tidak valid
            }
        });
    </script>
@endpush

@section('content')
    <x-breadcrumb :values="['Kategori']">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            Tambah
        </button>
    </x-breadcrumb>

    <div class="card mb-5">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Jenis</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                @if($data)
                    <tbody>
                        @foreach($data as $kategori)
                            <tr>
                                <td>{{ $kategori->code }}</td>
                                <td>{{ $kategori->type }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm btn-edit"
                                            data-id="{{ $kategori->id }}"
                                            data-code="{{ $kategori->code }}"
                                            data-type="{{ $kategori->type }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                        Edit
                                    </button>
                                    <form action="{{ route('reference.kategori.destroy', $kategori) }}" class="d-inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm btn-delete" type="button">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data.</td>
                        </tr>
                    </tbody>
                @endif
                <tfoot>
                    <tr>
                        <th>Kode</th>
                        <th>Jenis</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {!! $data->appends(['search' => $search])->links() !!}

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="{{ route('reference.kategori.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="code" class="form-label">Kode</label>
                        <input type="text" class="form-control" id="code" name="code">
                        <div class="invalid-feedback">Kode tidak boleh kosong.</div>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Jenis</label>
                        <input type="text" class="form-control" id="type" name="type">
                        <div class="invalid-feedback">Jenis tidak boleh kosong.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
                    <div class="mb-3">
                        <label for="code" class="form-label">Kode</label>
                        <input type="text" class="form-control" id="code" name="code">
                        <div class="invalid-feedback">Kode tidak boleh kosong.</div>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Jenis</label>
                        <input type="text" class="form-control" id="type" name="type">
                        <div class="invalid-feedback">Jenis tidak boleh kosong.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
@endsection
