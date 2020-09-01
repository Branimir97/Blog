<?php

namespace Storage;

use Storage\Contracts\UserStorageInterface;

use Models\User;

class MySqlDatabaseUserStorage implements UserStorageInterface
{
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function save(User $user)
    {

        $used_username = false;
        $used_email = false;

        $current_username = null;

        $statement1 = $this->db->prepare("
            SELECT username, email FROM users
        ");

        $statement1->setFetchMode(\PDO::FETCH_OBJ);

        $statement1->execute();

        $registeredUsers = $statement1->fetchAll();

        foreach($registeredUsers as $registered_user)
        {
            if(($registered_user->username) == $user->getUsername())
            {
                $used_username = true;
                $current_username = $user->getUsername();
            } else if ($registered_user->email == $user->getEmail())
            {
                $used_email = true;
            }
        }

        if($used_username)
        {
            $_SESSION['error'] = 'Username '. $current_username .' already exists.';
            header("Location: /signup");

        } else if($used_email)
        {
            $_SESSION['error'] = 'Email is already in use. Try another email address.';
            header("Location: /signup");

        } else
        {
            $statement = $this->db->prepare("
            INSERT INTO users(username, first_name, last_name, email, password, created) 
            VALUES (:username, :first_name, :last_name, :email, :password, :created)
        ");

            $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);

            $statement->bindValue(':username', $user->getUsername());
            $statement->bindValue(':first_name', $user->getFirstName());
            $statement->bindValue(':last_name', $user->getLastName());
            $statement->bindValue(':email', $user->getEmail());
            $statement->bindValue(':password', $hashedPassword);
            $statement->bindValue(':created', $user->getCreated()->format("Y-m-d H:i:s"));
            $statement->execute();

            $_SESSION['registered'] = true;
            header("Location: /login");
        }
    }

    public function authenticate(User $user)
    {
        $correct_username = false;
        $correct_password = false;
        $is_admin = false;

        $statement = $this->db->prepare("
            SELECT username, password, role FROM users
        ");

        $statement->setFetchMode(\PDO::FETCH_OBJ);

        $statement->execute();

        $users = $statement->fetchAll();

        foreach($users as $user_db)
        {
            $correct_password = password_verify($user->getPassword(), $user_db->password);

            if($user_db->username == $user->getUsername() && !$correct_password)
            {
                $correct_username = true;

            } else if($user_db->username == $user->getUsername() && $correct_password)
            {
                $correct_username = true;
                $correct_password = true;

                if($user_db->role === "admin")
                {
                    $is_admin = true;
                }
            }
        }

        if($correct_password && $correct_username)
        {
            if($is_admin)
            {
                $_SESSION['admin_loggedIn'] = true;
                header("Location: /adminPanel");
            } else {
                $_SESSION['loggedIn'] = true;
                header("Location: /");
            }

        } else if ($correct_username == false){
            $_SESSION['error'] = 'User does not exist!';
            header("Location: /login");

        } else if($correct_username && $correct_password == false)
        {
            $_SESSION['error'] = 'Wrong password!';
            header("Location: /login");
        }
    }
}


