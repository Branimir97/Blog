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

        $current_email = filter_var($user->getEmail(), FILTER_SANITIZE_EMAIL);

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
        }

        else if(!filter_var($current_email, FILTER_VALIDATE_EMAIL))
        {
            $_SESSION['error'] = 'Wrong email address format.';
            header("Location: /signup");
        }

        else if(strlen($user->getPassword())<8)
        {
            $_SESSION['error'] = 'Password is too short. Min. 8 characters.';
            header("Location: /signup");

        }

        else {
            $statement = $this->db->prepare("
            INSERT INTO users(username, first_name, last_name, email, password, created) 
            VALUES (:username, :first_name, :last_name, :email, :password, :created)
        ");

            $hashedPassword = password_hash(filter_var($user->getPassword(), FILTER_SANITIZE_STRING), PASSWORD_DEFAULT);

            $statement->bindValue(':username', filter_var($user->getUsername()), FILTER_SANITIZE_STRING);
            $statement->bindValue(':first_name', filter_var($user->getFirstName()), FILTER_SANITIZE_STRING);
            $statement->bindValue(':last_name', filter_var($user->getLastName()), FILTER_SANITIZE_STRING);
            $statement->bindValue(':email', $user->getEmail());
            $statement->bindValue(':password', $hashedPassword);
            $statement->bindValue(':created', $user->getCreated()->format("Y-m-d H:i:s"));
            $statement->execute();

            $_SESSION['registered'] = 'Successfully created account. Now you can login.';
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
        $current_password = null;

        $statement = $this->db->prepare("
            SELECT username, first_name, last_name, password, role FROM users
        ");

        $statement->setFetchMode(\PDO::FETCH_OBJ);

        $statement->execute();

        $users = $statement->fetchAll();

        if(empty($users))
        {
            $_SESSION['error'] = 'You are the first user, sign up first!';
            header("Location: /login");
        }

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
                $current_password = $user->getPassword();
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
                    $_SESSION['password'] = $current_password;
                    header("Location: /adminPanel");
                } else {
                    $_SESSION['loggedIn_username'] = $current_username;
                    $_SESSION['loggedIn_fullName'] = $current_firstName . ' ' . $current_lastName;
                    $_SESSION['password'] = $current_password;
                    header("Location: /");
                }
            } else if ($correct_username == false) {
                $_SESSION['error'] = 'User does not exist!';
                header("Location: /login");

            } else if ($correct_username && $pass == false) {
                $_SESSION['error'] = 'Wrong password!';
                header("Location: /login");
            }

            if(isset($_POST['remember_me']))
            {
                setcookie('username', $current_username, time() + 60 * 60); //1h
                setcookie('password', $current_password, time() + 60 * 60); //1h
            } else if(!isset($_POST['remember_me']) && isset($_COOKIE['username']) && isset($_COOKIE['password']))
            {
                setcookie('username', $current_username, time() - 1);
                setcookie('password', $current_password, time() - 1);
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
            UPDATE users 
            SET role = :role 
            WHERE id = :id
        ");

         $statement->bindValue(':role', $roleSetter);
         $statement->bindValue(':id', $id);

        $statement->execute();
        header("Location: /addNewAdministrator");


    }

    public function get($username)
    {
        $statement = $this->db->prepare("
            SELECT * FROM users
            WHERE username = :username
        ");

        $statement->bindValue(':username', $username);

        $statement->setFetchMode(\PDO::FETCH_CLASS, User::class);

        $statement->execute();

        return $statement->fetch();
    }

    public function delete($username)
    {
        $statement = $this->db->prepare("
            DELETE FROM users
            WHERE username = :username
        ");

        $statement->bindValue(':username', $username);

        $statement->execute();

        session_unset();
        session_destroy();

        header("Location: /home");
    }

    public function checkPasswords($password1, $password2)
    {
        return $password1 === $password2;
    }

    public function checkCurrentPassword($password)
    {
        $statement = $this->db->prepare("
            SELECT password FROM users 
            WHERE username = :username
        ");

        $statement->bindValue(':username', $_SESSION['loggedIn_username']);

        $statement->setFetchMode(\PDO::FETCH_CLASS, User::class);

        $statement->execute();

        $password_db =  $statement->fetch()->getPassword();

        return password_verify($password, $password_db);
    }

    public function changePassword($oldPassword, $newPassword, $newPassword2)
    {
        var_dump($oldPassword);

        var_dump($newPassword);

        var_dump($newPassword2);
        if(!$this->checkCurrentPassword($oldPassword))
        {
            $_SESSION['error_password'] = 'Wrong current password.';
            header('Location: /changePassword');
        } else
        {
            if(strlen($newPassword)<8)
            {
                $_SESSION['error_password'] = 'New password is too short. Min. 8 characters.';
                header('Location: /changePassword');
            } else if (!$this->checkPasswords($newPassword, $newPassword2))
            {
                $_SESSION['error_password'] = 'New passwords doesn\'t match.';
                header('Location: /changePassword');
            } else
            {
                $this->saveNewPassword($newPassword);
                $_SESSION['changed_password'] = 'Successfully changed password.';
                header('Location: /profile');
            }
        }
    }

    public function saveNewPassword($password)
    {
        $statement = $this->db->prepare("
            UPDATE users 
            SET password = :password
            WHERE username = :username
        ");

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $statement->bindValue(':password', $hashedPassword);
        $statement->bindValue('username', $_SESSION['loggedIn_username']);

        $statement->execute();
    }

    public function checkUsername($username)
    {
        $statement = $this->db->prepare("
            SELECT username FROM users
            WHERE username = :username
        ");

        $statement->bindValue(':username', $username);

        $statement->setFetchMode(\PDO::FETCH_CLASS, User::class);

        $statement->execute();

        if($statement->rowCount()==0)
        {
            $_SESSION['recover_error'] = 'User does not exist.';
            header("Location: /forgotPassword");
        } else
        {
            return $statement->fetch()->getUsername();
        }
    }

    public function checkEmail($email)
    {
        $statement = $this->db->prepare("
            SELECT email FROM users
            WHERE email = :email
        ");

        $statement->bindValue(':email', $email);

        $statement->setFetchMode(\PDO::FETCH_CLASS, User::class);

        $statement->execute();

        if($statement->rowCount()==0)
        {
            $_SESSION['recover_error'] = 'User does not exist.';
            header("Location: /forgotPassword");
        } else
        {
            return $statement->fetch()->getEmail();
        }
    }
}


