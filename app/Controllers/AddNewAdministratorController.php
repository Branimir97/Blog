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
    }

    public function indexAction()
    {
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

    public function changeRoleAction()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if(isset($_POST['submit_changeRole']))
            {
                $id = $_POST['id'];
                $role = $_POST['role'];
                $this->userStorage->changeRole($id, $role);
            }
        }
    }
}