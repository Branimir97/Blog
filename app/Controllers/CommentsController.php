<?php

namespace Controllers;

use Exceptions\TemplateNotFoundException;
use Models\View;
use Storage\MySqlDatabaseCommentStorage;

class CommentsController extends View
{
    protected $db;

    protected $comments;

    protected $commentStorage;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
        $this->commentStorage = new MySqlDatabaseCommentStorage($this->db);

    }

    public function getCommentsAction()
    {
        $this->comments = $this->commentStorage->get($_GET['id']);

        try {
            echo parent::render('CommentsView', ['comments'=>$this->comments]);
        } catch (TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }
    }


    public function deleteAction()
    {
        $comment_id = $_GET['id'];
        $post_id = $this->commentStorage->getPostId($_GET['id']);
        $this->commentStorage->delete($comment_id, $post_id);
        header("Location: /comments/getComments?id=".$post_id);
    }
}