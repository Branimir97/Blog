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

    public function __construct(\PDO $db)
    {
        $this->db = $db;

        $this->postStorage = new MySqlDatabasePostStorage($this->db);

        $this->posts = $this->getAllAction();

        try {
            echo parent::render('AdminPanelView', ['posts'=>$this->posts]);
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
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if(isset($_POST['submit_visibility']))
            {
                $id = $_POST['id'];
                $visibility = $_POST['visibility'];
                $this->postStorage->changeVisibility($id, $visibility);
                header("Location: /adminPanel");
            }
        }
    }

    public function deleteAction()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if(isset($_POST['submit_delete']))
            {
                $id = $_POST['id'];

                $this->postStorage->delete($id);
            }
        }
    }

}