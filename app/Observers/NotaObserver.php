<?php

namespace App\Observers;

use App\Nota;
use Carbon\Carbon;

class NotaObserver
{
    public function saving (Nota $nota)
    {
        $alerta = new \App\Alerta();
        $alerta['read'] = 0;
        $alerta['conteudo'] = 'nova nota';
        $alerta['url'] = "";
        $alerta->save();
    }
}