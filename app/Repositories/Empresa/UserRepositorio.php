<?php

namespace App\Repositories\Empresa;


use App\Models\empresa\Factura;
use App\Models\empresa\FacturaItems;
use App\Models\empresa\RecibosItem;
use App\Models\empresa\FacturaOriginal;
use App\Models\empresa\FacturaItemsOriginal;
use App\Interfaces\Empresa\CrudDao;
use App\Models\Empre\User;
use App\Models\empresa\User as UserEmpresa;
use App\Models\empresa\NotaCredito;
use App\Models\empresa\NotaDebito;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\TraitChavesEmpresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\empresa\Statu;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;






class UserRepositorio implements CrudDao
{

    use TraitEmpresaAutenticada;
    use TraitChavesEmpresa;

    private $TIPO_ADMIN = 1;
    private $TIPO_EMPRESA = 2;
    private $TIPO_FUNCIONARIO = 3;
    private $STATUS_ATIVO = 1;
    private $TIPO_USER_CLIENTE = 3;
    private $CANAL_CLIENTE = 2;

    protected $model = User::class;


    public function all()
    {
    }
    public function store(Request $request)
    {


        $empresaId = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];


        try {

            $data = $request->except('email_verified_at');
            $data['password'] = Hash::make('mutue123');
            $data['canal_id'] = $this->CANAL_CLIENTE;
            $data['tipo_user_id'] = $this->TIPO_USER_CLIENTE;
            $data['status_id'] = $this->STATUS_ATIVO;
            $data['empresa_id'] = $empresaId;

            if (isset($request->foto) && !empty($request['foto'])) {
                $data['foto'] = $request->foto->store('/utilizadores/cliente');
            } else {
                $data['foto'] = "utilizadores/cliente/avatarEmpresa.png";
            }

            $user = UserEmpresa::create($data);
            if ($user) {
                $user->assignRole('Funcionario');
            }

            return $user;
        } catch (\Exception $th) {
            throw new Exception("Erro ao cadastrar usuário", 1);
        }
    }



    public function camposUsuario($usuario)
    {
        return [
            'id' => $usuario['id'],
            'name' => $usuario['name'],
            'telefone' => $usuario['telefone'],
            'email' => $usuario['email'],
            'password' => $usuario['password'],
            'canal_id' => $usuario['canal_id'],
            'tipo_user_id' => $usuario['tipo_user_id'],
            'status_id' => $usuario['status_id'],
            'status_senha_id' => $usuario['status_senha_id'],
            'username' => $usuario['username'],
            'foto' => $usuario['foto'],
            'empresa_id' => $usuario['empresa_id']
        ];
    }

    public function update(Request $request, $id)
    {


        $empresaId = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];

        DB::beginTransaction();

        try {


            $user = DB::connection('mysql2')->table('users_cliente')->where('empresa_id', $empresaId)->where('id', $id)->first();

            if (isset($request->all()['logotipo']) && !empty($request->all()['logotipo'])) {
                if ($user->foto) {
                    unlink(public_path() . "\.." . "\\storage\\app\\public\\" . $user->foto);
                }
                $photoName = $request->logotipo->store('/utilizadores/cliente');
            } else {
                $photoName = $user->foto;
            }

            if ($user->tipo_user_id == $this->TIPO_EMPRESA) {

                DB::connection('mysql2')->table('users_cliente')->where('id', $id)->where('empresa_id', $empresaId)->update(
                    [
                        'name' => $request->name,
                        'username' => $request->username,
                        'email' => $request->email,
                        'telefone' => $request->telefone,
                        'foto' => $photoName
                    ]
                );
                DB::connection('mysql')->table('users_admin')->where('telefone', $user->telefone)->update(
                    [
                        'name' => $request->name,
                        'username' => $request->username,
                        'email' => $request->email,
                        'telefone' => $request->telefone,
                        'foto' => $photoName
                    ]
                );
            } else if ($user->tipo_user_id == $this->TIPO_FUNCIONARIO) {

                DB::connection('mysql2')->table('users_cliente')->where('id', $id)->where('empresa_id', $empresaId)->update(
                    [
                        'name' => $request->name,
                        'username' => $request->username,
                        'email' => $request->email,
                        'telefone' => $request->telefone,
                        'foto' => $photoName
                    ]
                );
            }

            if (DB::commit() == null)
                return true;
            DB::commit();
        } catch (\Exception $th) {
            DB::rollBack();
        }
    }

    public function destroy($id)
    {
    }
}
