<?php

namespace App\Repositories\Admin\contracts;


interface UserRepositoryInterface
{
    public function createUser(array $data);
    public function updateUser(array $data, int $id);
    public function deleteUser(int $id);
    public function getAllUsers();
    public function getUser(int $id);
}
