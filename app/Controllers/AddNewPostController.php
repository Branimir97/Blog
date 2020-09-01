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

        if(isset($_SESSION['image_errors']))
        {
            $this->error = $_SESSION['image_errors'];
            session_destroy();
        }


        try {
            echo parent::render('NewPostView', ['error'=>$this->error]);
        } catch (TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }
    }

    public function storeAction()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if(isset($_POST['submit']))
            {

                $image = $_FILES['post_image'];

                $explodedImageName = explode('.', $image['name']);

                $image_extension = strtolower(end($explodedImageName));

                $allowed_extensions = array('png', 'jpg', 'jpeg');

                if(!in_array($image_extension, $allowed_extensions))
                {
                    $_SESSION['image_errors'] = 'Wrong file format. Allowed extensions: .jpg, .png, .jpeg';
                    header("Location: /addNewPost");
                } else {
                    if($image['size']>2000000)
                    {
                        $_SESSION['image_errors'] = 'Image size too big. Max image upload size is 2MB';
                        header("Location: /addNewPost");
                    }
                    else
                    {
                        $upload_destination = "/var/www/html/Blog/app//Uploaded_images/".$image['name'];
                        move_uploaded_file($image['tmp_name'], $upload_destination);

                        $upload_destination_src = "Uploaded_images/".$image['name'];

                        $post = new Post();

                        $post->setTitle($_POST['title']);
                        $post->setImgPath($upload_destination_src);
                        $post->setContent($_POST['content']);
                        $post->setPostedBy('ADMIN');
                        $post->setCreated(new \DateTime(date_default_timezone_get()));

                        $postStorage = new MySqlDatabasePostStorage($this->db);

                        $postStorage->store($post);

                        header("Location: /addNewPost");
                    }
                }
            }
        }
    }
}