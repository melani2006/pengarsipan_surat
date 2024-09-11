<?php

namespace App\View\Components;

use App\Models\Surat;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GalleryCard extends Component
{
    public string $filename, $extension, $path;
    public Surat $surat;

    /**
     * @param string $filename
     * @param string $extension
     * @param string $path
     * @param Surat|null $surat
     */
    public function __construct(string $filename, string $extension, string $path, Surat $surat = null)
    {
        $this->filename = $filename;
        $this->extension = $extension;
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
