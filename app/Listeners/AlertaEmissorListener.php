<?php

namespace App\Listeners;

use App\Events\NotaUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AlertaEmissorListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NotaUpdated  $event
     * @return void
     */
    public function handle(NotaUpdated $event)
    {
        $nota = $event->nota;
        $alerta = new \App\Alerta();
        $alerta['read'] = 0;
        $alerta['conteudo'] = "Nota " . $nota['codigo'] . " Criada.";
        $alerta['url'] = "";
        $alerta->save();
    }
}
