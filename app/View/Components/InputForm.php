<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputForm extends Component
{
    public string $name, $label, $type, $value;
    
    /**
     * Buat instance komponen baru.
     *
     * @return void
     */
    public function __construct(string $name, $label, $type = 'text', $value = '')
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * Mendapatkan tampilan / konten yang mewakili komponen.
     *
     * @return View|Closure|string
     */
    public function render(): View|string|Closure
    {
        return view('components.input-form');
    }
}
