<?php

namespace App\Http\Controllers\admin;

use App\Models\admin\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacaoController extends Controller
{



  public function notifications(Request $request)
  {
    $notifications = Notification::where('read_at', '=', null)->get();
    return response()->json(compact('notifications'), 200);
  }
  public function notificationsAll(Request $request)
  {
    $data['notifications'] = Notification::get();
    return response()->json($data, 200);
  }
  public function listarNotificacoes()
  {

    if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
      return view('empresa.dashboard');
    }
    return view('admin.notificacoes.index');
  }
  public function markAsRead(Request $request)
  {


    $notifications = Notification::find($request->id);
    if ($notifications) {
      $notifications->markAsRead();
      return response()->json($notifications, 200);
    }

    return response()->json(['error' => 'erro ao ler notificacao'], 400);
  }
  public function deletar($id)
  {
    $notifications = Notification::find($id);
    $notifications->delete();

    return response()->json($notifications, 200);
  }
}
