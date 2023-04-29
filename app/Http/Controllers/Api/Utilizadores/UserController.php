<?php

namespace App\Http\Controllers\Api\Utilizadores;

use App\Http\Controllers\Controller;
use App\Models\empresa\User;
use App\Repositories\Empresa\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function quantidadeUtilizadores()
    {
        return $this->userRepository->quantidadeUsers();

    }
}
