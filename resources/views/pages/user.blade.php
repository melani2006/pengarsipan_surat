@extends('layout.main')

@push('script')
    <script>
        // Mengisi data saat tombol edit diklik
        $(document).on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            $('#editModal form').attr('action', '{{ route('user.index') }}/' + id);
            $('#editModal input:hidden#id').val(id);
            $('#editModal input#name').val($(this).data('name'));
            $('#editModal input#phone').val($(this).data('phone'));
            $('#editModal input#email').val($(this).data('email'));
            $('#editModal input#is_active').prop('checked', $(this).data('active') == 1);
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
                    input.addClass('is-invalid');
                    feedback.show();
                    feedback.text(`${input.attr('name')} tidak boleh kosong.`);
                }
            });
            return isValid;
        }

        // Cegah validasi HTML5 bawaan
        $('#createModal form, #editModal form').on('submit', function (e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });

        // Toggle password visibility
        $(document).on('change', '.toggle-password', function () {
            const passwordField = $(this).closest('.modal-body').find('input[name="password"]');
            const type = $(this).is(':checked') ? 'text' : 'password';
            passwordField.attr('type', type);
        });
    </script>
@endpush

@section('content')
    <x-breadcrumb :values="['Pengguna']">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            Tambah
        </button>
    </x-breadcrumb>

    <div class="card mb-5">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Status Aktif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                @if($data)
                    <tbody>
                        @foreach($data as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    <span class="badge bg-label-primary me-1">
                                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm btn-edit"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                            data-email="{{ $user->email }}"
                                            data-phone="{{ $user->phone }}"
                                            data-active="{{ $user->is_active }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                        Edit
                                    </button>
                                    <form action="{{ route('user.destroy', $user) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="button">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center">Data kosong</td>
                        </tr>
                    </tbody>
                @endif
                <tfoot>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Status Aktif</th>
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
            <form class="modal-content" method="post" action="{{ route('user.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <x-input-form name="name" :label="'Nama'"/>
                    <x-input-form name="email" :label="'Email'" type="email"/>
                    <x-input-form name="phone" :label="'Telepon'" inputmode="numeric" pattern="[0-9]*"/>
                    <x-input-form name="password" :label="'Password'" type="password"/>

                    <div class="form-check mt-2">
                        <input class="form-check-input toggle-password" type="checkbox" id="showPasswordCreate">
                        <label class="form-check-label" for="showPasswordCreate">Tampilkan Password</label>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
                    <x-input-form name="name" :label="'Nama'"/>
                    <x-input-form name="email" :label="'Email'" type="email"/>
                    <x-input-form name="phone" :label="'Telepon'" inputmode="numeric" pattern="[0-9]*"/>
                    <x-input-form name="password" :label="'Password'" type="password"/>

                    <div class="form-check mt-2">
                        <input class="form-check-input toggle-password" type="checkbox" id="showPasswordEdit">
                        <label class="form-check-label" for="showPasswordEdit">Tampilkan Password</label>
                    </div>

                    <label>Status Aktif</label>
                    <div class="d-flex">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="checkbox" name="is_active" value="true" id="is_active">
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="nonaktif" value="true" id="nonaktif">
                            <label class="form-check-label" for="nonaktif">Nonaktif</label>
                        </div>
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
