<?php

namespace Controllers;

use Exceptions\TemplateNotFoundException;
use Models\View;
use Storage\MySqlDatabaseUserStorage;

class ProfileController extends View
{

    protected $db;

    protected $loggedInUsername;

    protected $userStorage;

    protected $changedPassword;


    public function __construct(\PDO $db)
    {
        $this->db = $db;

        if(isset($_SESSION['loggedIn_username']))
        {
            $this->loggedInUsername = $_SESSION['loggedIn_username'];
        }

        $this->userStorage = new MySqlDatabaseUserStorage($this->db);

        if(isset($_SESSION['changed_password']))
        {
            $this->changedPassword = $_SESSION['changed_password'];
            unset($_SESSION['changed_password']);
        }


    }

    public function indexAction()
    {
        try {
            echo parent::render('ProfileView', ['userDetails'=>$this->getUserDetails(), 'changedPassword'=>$this->changedPassword]);
        } catch (TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getUserDetails()
    {
        return $this->userStorage->get($this->loggedInUsername);
    }

    public function deleteAction()
    {
        $this->userStorage->delete($this->loggedInUsername);
    }
}