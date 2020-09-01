<?php

namespace Controllers;

use Exceptions\TemplateNotFoundException;
use Models\View;
use Storage\MySqlDatabasePostStorage;

class HomeController extends View
{

    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
        $this->index();
    }

    public function index()
    {

        $posts = $this->getAllPosts();
        try
        {
            echo parent::render('HomeView', ['posts' => $posts]);

        } catch (TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getAllPosts()
    {
        $storage = new MySqlDatabasePostStorage($this->db);

        return $storage->all();
    }

    public function logoutAction()
    {
        session_destroy();
        header("Location: /");
    }
}