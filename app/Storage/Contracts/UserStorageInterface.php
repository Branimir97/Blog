<?php

namespace Storage\Contracts;

use Models\User;

interface UserStorageInterface
{
    public function save(User $user);

    public function authenticate(User $user);
}