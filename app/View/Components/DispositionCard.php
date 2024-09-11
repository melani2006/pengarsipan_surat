<?php

namespace App\View\Components;

use App\Models\Disposisi;
use App\Models\Surat;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DispositionCard extends Component
{
    public Disposition $disposition;
    public Surat $surat;

    /**
     * @param Disposition $disposition
     * @param Surat $surat
     */
    public function __construct(Disposition $disposition, Surat $surat)
    {
        $this->disposition = $disposition;
        $this->surat = $surat;
    }

    /**
     * Mendapatkan tampilan / konten yang mewakili komponen.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.disposition-card');
    }
}
