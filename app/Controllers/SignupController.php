<?php

namespace Controllers;

use Exceptions\TemplateNotFoundException;
use Models\User;
use Models\View;
use Storage\MySqlDatabaseUserStorage;

class SignupController extends View
{

    protected $db;

    protected $storage;

    protected $error;

    public function __construct(\PDO $db)
    {
        $this->db = $db;

        if(isset($_SESSION['error']))
        {
            $this->error = $_SESSION['error'];
            unset($_SESSION['error']);
        }

        try {
            echo parent::render('SignUpView', ['error'=>$this->error]);
        } catch (TemplateNotFoundException $e) {
            echo $e->getMessage();
        }

    }

    public function createAction()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST") {

            if (isset($_POST['submit'])) {

                date_default_timezone_set('Europe/Zagreb');

                $user = new User();
                $user->setUsername($_POST['username']);
                $user->setFirstName($_POST['first_name']);
                $user->setLastName($_POST['last_name']);
                $user->setEmail($_POST['email']);
                $user->setPassword($_POST['password']);
                $user->setCreated(new \DateTime(date_default_timezone_get()));

                $this->storage = new MySqlDatabaseUserStorage($this->db);

                $this->storage->save($user);

            }
        }
    }
}