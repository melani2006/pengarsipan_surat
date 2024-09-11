@extends('layout.main')

@push('script')
    <script>
        $(document).on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            // [Controller: Mengarahkan ke rute untuk memperbarui data berdasarkan id]
            $('#editModal form').attr('action', '{{ route('reference.kategori.index') }}/' + id);
            $('#editModal input:hidden#id').val(id);
            $('#editModal input#code').val($(this).data('code'));
            $('#editModal input#type').val($(this).data('type'));
            $('#editModal input#deskripsi').val($(this).data('deskripsi'));
        });
    </script>
@endpush

@section('content')
    <x-breadcrumb
        :values="['Referensi', 'Kategori']">
        <button
            type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#createModal">
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
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                @if($data)
                    <tbody>
                    @foreach($data as $kategori)
                        <tr>
                            <!-- [Model: Mengambil data 'code' dari model Kategori] -->
                            <td>{{ $kategori->code }}</td>
                            <!-- [Model: Mengambil data 'type' dari model Kategori] -->
                            <td>{{ $kategori->type }}</td>
                            <!-- [Model: Mengambil data 'deskripsi' dari model Kategori] -->
                            <td>{{ $kategori->deskripsi }}</td>
                            <td>
                                <button class="btn btn-info btn-sm btn-edit"
                                        data-id="{{ $kategori->id }}"
                                        data-code="{{ $kategori->code }}"
                                        data-type="{{ $kategori->type }}"
                                        data-deskripsi="{{ $kategori->deskripsi }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal">
                                    Edit
                                </button>
                                <!-- [Controller: Form untuk menghapus data Kategori berdasarkan id] -->
                                <form action="{{ route('reference.kategori.destroy', $kategori) }}" class="d-inline" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm btn-delete"
                                            type="button">Hapus</button>
                                </form>
                            </td>
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
                    <th>Kode</th>
                    <th>Jenis</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- [Controller: Form untuk menambah data baru Kategori] -->
    <div class="modal fade" id="createModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="{{ route('reference.kategori.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalTitle">Tambah</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Tutup"
                    ></button>
                </div>
                <div class="modal-body">
                    <!-- [Model: Field 'code' disimpan di dalam model Kategori] -->
                    <x-input-form name="code" :label="'Kode'"/>
                    <!-- [Model: Field 'type' disimpan di dalam model Kategori] -->
                    <x-input-form name="type" :label="'Jenis'"/>
                    <!-- [Model: Field 'deskripsi' disimpan di dalam model Kategori] -->
                    <x-input-form name="deskripsi" :label="'Deskripsi'"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- [Controller: Form untuk memperbarui data Kategori] -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Edit</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Tutup"
                    ></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
                    <x-input-form name="code" :label="'Kode'"/>
                    <x-input-form name="type" :label="'Jenis'"/>
                    <x-input-form name="deskripsi" :label="'Deskripsi'"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
@endsection
