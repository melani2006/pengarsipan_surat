@extends('layout.main')

@push('script')
    <script>
        $(document).on('click', '.btn-edit', function () {
            const id = $(this).data('id');
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
            Buat Baru
        </button>
    </x-breadcrumb>

    <div class="card mb-5">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>Kode Kategori</th>
                    <th>Jenis Kategori</th>
                    <th>Deskripsi Kategori</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                @if($data)
                    <tbody>
                    @foreach($data as $kategori)
                        <tr>
                            <td>{{ $kategori->code }}</td>
                            <td>{{ $kategori->type }}</td>
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
                            Tidak ada data.
                        </td>
                    </tr>
                    </tbody>
                @endif
                <tfoot class="table-border-bottom-0">
                <tr>
                    <th>Kode Kategori</th>
                    <th>Jenis Kategori</th>
                    <th>Deskripsi Kategori</th>
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
                    <h5 class="modal-title" id="createModalTitle">Buat Baru</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <x-input-form name="code" label="Kode Kategori"/>
                    <x-input-form name="type" label="Jenis Kategori"/>
                    <x-input-form name="deskripsi" label="Deskripsi Kategori"/>
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

    <!-- Edit Modal -->
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
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
                    <x-input-form name="code" label="Kode Kategori"/>
                    <x-input-form name="type" label="Jenis Kategori"/>
                    <x-input-form name="deskripsi" label="Deskripsi Kategori"/>
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
