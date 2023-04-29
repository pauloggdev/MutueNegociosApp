<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolesPermissionController extends Controller
{
    
    public function rolesPermissions(){
        
        $nameUser = Auth::user()->name;

        echo("<h1>{$nameUser}</h1>");

        foreach (Auth::user()->roles as $role) {
            echo "<strong>$role->name : </strong>";

            $permissions = $role->permissions;


            foreach ($permissions as $permission) {
                echo "$permission->name, ";
            }
            echo '<hr>';
        }
       // return 
    }
}
