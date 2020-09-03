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

        foreach ($registeredUsers as $registered_user) {
            if (($registered_user->username) == $user->getUsername()) {
                $used_username = true;
                $current_username = $user->getUsername();
            } else if ($registered_user->email == $user->getEmail()) {
                $used_email = true;
            }
        }

        if ($used_username) {
            $_SESSION['error'] = 'Username ' . $current_username . ' already exists.';
            header("Location: /signup");

        } else if ($used_email) {
            $_SESSION['error'] = 'Email is already in use. Try another email address.';
            header("Location: /signup");

        } else {
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
        $pass = false;
        $is_admin = false;
        $current_username = null;
        $current_firstName = null;
        $current_lastName = null;

        $statement = $this->db->prepare("
            SELECT username, first_name, last_name, password, role FROM users
        ");

        $statement->setFetchMode(\PDO::FETCH_OBJ);

        $statement->execute();

        $users = $statement->fetchAll();

        foreach ($users as $user_db) {
            $correct_password = password_verify($user->getPassword(), $user_db->password);

            if ($user_db->username == $user->getUsername() && !$correct_password) {
                $correct_username = true;

            } else if ($user_db->username == $user->getUsername() && $correct_password) {
                $correct_username = true;
                $pass = true;

                $current_username = $user_db->username;
                $current_firstName = $user_db->first_name;
                $current_lastName = $user_db->last_name;
                if ($user_db->role === "admin") {
                    $is_admin = true;
                }
            }
            if ($pass && $correct_username) {
                $_SESSION['loggedIn'] = true;

                if ($is_admin) {
                    $_SESSION['admin_loggedIn'] = true;
                    $_SESSION['loggedIn_username'] = $current_username;
                    $_SESSION['loggedIn_fullName'] = $current_firstName . ' ' . $current_lastName;
                    header("Location: /adminPanel");
                } else {
                    $_SESSION['loggedIn_username'] = $current_username;
                    $_SESSION['loggedIn_fullName'] = $current_firstName . ' ' . $current_lastName;
                    header("Location: /");
                }
            } else if ($correct_username == false) {
                $_SESSION['error'] = 'User does not exist!';
                header("Location: /login");

            } else if ($correct_username && $pass == false) {
                $_SESSION['error'] = 'Wrong password!';
                header("Location: /login");
            }
        }
    }

    public function all($role)
    {
        $statement = $this->db->prepare("
            SELECT * FROM users WHERE role = '$role'
        ");

        $statement->setFetchMode(\PDO::FETCH_CLASS, User::class);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function changeRole($id, $role)
    {
        $roleSetter = null;

        if($role === 'admin')
        {
            $roleSetter = 'user';
        }
         else
        {
            $roleSetter = 'admin';
        }

        $statement = $this->db->prepare("
            UPDATE `users` SET `role` = '$roleSetter' WHERE `users`.`id` = '$id';
        ");

        $statement->execute();
    }

}


