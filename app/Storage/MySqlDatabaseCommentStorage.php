<?php

namespace Storage;

use Models\Comment;
use Storage\Contracts\CommentStorageInterface;

class MySqlDatabaseCommentStorage implements CommentStorageInterface
{
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function store(Comment $comment)
    {
        $statement = $this->db->prepare("
            INSERT INTO comments (content, post_id, postedBy, created)
            VALUES (:content, :post_id, :postedBy, :created)
        ");

        $statement->bindValue(':content', $comment->getContent());
        $statement->bindValue(':post_id', $comment->getPostId());
        $statement->bindValue(':postedBy', $comment->getPostedBy());
        $statement->bindValue(':created', $comment->getCreated()->format("Y-m-d H:i:s"));

        $statement->execute();

        header("Location: /postDetails/getPost?id=".$comment->getPostId());
    }

    public function get($id)
    {
        $statement = $this->db->prepare("
            SELECT * FROM comments
            WHERE post_id = :post_id
            ORDER BY id DESC
        ");

        $statement->bindValue(':post_id', $id);

        $statement->setFetchMode(\PDO::FETCH_CLASS, Comment::class);

        $statement->execute();

        return $statement->fetchAll();
    }

    public function delete($comment_id, $post_id)
    {
        $statement = $this->db->prepare("
            DELETE FROM comments
            WHERE id = :id
        ");

        $statement->bindValue(':id', $comment_id);

        $statement->execute();

    }

    public function getPostId($comment_id)
    {
        $statement = $this->db->prepare("
            SELECT post_id FROM comments
            WHERE id = :id 
        ");

        $statement->bindValue(':id', $comment_id);

        $statement->setFetchMode(\PDO::FETCH_CLASS, Comment::class);

        $statement->execute();

        return $statement->fetch()->getPostId();
    }
}
