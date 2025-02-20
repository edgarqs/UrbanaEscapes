<?php

namespace App\Mail;

use App\Models\Reservas;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservaTokenMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reserva;
    public $token;

    /**
     * Create a new message instance.
     */
    public function __construct(Reservas $reserva, $token)
    {
        $this->reserva = $reserva;
        $this->token = $token;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.reserva_token')
            ->subject('Token de Reserva')
            ->with([
                'reserva' => $this->reserva,
                'token' => $this->token,
            ]);
    }
}
