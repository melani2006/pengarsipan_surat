<?php

namespace App\View\Components;

use App\Models\Surat;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GalleryCard extends Component
{
    public string $filename, $Extension, $path;
    public Surat $surat;

    /**
     * @param string $filename
     * @param string $Extension
     * @param string $path
     * @param Surat|null $surat
     */
    public function __construct(string $filename, string $Extension, string $path, Surat $surat = null)
    {
        $this->filename = $filename;
        $this->Extension= $Extension;
        $this->path = $path;
        $this->surat = $surat;
    }

    /**
     * Mendapatkan tampilan / konten yang mewakili komponen.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.gallery-card');
    }
}
