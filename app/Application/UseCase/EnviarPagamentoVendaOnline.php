<?php

namespace App\Application\UseCase;
use App\Domain\Entity\CouponDesconto;
use App\Domain\Entity\FaturaItemsVendaOnline;
use App\Domain\Entity\FaturaVendaOnline;
use App\Domain\Entity\PagamentoVendaOnline;
use App\Domain\Factory\RepositoryFactory;
use App\Domain\Interfaces\IGeradorNumeracaoDocumento;
use App\Domain\Service\INotificacaoService;
use App\Infra\Repository\CarrinhoRepository;
use App\Infra\Repository\CouponDescontoRepository;
use App\Infra\Repository\FaturaVendaOnlineRepository;
use App\Infra\Repository\PagamentoVendaOnlineRepository;
use App\Infra\Repository\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EnviarPagamentoVendaOnline
{
    private PagamentoVendaOnlineRepository $pagamentoVendaOnlineRepository;
    private UserRepository $userRepository;
    private CarrinhoRepository $carrinhoRepository;
    private CouponDescontoRepository $couponDescontoRepository;
    private FaturaVendaOnlineRepository $faturaVendaOnlineRepository;
    private array $INotificacoesService;
    private IGeradorNumeracaoDocumento $IGeradorNumeracaoDocumento;
    public function __construct(RepositoryFactory $repositoryFactory, array $INotificacoesService, IGeradorNumeracaoDocumento $IGeradorNumeracaoDocumento)
    {
        $this->pagamentoVendaOnlineRepository = $repositoryFactory->createPagamentoVendaOnlineRepository();
        $this->INotificacoesService = $INotificacoesService;
        $this->IGeradorNumeracaoDocumento = $IGeradorNumeracaoDocumento;
        $this->userRepository = $repositoryFactory->createUserRepository();
        $this->couponDescontoRepository = $repositoryFactory->createCouponDescontoRepository();
        $this->carrinhoRepository = $repositoryFactory->createCarrinhoRepository();
        $this->faturaVendaOnlineRepository = $repositoryFactory->createFaturaPagamentoVendaOnlineRepository();
    }
    public function execute($request){
        $request = (object) $request;
        $pagamentoVendaOnline = new PagamentoVendaOnline(
            $request->comprovativoBancario,
            $request->dataPagamentoBanco,
            $request->formaPagamentoId,
            $request->bancoId,
            $request->iban
        );
        $outputPagamento = $this->pagamentoVendaOnlineRepository->salvar($pagamentoVendaOnline);
        $carrinhos = $this->carrinhoRepository->getCarrinhos();
        if($request->codigoCoupon){
            $coupon = $this->couponDescontoRepository->getCoupon($request->codigoCoupon);
            if(!$coupon){
                throw new \Error('Codigo do coupon não encontrado');
            }
            $couponDesconto = new CouponDesconto($coupon->codigo, $coupon->percentagem, $coupon->used,$coupon->data_expiracao);
        }else{
            $couponDesconto = new CouponDesconto('VALE0', 0, 'Y', Carbon::now());
        }
        $numeracaoDocumento = $this->IGeradorNumeracaoDocumento->gerarNumeracao();
        $numSequenciaDocumento = $this->IGeradorNumeracaoDocumento->numSequenciaDocumento();

        $fatura = new FaturaVendaOnline(
            $carrinhos[0]['user']['cliente']['nome'],
            $carrinhos[0]['user']['cliente']['nif'],
            $carrinhos[0]['user']['cliente']['email'],
            $carrinhos[0]['user']['cliente']['endereco'],
            $carrinhos[0]['user']['cliente']['telefone_cliente'],
            $carrinhos[0]['user']['cliente']['conta_corrente'],
            $carrinhos[0]['user']['cliente']['id'],
            $numeracaoDocumento,
            $numSequenciaDocumento,
            $request->observacao,
            $couponDesconto
        );
        foreach ($carrinhos as $carrinho){
            $faturaItem = new FaturaItemsVendaOnline($carrinho->produto->preco_venda, $carrinho->quantidade, $carrinho->produto->tipoTaxa->taxa);
            $fatura->addItem($faturaItem);
        }
        $outputFatura = $this->faturaVendaOnlineRepository->salvar($fatura);
        $usersNotificados = $this->userRepository->emaisUserParaNotificar();
        $mensagem = "Notificação de pagamento de uma fatura para vendas online";
        try {
            foreach ($this->INotificacoesService as $INotificacaoService){
                 $INotificacaoService->notificar($usersNotificados, $mensagem);
            }
        }catch (\Exception $e){
            Log::error($e->getMessage());
        }
        return $outputPagamento;
    }
}
