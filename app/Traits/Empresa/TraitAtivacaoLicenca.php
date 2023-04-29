<?php

namespace App\Traits\Empresa;

use App\Jobs\JobMailPrazoLicencaEmpresa;
use App\Models\admin\AtivacaoLicenca;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait TraitAtivacaoLicenca
{

    use TraitEmpresaAutenticada;


    public function alertarActivacaoLicenca()
    {

        $LICENCA_DEFINITIVO = 3;


        $referencia = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['referencia'];
        $empresa  = DB::connection('mysql')->table('empresas')->where('referencia', $referencia)->first();
        $licencasAtivas = AtivacaoLicenca::where('empresa_id', $empresa->id)->get();


        $alertaLicenca  = [];

        $diasRestantes = 0;
        $diasUtilizacao = 0;



        foreach ($licencasAtivas as $key => $licencaEmpresa) {
            if ($licencaEmpresa->licenca_id === $LICENCA_DEFINITIVO) {
                $alertaLicenca = ['licenca' => 'definitiva', 'diasUtilizacao' => null, "diasRestantes" => null];
                return $alertaLicenca;
            } else {

                if ($licencaEmpresa->data_fim && $licencaEmpresa->data_inicio) {
                    $dataActual = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                    $diaFinal = Carbon::createFromFormat('Y-m-d', $licencaEmpresa->data_fim);
                    $diaInicio = Carbon::createFromFormat('Y-m-d', $licencaEmpresa->data_inicio);
                    $diasRestantes = $diasRestantes +  $dataActual->diffInDays($diaFinal);
                    $totalDiasUtilizadosLicencas = $diasUtilizacao +  $dataActual->diffInDays($diaInicio);

                    if (($diasRestantes != 0 && $diasRestantes % $this->diasDeAviso() == 0) && ($licencaEmpresa->data_notificaticao == NULL || $licencaEmpresa->data_notificaticao != $this->mostrarDataAtual())) {
                      //  $this->enviarNotificacao($empresa, $diasRestantes);
                        $this->actualizarDataNotificacao($licencaEmpresa->id, $licencaEmpresa->empresa_id);
                    }
                    if ($diasRestantes === 0) {
                        //AQui vai a informação de envio de email que terminou a licença
                    }
                    $alertaLicenca = ['diasUtilizacao' => $totalDiasUtilizadosLicencas, "diasRestantes" => $diasRestantes];
                }
            }
        }

        return $alertaLicenca;
    }
    public function actualizarDataNotificacao($licencaAtivacaoId, $empresaId)
    {
        $ativacaoLicenca = AtivacaoLicenca::where('id', $licencaAtivacaoId)->where('empresa_id', $empresaId)->find($licencaAtivacaoId);
        $ativacaoLicenca->data_notificaticao = $this->mostrarDataAtual();
        $ativacaoLicenca->save();
    }
    public function mostrarDataAtual()
    {
        return date('Y-m-d');
    }

    /**
     * 10 dias para notitificar a empresa
     */
    public function diasDeAviso()
    {
        $parametro = DB::connection('mysql')->table('parametros')->where('id', 2)->first();
        return $parametro->valor;
    }
    public function enviarNotificacao($empresa, $diasRestantes)
    {
        $infoEmail['dias_restante'] = $diasRestantes;
        $infoEmail['nome'] = $empresa->nome;
        $infoEmail['email'] = $empresa->email;
        $infoEmail['pessoal_Contacto'] = $empresa->pessoal_Contacto;
        //FIM ENVIO EMAIL
       // JobMailPrazoLicencaEmpresa::dispatch($infoEmail)->delay(now()->addSecond('5'));
    }
}
