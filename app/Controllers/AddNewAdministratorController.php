<?php

namespace Controllers;

use Exceptions\TemplateNotFoundException;
use Models\View;
use Storage\MySqlDatabaseUserStorage;

class AddNewAdministratorController extends View
{
    protected $db;

    protected $userStorage;

    protected $admins;

    protected $users;

    public function __construct(\PDO $db)
    {
        $this->db = $db;

        $this->userStorage = new MySqlDatabaseUserStorage($this->db);

        $this->admins = $this->getAllAdmins();

        $this->users = $this->getAllUsers();

        try {
            echo parent::render('NewAdministratorView', ['admins'=>$this->admins, 'users'=>$this->users]);

        } catch(TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getAllAdmins()
    {
        return $this->userStorage->all('admin');
    }

    public function getAllUsers()
    {
        return $this->userStorage->all('user');
    }
}