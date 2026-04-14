<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EjemploMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Parámetros para el envío
     */
    public $subject = "Kit de Herramientas Laravel";    // para el 'asunto' 
    public $texto = "";                                 // como el 'cuerpo' del envio
    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($texto)
    {
        $this->texto = $texto;
    }

    /**
     * Build the message.
     * Configuración para hacer el envío
     * @return $this
     */
    public function build()
    {
         return $this->view('emails.ejemplo');
    }
}
