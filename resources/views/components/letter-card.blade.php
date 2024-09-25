<div class="card mb-4">
    <div class="card-header pb-0">
        <div class="d-flex justify-content-between flex-column flex-sm-row">
            <div class="card-title">
                <h5 class="text-nowrap mb-0 fw-bold">{{ $surat->nomor_surat }}</h5>
                <small class="text-black">
                    {{ $surat->type == 'masuk' ? $surat->pengirim : $surat->penerima }} |
                    <span class="text-secondary">Agenda Nomor:</span> {{ $surat->nomor_agenda }}
                    |
                    {{ $surat->kategori?->type }}
                </small>
            </div>
            <div class="card-title d-flex flex-row">
                <div class="d-inline-block mx-2 text-end text-black">
                    <small class="d-block text-secondary">Tanggal Surat</small>
                    {{ $surat->formatted_Tanggal_Surat }}
                </div>
                @if($surat->type == 'masuk')
                    <div class="mx-3">
                        <a href="{{ route('transaksi.disposisi.index', $surat) }}"
                           class="btn btn-primary btn">Disposisi <span>({{ $surat->disposisi->count() }})</span></a>
                    </div>
                @endif
                <div class="dropdown d-inline-block">
                    <button class="btn p-0" type="button" id="dropdown-{{ $surat->type }}-{{ $surat->id }}"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    @if($surat->type == 'masuk')
                        <div class="dropdown-menu dropdown-menu-end"
                             aria-labelledby="dropdown-{{ $surat->type }}-{{ $surat->id }}">
                            @if(!\Illuminate\Support\Facades\Route::is('*.show'))
                                <a class="dropdown-item"
                                   href="{{ route('transaksi.masuk.show', $surat) }}">Lihat</a>
                            @endif
                            <a class="dropdown-item"
                               href="{{ route('transaksi.masuk.edit', $surat) }}">Edit</a>
                            <form action="{{ route('transaksi.masuk.destroy', $surat) }}" class="d-inline"
                                  method="post">
                                @csrf
                                @method('DELETE')
                                <span
                                    class="dropdown-item cursor-pointer btn-delete">Hapus</span>
                            </form>
                        </div>
                    @else
                        <div class="dropdown-menu dropdown-menu-end"
                             aria-labelledby="dropdown-{{ $surat->type }}-{{ $surat->id }}">
                            @if(!\Illuminate\Support\Facades\Route::is('*.show'))
                                <a class="dropdown-item"
                                   href="{{ route('transaksi.keluar.show', $surat) }}">Lihat</a>
                            @endif
                            <a class="dropdown-item"
                               href="{{ route('transaksi.keluar.edit', $surat) }}">Edit</a>
                            <form action="{{ route('transaksi.keluar.destroy', $surat) }}" class="d-inline"
                                  method="post">
                                @csrf
                                @method('DELETE')
                                <span
                                    class="dropdown-item cursor-pointer btn-delete">Hapus</span>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <hr>
        <p>{{ $surat->deskripsi }}</p>
        <div class="d-flex justify-content-between flex-column flex-sm-row">
            <small class="text-secondary">{{ $surat->Catatan }}</small>
            @if(count($surat->lampirans))
                <div>
                    @foreach($surat->lampirans as $lampiran)
                        <a href="{{ $lampiran->path_url }}" target="_blank">
                            @if($lampiran->extension == 'pdf')
                                <i class="bx bxs-file-pdf display-6 cursor-pointer text-primary"></i>
                            @elseif(in_array($lampiran->extension, ['jpg', 'jpeg']))
                                <i class="bx bxs-file-jpg display-6 cursor-pointer text-primary"></i>
                            @elseif($lampiran->extension == 'png')
                                <i class="bx bxs-file-png display-6 cursor-pointer text-primary"></i>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
        {{ $slot }}
    </div>
</div>
