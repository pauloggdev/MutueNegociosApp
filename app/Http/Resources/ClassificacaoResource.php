<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassificacaoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user' => new UserResource($this->user),
            'num_classificacao' => $this->num_classificacao,
            'comentario' => $this->comentario,
            'tempoClassificacao' => $this->created_at
        ];
    }
    public function tempoClassificacao($dataCriacao)
    {

        $agora = time();

        $classificacao = strtotime($dataCriacao);
        $diferenca = $agora - $classificacao;
        $minutos = floor($diferenca / 60);
        if ($minutos == 0) {
            return 'agora mesmo';
        } elseif ($minutos == 1) {
            return '1 minuto atrás';
        } elseif ($minutos < 60) {
            return $minutos . ' minutos atrás';
        } elseif ($minutos < 1440) {
            $horas = floor($minutos / 60);
            if ($horas == 1) {
                return '1 hora atrás';
            } else {
                return $horas . ' horas atrás';
            }
        } elseif ($minutos > 525600) {
            $anos = floor($minutos / 525600);
            if ($anos == 1) {
                return '1 ano atrás';
            } else {
                return $anos . ' anos atrás';
            }
        } else {
            $dias = floor($minutos / 1440);
            return $dias . ' dias atrás';
        }
    }
}
