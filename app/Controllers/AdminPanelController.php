<?php

namespace Controllers;

use Exceptions\TemplateNotFoundException;
use Models\View;
use Storage\MySqlDatabasePostStorage;

class AdminPanelController extends View
{
    protected $db;

    protected $posts;

    public function __construct(\PDO $db)
    {
        $this->db = $db;

        $this->posts = $this->getAllAction();

        try {
            echo parent::render('AdminPanelView', ['posts'=>$this->posts]);
        } catch (TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }
    }

    public function logoutAction()
    {
        session_destroy();
        header("Location: /");
    }

    public function createPostAction()
    {
        header("Location: /addNewPost");
    }

    public function getAllAction()
    {
        $postStorage = new MySqlDatabasePostStorage($this->db);
        return $postStorage->all();
    }

}