<?php

namespace Controllers;

use Exceptions\TemplateNotFoundException;
use Models\Post;
use Models\View;
use Storage\MySqlDatabasePostStorage;

class AddNewPostController extends View
{
    protected $db;

    protected $error;

    public function __construct(\PDO $db)
    {
        $this->db = $db;

        if (isset($_SESSION['image_errors'])) {
            $this->error = $_SESSION['image_errors'];
            session_destroy();
        }


        try {
            echo parent::render('NewPostView', ['error' => $this->error]);
        } catch (TemplateNotFoundException $e) {
            echo $e->getMessage();
        }
    }

    public function storeAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (isset($_POST['submit'])) {

                $image = $_FILES['post_image'];

                $postStorage = new MySqlDatabasePostStorage($this->db);

                $imgPath = $postStorage->constructImgPath($image);

                $post = new Post();

                $post->setTitle($_POST['title']);
                $post->setImgPath($imgPath);
                $post->setContent($_POST['content']);
                $post->setPostedBy($_SESSION['loggedIn_username']);
                $post->setCreated(new \DateTime(date_default_timezone_get()));

                $postStorage->store($post);

                header("Location: /addNewPost");
            }
        }
    }
}