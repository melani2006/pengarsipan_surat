<div class="card mb-4">
    <div class="card-header pb-0">
        <div class="d-flex justify-content-between flex-column flex-sm-row">
            <div class="card-title">
                <h5 class="text-nowrap mb-0 fw-bold">{{ $disposisi->status?->status }}</h5>
                <small class="text-black">{{ $disposisi->penerima }}</small>
            </div>
            <div class="card-title d-flex flex-row">
                <div class="d-inline-block mx-2 text-end text-black">
                    <small class="d-block text-secondary">Tanggal Jatuh Tempo</small>
                    {{ $disposisi->formatted_batas_waktu }}
                </div>
                <div class="dropdown d-inline-block">
                    <button class="btn p-0" type="button" id="dropdown-disposisi-{{ $disposisi->id }}" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-disposisi-{{ $disposisi->id }}">
                        <a class="dropdown-item"
                           href="{{ route('transaksi.disposisi.edit', [$surat, $disposisi]) }}">Edit</a>
                        <form action="{{ route('transaksi.disposisi.destroy', [$surat, $disposisi]) }}" class="d-inline"
                              method="post">
                            @csrf
                            @method('DELETE')
                            <span
                                class="dropdown-item cursor-pointer btn-delete">Hapus</span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <hr>
        <p>{{ $disposisi->content }}</p>
        <small class="text-secondary">{{ $disposisi->Catatan }}</small>
        {{ $slot }}
    </div>
</div>
