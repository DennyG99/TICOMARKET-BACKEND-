<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ControllerMail extends Mailable
{

    use Queueable, SerializesModels;
    public function __construct(string $asunto, string $vista,int $codigoVerificacion, string $contrasena)
    {
        $this->subject($asunto);
        $this->view($vista,['codigoVerificacion' => $codigoVerificacion]);
        $this->view($vista,['contrasena' => $contrasena]);

    }

}
