<?php


namespace App\View\Components;


use Illuminate\View\Component;
use App\Models\Reservas;


class ReservaComponent extends Component
{
   public $reserva;


   public function __construct($reservaId)
   {
       $this->reserva = Reservas::findOrFail($reservaId);
   }


   public function render()
   {
       return view('components.reserva-component');   
   }
}
