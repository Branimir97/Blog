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
        $id = $_GET['id'];

        $postStorage = new MySqlDatabasePostStorage($this->db);
        return $postStorage->get($id);
    }

    public function updateAction()
    {

        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if(isset($_POST['submit_update']))
            {

                $postStorage = new MySqlDatabasePostStorage($this->db);

                $post = new Post();

                $post->setId($_GET['id']);

                if($_FILES['post_image']['error'] !== UPLOAD_ERR_NO_FILE)
                {
                    $imgPath = $postStorage->constructImgPath($_FILES['post_image']);

                    $post->setImgPath($imgPath);

                    var_dump($imgPath);
                }
                else{
                    $post->setImgPath($this->postDetails->getImgPath());
                }

                $post->setTitle($_POST['title']);
                $post->setIntro($_POST['intro']);
                $post->setContent($_POST['content']);

                $postStorage->update($post);

            }
        }
    }
}