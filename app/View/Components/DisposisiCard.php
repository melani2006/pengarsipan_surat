<?php

namespace App\View\Components;

use App\Models\Disposisi;
use App\Models\Surat;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DisposisiCard extends Component
{
    public Disposisi $disposisi;
    public Surat $surat;

    /**
     * @param Disposisi $disposisi
     * @param Surat $surat
     */
    public function __construct(Disposisi $disposisi, Surat $surat)
    {
        $this->disposisi = $disposisi;
        $this->surat = $surat;
    }

    /**
     * Mendapatkan tampilan / konten yang mewakili komponen.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.disposisi-card');
    }
}
