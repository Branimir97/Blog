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

    protected $postStorage;

    protected $imgPath;

    public function __construct(\PDO $db)
    {
        $this->db = $db;

        $this->postStorage = new MySqlDatabasePostStorage($this->db);

        if(isset($_SESSION['image_errors']))
        {
            $this->error = $_SESSION['image_errors'];
            unset($_SESSION['image_errors']);
        }
    }

    public function editAction()
    {

        $id = $_GET['id'];
        $postStorage = new MySqlDatabasePostStorage($this->db);

        $this->postDetails = $postStorage->get($id);
        $this->imgPath = $this->postDetails->getImgPath();
        try {
            echo parent::render('EditPostView', ['error'=>$this->error, 'postDetails'=>$this->postDetails]);
        } catch (TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }

    }

    public function updateAction()
    {

        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if(isset($_POST['submit_update']))
            {

                $post = new Post();

                $post->setId($_GET['id']);

                if($_FILES['post_image']['error'] !== UPLOAD_ERR_NO_FILE)
                {
                    $imgPath = $this->postStorage->constructImgPath($_FILES['post_image']);

                    $post->setImgPath($imgPath);

                }
                else{
                    $post->setImgPath($this->postStorage->getImgPath($post->getId()));
                }

                $post->setTitle($_POST['title']);
                $post->setIntro($_POST['intro']);
                $post->setContent($_POST['content']);

                $this->postStorage->update($post);

            }
        }
    }

    public function deleteAction()
    {
        $id = $_GET['id'];
        $this->postStorage->delete($id);
    }

}