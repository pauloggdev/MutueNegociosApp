<?php

namespace App\Http\Controllers\admin\Users;

use App\Http\Resources\Admin\UserResource as AdminUserResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Livewire\Component;


class UserStoreController extends Component
{
    public function render()
    {
        return view('livewire.user-store-controller');
    }
    public function store(Request $request)
    {
        $isApi = $request->segment(1) === 'api' ? true : false;
        $mensagem =  [
            'name.required' => 'Nome é obrigatorio',
            'email.required' => 'E-mail é obrigatorio',
            'telefone.required' => 'Telefone é obrigatorio',
            'email.unique' => 'E-mail já cadastrado',
            'telefone.unique' => 'Telefone já cadastrado'
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            // 'email' => 'required|exists:mysql.mutue_negocios_admin.users_admin,email',
            'email' => 'required|unique:mysql.users_admin|email|min:3',
            'telefone' => 'required|min:9|numeric|unique:mysql.users_admin',
            'foto' => 'image|max:1024'
        ], $mensagem);

        if ($validator->fails()) {
            if ($isApi) {
                return response()->json($validator->errors()->messages(), 401);
            }
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $user = $this->userService->createNewUser($request->all());

        if ($user) {
            if ($isApi) {
                return new AdminUserResource($user);
            } else {

                // return redirect()->route('admin.users.index')->with('success', 'User Deleted successfully.');
                Session::flash('message', 'Operação realizada com sucesso!');
                Session::flash('alert-class', 'alert-success');

                return redirect()->back();
            }
        }
    }
}
