<?php

namespace App\Application\UseCase;

use App\Domain\Entity\CouponDesconto;
use App\Domain\Entity\PagamentoVendaOnline;
use App\Domain\Factory\RepositoryFactory;
use App\Domain\Service\INotificacaoService;
use App\Infra\Repository\CouponDescontoRepository;
use App\Infra\Repository\FaturaVendaOnlineRepository;
use App\Infra\Repository\PagamentoVendaOnlineRepository;
use App\Infra\Repository\UserRepository;
use Illuminate\Support\Facades\Log;

class EnviarPagamentoVendaOnline
{
    private PagamentoVendaOnlineRepository $pagamentoVendaOnlineRepository;
    private UserRepository $userRepository;
    private CouponDescontoRepository $couponDescontoRepository;
    private FaturaVendaOnlineRepository $faturaVendaOnlineRepository;
    private array $INotificacoesService;
    public function __construct(RepositoryFactory $repositoryFactory, array $INotificacoesService)
    {
        $this->pagamentoVendaOnlineRepository = $repositoryFactory->createPagamentoVendaOnlineRepository();
        $this->INotificacoesService = $INotificacoesService;
        $this->userRepository = $repositoryFactory->createUserRepository();
        $this->couponDescontoRepository = $repositoryFactory->createCouponDescontoRepository();
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

        //$outputFatura = $this->faturaVendaOnlineRepository->salvar();
        
        $usersNotificados = $this->userRepository->emaisUserParaNotificar();
        if($request->codigoCoupon){
            $coupon = $this->couponDescontoRepository->getCoupon($request->codigoCoupon);
            if(!$coupon){
                throw new \Error('Codigo do coupon não encontrado');
            }
            $couponDesconto = new CouponDesconto($coupon->codigo, $coupon->percentagem, $coupon->used,$coupon->dataExpiracao);
        }
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
