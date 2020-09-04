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

    protected $postCreated;

    public function __construct(\PDO $db)
    {
        $this->db = $db;

        if (isset($_SESSION['image_errors'])) {
            $this->error = $_SESSION['image_errors'];
            unset($_SESSION['image_errors']);
        }

        if (isset($_SESSION['postCreated'])) {
            $this->postCreated = $_SESSION['postCreated'];
            unset($_SESSION['postCreated']);
        }


        try {
            echo parent::render('NewPostView', ['error' => $this->error, 'postCreated'=>$this->postCreated]);
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
                $post->setIntro($_POST['intro']);
                $post->setImgPath($imgPath);
                $post->setContent($_POST['content']);

                if(isset($_POST['post_visibility']))
                {
                    $post->setVisibility(0);
                } else{
                    $post->setVisibility(1);
                }

                $post->setPostedBy($_SESSION['loggedIn_fullName']);
                $post->setCreated(new \DateTime(date_default_timezone_get()));

                $postStorage->store($post);
            }
        }
    }
}