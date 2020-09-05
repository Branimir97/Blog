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
}