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

    protected $commentStorage;

    protected $commentsDetails;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
        $this->commentStorage = new MySqlDatabaseCommentStorage($this->db);
    }

    public function getPostAction()
    {
        $post_id = $_GET['id'];
        $postStorage = new MySqlDatabasePostStorage($this->db);
        $this->postDetails = $postStorage->get($post_id);
        $this->commentsDetails = $this->getComments();

        try {
            echo parent::render('PostDetailsView', ['postDetails'=>$this->postDetails, 'commentsDetails'=>$this->commentsDetails]);
        } catch(TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }

    }

    public function postCommentAction()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if(isset($_POST['submit_comment'])) {
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
        return $this->commentStorage->get($_GET['id']);
    }

    public function logoutAction()
    {
        if(isset($_COOKIE['username']) && isset($_COOKIE['password']))
        {
            unset($_COOKIE['username']);
            unset($_COOKIE['password']);
        }

        session_unset();
        session_destroy();
        header("Location: /");
    }

    public function deleteAction()
    {
        $comment_id = $_GET['id'];
        $post_id = $this->commentStorage->getPostId($comment_id);
        $this->commentStorage->delete($comment_id, $post_id);
        header("Location: /postDetails/getPost?id=".$post_id.'#comments');
    }

}