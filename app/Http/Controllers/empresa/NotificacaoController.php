<?php

namespace App\Http\Controllers\empresa;

use App\empresa\Notification;
use App\Http\Controllers\Controller;
use App\Models\empresa\Notification as EmpresaNotification;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacaoController extends Controller
{
    //
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;


    public function notifications(Request $request)
    {
        
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $data['guard'] = $empresa['guard'];

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $notifications = $empresa['empresa']->unreadNotifications;

        return response()->json(compact('notifications'), 200);
    }
    public function notificationsAll(Request $request)
    {
        
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $data['guard'] = $empresa['guard'];

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $notifications = $empresa['empresa']->notifications;
        return response()->json(compact('notifications'), 200);
    }
    public function listarNotificacoes()
    {

        
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $data['guard'] = $empresa['guard'];

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }
        return view('empresa.notificacoes.index', $data);
    }
    public function markAsRead(Request $request)
    {
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $notifications = $empresa['empresa']->notifications()->where('id', $request->id)->first();
        if ($notifications) {
            $notifications->markAsRead();
            return response()->json($notifications, 200);
        }

        return response()->json(['error' => 'erro ao ler notificacao'], 400);
    }
    public function deletar($id)
    {
        $notifications = EmpresaNotification::find($id);
        $notifications->delete();

        return response()->json($notifications, 200);

    }
}
