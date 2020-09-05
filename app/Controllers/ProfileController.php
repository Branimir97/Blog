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

    public function __construct(\PDO $db)
    {
        $this->db = $db;

        $this->loggedInUsername = $_SESSION['loggedIn_username'];

        $this->userStorage = new MySqlDatabaseUserStorage($this->db);

        try {
            echo parent::render('ProfileView', ['userDetails'=>$this->getUserDetails()]);
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