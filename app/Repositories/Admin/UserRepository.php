<?php

namespace App\Repositories\Admin;

use App\Models\admin\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UserRepository
{

    use LivewireAlert;
    protected $entity;


    public function __construct(User $user)
    {
        $this->entity = $user;
    }

    public function createNewUser(array $data)
    {

        $data['password'] = Hash::make('mutue123');
        $data['canal_id'] = 3; //Portal admin
        $data['tipo_user_id'] = 1; //Admin
        $data['status_senha_id'] = 2; //Seguro

        if (isset($data['foto']) && !empty($data['foto'])) {
            $data['foto'] = $data['foto']->store('/utilizadores/cliente/');
        } else {
            $data['foto'] = 'utilizadores/cliente/avatarEmpresa.png';
        }
        return $this->entity->create($data);
    }

    public function updateUser($data)
    {
        if (isset($data['foto_atual']) && !empty($data['foto_atual'])) {

            if (($data['foto'] != 'utilizadores/cliente/avatarEmpresa.png') && $data['foto']) {
                $path = public_path() . "\\upload\\" . $data['foto'];
                if (file_exists($path)) {
                    unlink(public_path() . "\\upload\\" . $data['foto']);
                }
            }
            $data['foto'] = $data['foto_atual']->store('/utilizadores/cliente/');
        }
        $this->entity::where('id', $data['id'])->update([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'telefone' => $data['telefone'],
            'foto' => $data['foto'],
            'status_id' => $data['status_id'],
        ]);
    }

    public function getUsers($byStatus, $search, $perpage)
    {
        $users = User::with(['statuGeral'])->when($byStatus, function ($query) use ($byStatus) {
            $query->where('status_id', $byStatus);
        })
            ->search(trim($search))
            ->paginate($perpage);

        return $users;
    }
    public function getUser(int $id)
    {
        $user = $this->entity::find($id);
        return $user;
    }
    public function updatePassword($user)
    {
        $user =  DB::connection('mysql')->table('users_admin')->update([
            'password' => Hash::make($user['password']),
            'updated_at' => Carbon::now(),
        ]);
        return $user;
    }

    public function alterarSenha(Request $request, $userId)
    {

        if (auth()->user()->id == $userId) {
            $user = $this->entity::findOrfail($userId);

            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->password);
                $user->updated_at = Carbon::now();
                $user->status_senha_id = 2;
                $user->remember_token = $request->_token;
                $user->save();
                return redirect()->route('admin.users.perfil')->withSuccess(' Senha Alterada com Sucesso!');
            } else {
                return redirect()->back()->withErrors('A senha antiga não corresponde com a deste utilizador!');
            }
        } else {
            return redirect()->back()->withErrors('Sem permissão para efectuar esta operação!');
        }
    }
}
