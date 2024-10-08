<div class="card">
    <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
                <span class="badge bg-label-{{ $color }} p-2">
                    <i class="bx {{ $icon }} text-{{ $color }}"></i>
                </span>
            </div>
            @if($label != 'Disposisi Surat' && !(auth()->user()->role == 'staff' && $label == 'Pengguna Aktif'))
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                        @if($label == 'Surat Masuk')
                            <a class="dropdown-item"
                               href="{{ route('transaksi.masuk.index') }}">Lihat Selengkapnya</a>
                        @elseif($label == 'Surat Keluar')
                            <a class="dropdown-item"
                               href="{{ route('transaksi.keluar.index') }}">Lihat Selengkapnya</a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        <span class="fw-semibold d-block mb-1">{{ $label }} {{ $daily ? '*' : '' }}</span>
        <h3 class="card-title mb-2">{{ $value }}</h3>
    </div>
</div>
