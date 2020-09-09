<?php

namespace Controllers;

use Exceptions\TemplateNotFoundException;
use Models\View;
use Storage\MySqlDatabaseUserStorage;

class ForgotPasswordController extends View
{
    protected $db;

    protected $userStorage;

    protected $recover_error;

    protected $recover_success;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
        $this->userStorage = new MySqlDatabaseUserStorage($this->db);

        if(isset($_SESSION['recover_error']))
        {
            $this->recover_error = $_SESSION['recover_error'];
            unset($_SESSION['recover_error']);
        }

    }

    public function indexAction()
    {
        try {
            echo parent::render('ForgotPasswordView', ['recover_error'=>$this->recover_error, 'recover_success'=>$this->recover_success]);
        } catch(TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }
    }

    public function recoverAction()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if(isset($_POST['submit_recover']))
            {
                $username_email = $_POST['username_email'];

                if(filter_var($username_email, FILTER_VALIDATE_EMAIL))
                {
                    $email = $this->userStorage->checkEmail($username_email);
                } else
                {
                    $username = $this->userStorage->checkUsername($username_email);
                }
            }
        }
    }
}