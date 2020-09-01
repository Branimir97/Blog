<?php

namespace Storage;

use Storage\Contracts\PostStorageInterface;

use Models\Post;

class MySqlDatabasePostStorage implements PostStorageInterface
{
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function store(Post $post)
    {
        $statement = $this->db->prepare("
            INSERT INTO posts(title, img_path, content, postedBy, created)
            VALUES (:title, :img_path, :content, :postedBy, :created)
        ");

        $statement->bindValue(':title', $post->getTitle());
        $statement->bindValue(':img_path', $post->getImgPath());
        $statement->bindValue(':content', $post->getContent());
        $statement->bindValue(':postedBy', $post->getPostedBy());
        $statement->bindValue(':created', $post->getCreated()->format(("Y-m-d H:i:s")));

        $statement->execute();
    }

    public function all()
    {
        $statement = $this->db->prepare("
            SELECT * FROM posts ORDER BY created ASC
        ");

        $statement->setFetchMode(\PDO::FETCH_CLASS, Post::class);

        $statement->execute();

        return $statement->fetchAll();
    }

    public function get($id)
    {
        $statement = $this->db->prepare("
            SELECT * FROM posts WHERE id = :id
        ");

        $statement->bindValue(":id", $id);
        $statement->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        $statement->execute();

        return $statement->fetch();
    }
}