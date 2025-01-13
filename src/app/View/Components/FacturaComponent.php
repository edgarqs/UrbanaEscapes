<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FacturaComponent extends Component
{
    public $habitacio;
    public $serveis;
    public $preuPerDies;

    /**
     * Create a new component instance.
     */
    public function __construct($habitacio, $serveis, $preuPerDies)
    {
        $this->habitacio = $habitacio;
        $this->serveis = $serveis;
        $this->preuPerDies = $preuPerDies;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.factura-component');
    }
}
