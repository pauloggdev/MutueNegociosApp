<?php

namespace App\Traits\Empresa;

use App\Jobs\JobMailPrazoLicencaEmpresa;
use App\Jobs\JobNotificacaoFimLicenca;
use App\Jobs\JobNotificacaoLicenca;
use App\Models\admin\AtivacaoLicenca;
use App\Models\admin\Empresa;
use Illuminate\Support\Facades\Auth;
use App\Models\empresa\Empresa_Cliente;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait TraitEmpresaAutenticada
{

    public function pegarEmpresaAutenticadaGuardOperador()
    {


        $TIPO_USUARIO_EMPRESA = 2;
        $TIPO_USUARIO_FUNCIONARIO = 3;

        if (Auth::guard('web')->check()) {
            $data['guard'] = Auth::guard('web')->user();
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $data['empresa'] = Empresa_Cliente::with('tiporegime')->where('referencia', $referencia)->first();
            $data['tipo_user_id'] = $TIPO_USUARIO_EMPRESA;
        } else {
            $data['guard'] = Auth::guard('empresa')->user();
            $empresa_id = Auth::user()->empresa_id;
            $data['empresa'] = Empresa_Cliente::with('tiporegime')->where('id', $empresa_id)->first();
            $data['tipo_user_id'] = $TIPO_USUARIO_FUNCIONARIO;
        }
        $data['operador'] = Auth::user()->id;
        return $data;
    }
    /*
    public function pegarEmpresaAutenticadaGuardOperador()
    {

        $TIPO_USUARIO_EMPRESA = 2;
        $TIPO_USUARIO_FUNCIONARIO = 3;

        if (Auth::guard('web')->check()) {
            $data['guard'] = Auth::guard('web')->user();
            $empresa = DB::connection('mysql')->table('users_admin')->select('empresa_id')->where('id', Auth::user()->id)->first();
            $referencia = Empresa::where('id', $empresa->empresa_id)->first()->referencia;
            $data['empresa'] = Empresa_Cliente::with('tiporegime')->where('referencia', (string)$referencia)->first();
            $data['tipo_user_id'] = $TIPO_USUARIO_EMPRESA;
        } else {
            $data['guard'] = Auth::guard('empresa')->user();
            $empresa_id = Auth::user()->empresa_id;
            $data['empresa'] = Empresa_Cliente::with('tiporegime')->where('id', $empresa_id)->first();
            $data['tipo_user_id'] = $TIPO_USUARIO_FUNCIONARIO;
        }
        $data['operador'] = Auth::user()->id;
        return $data;
    }
 */

    /**
     * Alerta de activação de licença
     */

    public function alertarActivacaoLicenca()
    {
        $LICENCA_DEFINITIVO = 4;
        $LICENCA_ATIVA = 1;
        $empresaCliente = $this->pegarEmpresaAutenticadaGuardOperador();

        $empresa  = DB::connection('mysql')->table('empresas')->where('referencia', $empresaCliente['empresa']['referencia'])->first();
        $licencasAtivas = AtivacaoLicenca::where('empresa_id', $empresa->id)->get();

        $alertaLicenca  = [];

        $diasRestantes = 0;
        $diasUtilizacao = 0;
        $totalDiasLicenca = 0;
        $licencaGratis = true;


        foreach ($licencasAtivas as $key => $licencaEmpresa) {

            if ($licencaEmpresa->data_fim == NULL && $licencaEmpresa->licenca_id == $LICENCA_DEFINITIVO && $licencaEmpresa->status_licenca_id == $LICENCA_ATIVA) {
                $alertaLicenca = ['licenca' => 'definitiva', 'diasUtilizacao' => null, "diasRestantes" => null];
                DB::connection('mysql')->table('empresas')->where('id', $licencaEmpresa->empresa_id)->update(['licenca' => 'ativo']);
                return $alertaLicenca;
            } else {

                if ($licencaEmpresa->data_fim && $licencaEmpresa->data_inicio && $licencaEmpresa->status_licenca_id == $LICENCA_ATIVA) {

                    $dataActual = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                    $dataFinal = Carbon::createFromFormat('Y-m-d', $licencaEmpresa->data_fim);
                    $dataInicial = Carbon::createFromFormat('Y-m-d', $licencaEmpresa->data_inicio);



                    if ($dataActual <= $dataFinal) {
                        DB::connection('mysql')->table('empresas')->where('id', $licencaEmpresa->empresa_id)->update(['licenca' => "ativo"]);
                        $diasRestantes = $dataActual->diffInDays($dataFinal);
                    }


                    $totalDiasLicenca += $dataInicial->diffInDays($dataFinal);
                    $diasUtilizacao = $totalDiasLicenca  - $diasRestantes;

                    if (($diasRestantes != 0 && $diasRestantes < 31 && $diasRestantes % $this->diasDeAviso() == 0) && ($licencaEmpresa->data_notificaticao != $this->mostrarDataAtual())) {
                        $this->actualizarDataNotificacao($licencaEmpresa->id, $licencaEmpresa->empresa_id);
                    }

                    if ($diasRestantes === 0 && $licencaEmpresa->notificacaoFimLicenca == NULL) {
                        $this->enviarNotificacaoFimLicenca($empresaCliente['empresa'], $diasRestantes);
                        $this->actualizarDataNotificacaoFimLicenca($licencaEmpresa->id, $licencaEmpresa->empresa_id);
                    }else{
                        if($diasRestantes === 0){
                            DB::connection('mysql')->table('empresas')->where('id', $licencaEmpresa->empresa_id)->update(['licenca' => "expirada"]);
                        }
                    }
                    if ($licencaEmpresa->licenca_id != 1) {
                        $licencaGratis = false;
                    }
                    $alertaLicenca = ['diasUtilizacao' => $diasUtilizacao, "diasRestantes" => $diasRestantes, "licencaGratis" => $licencaGratis];


                    /*

                    $dataActual = Carbon::createFromFormat('Y-m-d', '2021-03-22');
                    $dataFinal = Carbon::createFromFormat('Y-m-d', $licencaEmpresa->data_fim);
                    $dataInicial = Carbon::createFromFormat('Y-m-d', $licencaEmpresa->data_inicio);

                    $outro += $dataActual->diffInDays($dataFinal);
                    $total += $dataInicial->diffInDays($dataFinal);
                    if ($dataActual < $dataFinal) {
                        $diasRestantes = $diasRestantes +  $dataActual->diffInDays($dataFinal);
                        $diasUtilizacao = $diasUtilizacao + ($dataInicial->diffInDays($dataFinal) - $diasRestantes);
                    }

                    if (($diasRestantes != 0 && $diasRestantes < 31 && $diasRestantes % $this->diasDeAviso() == 0) && ($licencaEmpresa->data_notificaticao != $this->mostrarDataAtual())) {
                        $this->enviarNotificacao($empresaCliente['empresa'], $diasRestantes);
                        $this->actualizarDataNotificacao($licencaEmpresa->id, $licencaEmpresa->empresa_id);
                    }
                    if ($diasRestantes === 0) {
                     //   $this->enviarNotificacaoFimLicenca($empresaCliente['empresa'], $diasRestantes);
                    }
                    $alertaLicenca = ['diasUtilizacao' => $diasUtilizacao, "diasRestantes" => $diasRestantes];
                    */
                }
            }
        }
        return $alertaLicenca;
    }
    public function enviarNotificacaoFimLicenca($empresa, $diasRestantes)
    {

        $infoEmail['diasRestante'] = $diasRestantes;
        $infoEmail['nome'] = $empresa->nome;
        $infoEmail['email'] = $empresa->email;
        $infoEmail['pessoal_Contacto'] = $empresa->pessoal_Contacto;
        //FIM ENVIO EMAIL
        JobNotificacaoFimLicenca::dispatch($infoEmail)->delay(now()->addSecond('5'));
    }
    public function actualizarDataNotificacaoFimLicenca($licencaAtivacaoId, $empresaId)
    {
        $ativacaoLicenca = AtivacaoLicenca::where('id', $licencaAtivacaoId)->where('empresa_id', $empresaId)->find($licencaAtivacaoId);
        $ativacaoLicenca->notificacaoFimLicenca = $this->mostrarDataAtual();
        $ativacaoLicenca->save();
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
        $infoEmail['diasRestante'] = $diasRestantes;
        $infoEmail['nome'] = $empresa->nome;
        $infoEmail['email'] = $empresa->email;
        $infoEmail['pessoal_Contacto'] = $empresa->pessoal_Contacto;
        //FIM ENVIO EMAIL
        JobNotificacaoLicenca::dispatch($infoEmail)->delay(now()->addSecond('5'));
    }
}
