<?php

namespace Controllers;

use Exceptions\TemplateNotFoundException;
use Models\Comment;
use Models\View;
use Storage\MySqlDatabaseCommentStorage;
use Storage\MySqlDatabasePostStorage;

class PostDetailsController extends View
{

    protected $db;

    protected $postDetails;

    protected $commentsDetails;

    public function __construct(\PDO $db)
    {

        $this->db = $db;

        $this->postDetails = $this->getPostAction();

        $this->commentsDetails = $this->getComments();

    }

    public function indexAction()
    {
        try {
            echo parent::render('PostDetailsView', ['postDetails'=>$this->postDetails, 'commentsDetails'=>$this->commentsDetails]);
        } catch(TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getPostAction()
    {
        $post_id = $_GET['id'];
        $postStorage = new MySqlDatabasePostStorage($this->db);
        return $postStorage->get($post_id);
    }

    public function postCommentAction()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if(isset($_POST['submit_comment']))
            {
                date_default_timezone_set('Europe/Zagreb');

                $comment = new Comment();

                $comment->setContent($_POST['content']);
                $comment->setPostId($_GET['id']);
                $comment->setPostedBy($_SESSION['loggedIn_fullName']);
                $comment->setCreated(new \DateTime(date_default_timezone_get()));

                $commentStorage = new MySqlDatabaseCommentStorage($this->db);

                $commentStorage->store($comment);
            }
        }
    }

    public function getComments()
    {
        $commentStorage = new MySqlDatabaseCommentStorage($this->db);

        return $commentStorage->get($_GET['id']);
    }

}