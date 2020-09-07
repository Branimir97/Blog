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

        $this->comments = $this->checkCommentsAction();

        try {
            echo parent::render('CommentsView', ['comments'=>$this->comments]);
        } catch (TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }
    }

    public function checkCommentsAction()
    {
        $post_id = $_GET['id'];

        return $this->commentStorage->get($post_id);
    }

    public function deleteAction()
    {
        $comment_id = $_GET['id'];
        $this->commentStorage->delete($comment_id);
    }
}