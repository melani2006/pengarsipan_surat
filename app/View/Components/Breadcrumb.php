<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public array $values;

    /**
     * Membuat instance komponen baru.
     *
     * @return void
     */
    public function __construct($values = [])
    {
        $this->values = $values;
    }

    /**
     * Mendapatkan tampilan / konten yang mewakili komponen.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.breadcrumb');
    }
}
