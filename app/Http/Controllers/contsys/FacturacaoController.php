<?php

namespace App\Http\Controllers\contsys;
use App\Models\contsys\Movimento;
use App\Models\contsys\MovimentoItems;
use Illuminate\Support\Facades\DB;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;



class FacturacaoController{

    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;


    public function cadastrarMovimentos($factura)
    {
        $movimentos = new Movimento();
        $movimentos->DataMovimento = $factura->created_at;
        $movimentos->Descricao = $this->getDescricao($factura);
        $movimentos->CodigoUtilizador = $this->getUtilizadorContsysId($factura->empresa_id, $factura->user_id);
        $movimentos->CodEmpresa = $this->getEmpresaContsysId($factura);
        $movimentos->AnoFinanceiro = date("Y");
        $movimentos->CodigoCentroCusto = 1;
        $movimentos->TipoDocumento = 1;
        $movimentos->forma = 0;
        $movimentos->CodigoStatus = 1;
        $movimentos->telefoneCliente = $factura->telefone_cliente;
        $movimentos->nifCliente = $factura->nif_cliente;
        $movimentos->NomeCliente = $factura->nome_do_cliente;
        $movimentos->morada = $factura->endereco_cliente;
        $movimentos->TipoMovimento = $this->getTipoMovimento($factura);
        $movimentos->save();
        return $movimentos;
    }
    public function getSubContaContsys($clienteId, $factura)
    {
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador()['empresa'];
        $empresaContsys = DB::connection('mysql3')->table('empresas')->where('referenciaEmpresa', $empresa['referencia'])->first();
        $subContaContsys = DB::connection('mysql3')->table('subcontas')->where('codigoCliente', $clienteId)->where('CodEmpresa', $empresaContsys->Codigo)->first();
        return $subContaContsys->Codigo;
    }
    public function cadastrarMovimentosItems1($clienteId, $factura, $movimentos)
    {

        $DEBITO = 1;
        $FACTURA_RECIBO = 1;
        $DIVERSOS = 3;

        $movimentosItems = new MovimentoItems();
        $movimentosItems->CodigoConta = $this->getSubContaContsys($clienteId, $factura);
        $movimentosItems->CodigoTipoMovimento = $factura->tipo_documento == $FACTURA_RECIBO ? $DIVERSOS : $DEBITO;
        $movimentosItems->Valor = $factura->valor_a_pagar;
        $movimentosItems->OBS = $this->getDescricao($factura);
        $movimentosItems->CodigoMoeda = 1; //moeda kz
        $movimentosItems->Cambio = 1;
        $movimentosItems->CodigoMovimento = $movimentos->Codigo;
        $movimentosItems->save();
    }
    public function cadastrarMovimentosItems2($factura, $movimentos)
    {

        $CREDITO = 2;
        $FACTURA_RECIBO = 1;
        $DIVERSOS = 3;
        $SUBCONTA_NACIONAL = 391;

        $movimentosItems = new MovimentoItems();
        $movimentosItems->CodigoConta = $SUBCONTA_NACIONAL;
        $movimentosItems->CodigoTipoMovimento = $factura->tipo_documento == $FACTURA_RECIBO ? $DIVERSOS : $CREDITO;
        $movimentosItems->Valor = $factura->valor_a_pagar;
        $movimentosItems->OBS = $this->getDescricao($factura);
        $movimentosItems->CodigoMoeda = 1; //moeda kz
        $movimentosItems->Cambio = 1;
        $movimentosItems->CodigoMovimento = $movimentos->Codigo;
        $movimentosItems->save();
    }
    public function getDescricao($factura)
    {
        switch ($factura->tipo_documento) {
            case 1:
                return "VENDA A PRONTO, FACTURA RECIBO N. " . $factura->id;
                break;
            case 2:
                return "VENDA A CREDITO, FACTURA N. " . $factura->id;
                break;
            default:
                return "VENDA A PRONTO, FACTURA RECIBO N. " . $factura->id;
                break;
        }
    }
    public function getTipoMovimento($factura)
    {
        switch ($factura->tipo_documento) {
            case 1:
                return "VENDA A PRONTO";
                break;
            case 2:
                return "VENDA A CREDITO";
                break;
            default:
                return "VENDA A PRONTO";
                break;
        }
    }
    public function getUtilizadorContsysId($empresaId, $userId)
    {

        $userContsys = DB::connection('mysql3')->table('utilizadores')->where('UserId', $userId)->where('empresa_id', $empresaId)->first();
        return $userContsys->Codigo;
    }
    public function getEmpresaContsysId($factura)
    {

        $empresa = DB::connection('mysql2')->table('empresas')->where('id', $factura->empresa_id)->first();
        $empresaContsys = DB::connection('mysql3')->table('empresas')->where('referenciaEmpresa', $empresa->referencia)->first();

        return $empresaContsys->Codigo;
    }
}
