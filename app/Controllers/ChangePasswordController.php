<?php

namespace Controllers;

use Exceptions\TemplateNotFoundException;
use Models\View;
use Storage\MySqlDatabaseUserStorage;

class ChangePasswordController extends View
{

    protected $db;

    protected $error;


    public function __construct(\PDO $db)
    {
        $this->db = $db;

        if(isset($_SESSION['error_password']))
        {
            $this->error =  $_SESSION['error_password'];
            unset($_SESSION['error_password']);
        }

        try {
            echo parent::render('ChangePasswordView', ['error_password'=> $this->error]);
        } catch (TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }
    }

    public function changeAction()
    {

        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if(isset($_POST['submit_password']))
            {
                $oldPassword = $_POST['old_password'];

                $newPassword = $_POST['new_password'];

                $newPassword2 = $_POST['new_password2'];


                $userStorage = new MySqlDatabaseUserStorage($this->db);

                $userStorage->changePassword($oldPassword, $newPassword, $newPassword2);
            }
        }
    }

}