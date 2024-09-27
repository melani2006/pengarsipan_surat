<?php

namespace App\View\Components;

use App\Models\Surat;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LetterCard extends Component
{
    public Surat $surat;

    /**
     * Buat instance komponen baru.
     *
     * @param Surat|null $surat
     * @return void
     */
    public function __construct(Surat $surat = null)
    {
        $this->surat = $surat;
    }

    /**
     * Mendapatkan tampilan / konten yang mewakili komponen.
     *
     * @return View|Closure|string
     */
    public function render(): View|string|Closure
    {
        return view('components.letter-card');
    }
}
