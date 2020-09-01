<?php


namespace Controllers;

use Exceptions\TemplateNotFoundException;
use Models\User;
use Models\View;
use Storage\MySqlDatabaseUserStorage;


class LoginController extends View
{
    protected $db;

    protected $storage;

    protected $error;

    protected $registered;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
        $this->storage = new MySqlDatabaseUserStorage($this->db);

        if(isset($_SESSION['error']))
        {
            $this->error =  $_SESSION['error'];
            session_destroy();
        }

        if(isset($_SESSION['registered']))
        {
            $this->registered = $_SESSION['registered'];
            session_destroy();
        }

        try {
            echo parent::render('LoginView', ['error'=> $this->error, 'registered'=>$this->registered]);

        } catch (TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }

    }


    public function authenticateAction()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if(isset($_POST['submit']))
            {
                $user = new User();
                $user->setUsername($_POST['username']);
                $user->setPassword($_POST['password']);


                $this->storage->authenticate($user);

            }
        }
    }


}