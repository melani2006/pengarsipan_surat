<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between flex-column flex-sm-row">
            <div>
                <h5 class="card-title mb-0 text-uppercase">{{ $extension }}</h5>
                <small>
                    @if($surat->type == 'incoming')
                        <a href="{{ route('transaksi.masuk.show', $surat) }}" class="fw-bold">{{ $surat->Nomor_Surat }}</a>
                    @else
                        <a href="{{ route('transaksi.keluar.show', $surat) }}" class="fw-bold">{{ $surat->Nomor_Surat }}</a>
                    @endif
                </small>
            </div>
            @if(strtolower($extension) == 'pdf')
                <i class="bx bxs-file-pdf display-5"></i>
            @elseif(strtolower($extension) == 'png')
                <i class="bx bxs-file-png display-5"></i>
            @elseif(in_array(strtolower($extension), ['jpeg', 'jpg']))
                <i class="bx bxs-file-jpg display-5"></i>
            @else
                <i class="bx bxs-file display-5"></i>
            @endif
        </div>
        <div class="accordion mt-3" id="accordion-{{ str_replace('.', '-', $filename) }}">
            <div class="accordion-item card">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-id-{{ str_replace('.', '-', $filename) }}" aria-expanded="false" aria-controls="accordion-id-{{ str_replace('.', '-', $filename) }}">
                    {{ $filename }}
                </button>
                <div id="accordion-id-{{ str_replace('.', '-', $filename) }}" class="accordion-collapse collapse text-center" data-bs-parent="#accordion-{{ str_replace('.', '-', $filename) }}" style="">
                    @if(strtolower($extension) == 'pdf')
                        <a class="btn my-3 btn-primary" download href="{{ $path }}">Unduh</a>
                    @elseif(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                        <img src="{{ $path }}" width="100%" alt="Gambar">
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
