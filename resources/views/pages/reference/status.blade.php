@extends('layout.main')

@push('script')
    <script>
        $(document).on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            $('#editModal form').attr('action', '{{ route('reference.status.index') }}/' + id);
            $('#editModal input:hidden#id').val(id);
            $('#editModal input#status').val($(this).data('status'));
        });
    </script>
@endpush

@section('content')
    <x-breadcrumb :values="['Status']">
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
                    <th>No</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                @if($data)
                    <tbody>
                    @foreach($data as $status)
                        <tr>
                            <td>{{ $status->id }}</td>
                            <td>{{ $status->status }}</td>
                            <td>
                                <button class="btn btn-info btn-sm btn-edit"
                                        data-id="{{ $status->id }}"
                                        data-status="{{ $status->status }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal">
                                    Edit
                                </button>
                                <form action="{{ route('reference.status.destroy', $status) }}" class="d-inline" method="post">
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
                            Data Kosong
                        </td>
                    </tr>
                    </tbody>
                @endif
                <tfoot class="table-border-bottom-0">
                <tr>
                    <th>No</th>
                    <th>Status</th>
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
            <form class="modal-content" method="post" action="{{ route('reference.status.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalTitle">tambah</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <x-input-form name="status" label="Status"/>
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
                    <x-input-form name="status" label="Status"/>
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
@endsection