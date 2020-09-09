<?php

namespace Storage\Contracts;

use Models\User;

interface UserStorageInterface
{
    public function save(User $user);

    public function authenticate(User $user);

    public function all($role);

    public function changeRole($id, $role);

    public function get($username);

    public function delete($username);

    public function changePassword($oldPassword, $newPassword, $newPassword2);

    public function checkUsername($username);

    public function checkEmail($email);
}