<?php
namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Closure;

class DetallsHabitacio extends Component
{
    public $habitacio;

    /**
     * Create a new component instance.
     */
    public function __construct($habitacio)
    {
        $this->habitacio = $habitacio;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.detalls-habitacio', ['habitacio' => $this->habitacio]);
    }
}