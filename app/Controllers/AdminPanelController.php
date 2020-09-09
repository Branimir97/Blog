<?php

namespace Controllers;

use Exceptions\TemplateNotFoundException;
use Models\View;
use Storage\MySqlDatabasePostStorage;

class AdminPanelController extends View
{
    protected $db;

    protected $postStorage;

    protected $posts;

    protected $edited;

    protected $created;

    public function __construct(\PDO $db)
    {
        $this->db = $db;

        $this->postStorage = new MySqlDatabasePostStorage($this->db);

        $this->posts = $this->getAllAction();

        if(isset($_SESSION['edited']))
        {
            $this->edited = $_SESSION['edited'];
            unset($_SESSION['edited']);
        }

        if(isset($_SESSION['created']))
        {
            $this->edited = $_SESSION['created'];
            unset($_SESSION['created']);
        }
    }

    public function indexAction()
    {
        try {
            echo parent::render('AdminPanelView', ['posts'=>$this->posts, 'edited'=>$this->edited, 'created'=>$this->created]);
        } catch (TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getAllAction()
    {
        return $this->postStorage->all();
    }

    public function changeVisibilityAction()
    {
        $id = $_GET['id'];
        $this->postStorage->changeVisibility($id);
    }

}