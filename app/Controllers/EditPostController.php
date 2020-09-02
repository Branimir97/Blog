<?php

namespace Controllers;

use Exceptions\TemplateNotFoundException;
use Models\Post;
use Models\View;
use Storage\MySqlDatabasePostStorage;

class EditPostController extends View
{
    protected $db;

    protected $error;

    protected $postDetails;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
        $this->postDetails = $this->editAction();

        if(isset($_SESSION['image_errors']))
        {
            $this->error = $_SESSION['image_errors'];
            session_destroy();
        }

        try {
            echo parent::render('EditPostView', ['error'=>$this->error, 'postDetails'=>$this->postDetails]);
        } catch (TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }
    }

    public function editAction()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if(isset($_POST['submit_edit']))
            {
                $id = $_POST['id'];

                $postStorage = new MySqlDatabasePostStorage($this->db);
                return $postStorage->get($id);
            }
        }

    }

    public function updateAction()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if(isset($_POST['submit_update']))
            {
                $post = new Post();

                $post->setId($_POST['update_id']);
                $post->setTitle($_POST['title']);
                $post->setContent($_POST['content']);

                $postStorage = new MySqlDatabasePostStorage($this->db);

                $postStorage->update($post);
            }
        }
    }

}