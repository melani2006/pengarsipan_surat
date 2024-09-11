<div class="card mb-4">
    <div class="card-header pb-0">
        <div class="d-flex justify-content-between flex-column flex-sm-row">
            <div class="card-title">
                <h5 class="text-nowrap mb-0 fw-bold">{{ $letter->reference_number }}</h5>
                <small class="text-black">
                    {{ $letter->type == 'incoming' ? $letter->from : $letter->penerima }} |
                    <span class="text-secondary">Agenda Nomor:</span> {{ $letter->agenda_number }}
                    |
                    {{ $letter->classification?->type }}
                </small>
            </div>
            <div class="card-title d-flex flex-row">
                <div class="d-inline-block mx-2 text-end text-black">
                    <small class="d-block text-secondary">Tanggal Surat</small>
                    {{ $letter->formatted_Tanggal_Surat }}
                </div>
                @if($letter->type == 'incoming')
                    <div class="mx-3">
                        <a href="{{ route('transaksi.disposisi.index', $letter) }}"
                           class="btn btn-primary btn">Disposisi <span>({{ $letter->dispositions->count() }})</span></a>
                    </div>
                @endif
                <div class="dropdown d-inline-block">
                    <button class="btn p-0" type="button" id="dropdown-{{ $letter->type }}-{{ $letter->id }}"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    @if($letter->type == 'masuk')
                        <div class="dropdown-menu dropdown-menu-end"
                             aria-labelledby="dropdown-{{ $letter->type }}-{{ $letter->id }}">
                            @if(!\Illuminate\Support\Facades\Route::is('*.show'))
                                <a class="dropdown-item"
                                   href="{{ route('transaksi.masuk.show', $letter) }}">Lihat</a>
                            @endif
                            <a class="dropdown-item"
                               href="{{ route('transaksi.masuk.edit', $letter) }}">Edit</a>
                            <form action="{{ route('transaksi.masuk.destroy', $letter) }}" class="d-inline"
                                  method="post">
                                @csrf
                                @method('DELETE')
                                <span
                                    class="dropdown-item cursor-pointer btn-delete">Hapus</span>
                            </form>
                        </div>
                    @else
                        <div class="dropdown-menu dropdown-menu-end"
                             aria-labelledby="dropdown-{{ $letter->type }}-{{ $letter->id }}">
                            @if(!\Illuminate\Support\Facades\Route::is('*.show'))
                                <a class="dropdown-item"
                                   href="{{ route('transaksi.keluar.show', $letter) }}">Lihat</a>
                            @endif
                            <a class="dropdown-item"
                               href="{{ route('transaksi.keluar.edit', $letter) }}">Edit</a>
                            <form action="{{ route('transaksi.keluar.destroy', $letter) }}" class="d-inline"
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
        <p>{{ $letter->deskripsi }}</p>
        <div class="d-flex justify-content-between flex-column flex-sm-row">
            <small class="text-secondary">{{ $letter->Catatan }}</small>
            @if(count($letter->attachments))
                <div>
                    @foreach($letter->attachments as $attachment)
                        <a href="{{ $attachment->path_url }}" target="_blank">
                            @if($attachment->extension == 'pdf')
                                <i class="bx bxs-file-pdf display-6 cursor-pointer text-primary"></i>
                            @elseif(in_array($attachment->extension, ['jpg', 'jpeg']))
                                <i class="bx bxs-file-jpg display-6 cursor-pointer text-primary"></i>
                            @elseif($attachment->extension == 'png')
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
