<?php

namespace App;

use App\Events\NotaUpdated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Nota extends Model
{
    protected $table = "notas";

    protected $colunasLancaveis = ['aviso_chegada', 'abertura_portao', 'descarga_inicio', 'descarga_termino', 'conferencia_nf_inicio', 'conferencia_nf_termino', 'aviso_saida'];

    protected $fillable = [
        'codigo',
        'veiculo_id'
    ];

    public static function getNotasEmAberto()
    {
        return Nota::where('aberto', 1)->get();
    }

    public static function getData($column1, $column2)
    {
        $dias = self::getMediaDosDias($column1, $column2);
        $media_mes = self::getMediaDoMes($column1, $column2, $dias);

        return ['dias' => $dias, 'media_mes' => $media_mes];
    }

    public static function getMediaDoMes($column1, $column2, $dias)
    {
        $count = 0;
        $sum = 0;
        foreach ($dias as $dia)
        {
            $sum += $dia['media'];
            $count += $dia['registros'];
        }
        if($count == 0) $count = 1;
        return $sum/$count;
    }

    public static function getMediaDosDias($column1, $column2)
    {
        return Nota::select(DB::raw("DAY($column1) as dia, (SUM((TIMESTAMPDIFF(MINUTE, $column1, $column2))) / COUNT(*)) as media"))
        ->whereNotNull($column1)
            ->whereNotNull($column2)
            ->groupBy('dia')
            ->get();
    }

    public function getDiff($column1, $column2) {
        return Nota::select(DB::raw("SUM(TIMESTAMPDIFF(MINUTE, $column1, $column2)) as difference"))->get()[0];
    }

    public function getNextField()
    {
        foreach ($this->colunasLancaveis as $coluna)
        {
            if(!$this[$coluna]) return $coluna;
        }
        return null;
    }

    public function getLimite($day, $column1, $column2) {
        $limite = Nota::select(DB::raw("(SUM((TIMESTAMPDIFF(MINUTE, $column1, $column2))) / COUNT(*)) as tempo"))
            ->whereRaw("DAY($column1) = $day")->get()[0];
        \App\Log::make("info", $limite);

        return $limite["tempo"];
    }

    public function lancar() {
        $time = Carbon::now();
        $field = $this->getNextField();
        if($field == null) {
            return null;
        }
        $this[$field] = $time;
        if($field == "aviso_saida") $nota["aberto"] = 0;

        $grafico = \App\Grafico::where('col2', '=', $field)->first();
        if($grafico) {
            $media = \App\Nota::getMediaDosDias($grafico['col1'], $grafico['col2']);
            foreach($media as $dia) {
                if($dia['dia'] == $time->day) {
                    $mediaPre = $dia['media'];
                    $tempoLimite = $this->getLimite(Carbon::now()->day, $grafico["col1"], $grafico["col2"]) * ($grafico['multiplicador'] / 100 + 1);
                }
            }
            if(isset($mediaPre)) {
                $status = $this->save();

                $media = \App\Nota::getMediaDosDias($grafico['col1'], $grafico['col2']);
                foreach($media as $dia) {
                    if($dia['dia'] == $time->day) $mediaPos = $dia['media'];
                }

                if($mediaPos > $mediaPre) {
                    if($this->getDiff($grafico['col1'], $grafico['col2'])['difference'] > $tempoLimite) {
                        \App\Log::make('info', 'Evento Passou do Limite');
                        $alerta = new \App\Alerta();
                        $alerta['read'] = 0;
                        $alerta['conteudo'] = "Nota $this[codigo] passou do limite no evento $field";
                        $alerta['url'] = "";
                        $alerta['title'] = $grafico['titulo'];
                        $alerta['type'] = 'danger';
                        $alerta->save();
                    } else {
                        \App\Log::make('info', 'Evento Passou da Media');
                        $alerta = new \App\Alerta();
                        $alerta['read'] = 0;
                        $alerta['conteudo'] = "Nota $this[codigo] passou da media no evento $field";
                        $alerta['url'] = "";
                        $alerta['title'] = $grafico['titulo'];
                        $alerta['type'] = 'warning';
                        $alerta->save();
                    }
                }
            } else {
                $status = $this->save();
            }
        } else {
            $status = $this->save();
        }
        return [
            'status' => $status,
            'campo' => $field,
            'nota' => $this
        ];
    }
}
