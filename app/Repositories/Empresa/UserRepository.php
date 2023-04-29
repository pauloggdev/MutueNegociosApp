<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Str;

class UserRepository
{

    use LivewireAlert;
    protected $entity;


    public function __construct(User $user)
    {
        $this->entity = $user;
    }

    public function quantidadeUsers()
    {
        return $this->entity::where('empresa_id', auth()->user()->empresa_id)->count();
    }

    public function createNewUser(array $data)
    {

        if (isset($data['foto']) && !empty($data['foto'])) {
            $data['foto'] = $data['foto']->store('/utilizadores/cliente/');
        } else {
            $data['foto'] = 'utilizadores/cliente/avatarEmpresa.png';
        }

        $qtyUser = $this->quantidadeUsers();

        $user = $this->entity->create([
            'name' => $data['name'],
            'username' => $data['username'] ?: $data['name'],
            'email' => $data['email'],
            'telefone' => $data['telefone'],
            'password' => Hash::make('mutue123'),
            'tipo_user_id' => 2,
            'status_id' => $data['status_id'],
            'statusUserAdicional' => $qtyUser >= 2 ? 2 : 1,
            'status_senha_id' => 1,
            'canal_id' => 2,
            'empresa_id' => auth()->user()->empresa_id,
            'foto' => $data['foto'],
            'uuid' => Str::uuid()
        ]);

        //Adicionar um perfil ao utilizador
        foreach ($data['roles'] as $role_id) {
            DB::table('user_perfil')->insert([
                'user_id' => $user->id,
                'perfil_id' => $role_id
            ]);
        }
        return $user;
    }


    public function updateUser($user, $roles)
    {
        // if (isset($data['foto_atual']) && !empty($data['foto_atual'])) {
        //     if (($data['foto'] != 'utilizadores/cliente/avatarEmpresa.png') && $data['foto']) {
        //         $path = public_path() . "\\upload\\" . $data['foto'];
        //         if (file_exists($path)) {
        //             unlink(public_path() . "\\upload\\" . $data['foto']);
        //         }
        //     }
        //     $data['foto'] = $data['foto_atual']->store('/utilizadores/cliente/');
        // }



        DB::table('user_perfil')->where('user_id', $user->id)->delete();
        foreach ($roles as $role_id) {
            DB::table('user_perfil')->insert([
                'user_id' => $user->id,
                'perfil_id' => $role_id
            ]);
        }
        return $this->entity::where('id', $user->id)
            ->where('empresa_id', auth()->user()->empresa_id)->update([
                'name' => $user['name'],
                'username' => $user['username'] ?: $user['name'],
                'email' => $user['email'],
                'telefone' => $user['telefone'],
                'status_id' => $user['status_id'],
                'empresa_id' => auth()->user()->empresa_id
            ]);
    }

    public function getUsers($search = null)
    {
        $users = $this->entity::with(['statuGeral', 'perfis'])->search(trim($search))
            ->where('empresa_id', auth()->user()->empresa_id)
            ->paginate();
        return $users;
    }
    public function getUser($uuid)
    {
        $user = $this->entity::with(['statuGeral', 'perfis'])->where('empresa_id', auth()->user()->empresa_id)
            ->where('uuid', $uuid)->first();
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
    public function deletarUtilizador($utilizadorId)
    {

        return $this->entity::where('id', $utilizadorId)
            ->where('empresa_id', auth()->user()->empresa_id)
            ->delete();
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
