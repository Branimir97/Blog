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

        //$_SESSION['postCreated'] = 'Successfully created post.';
        header("Location: /addNewPost");

    }

    public function all()
    {
        $statement = $this->db->prepare("
            SELECT * FROM posts 
            ORDER BY created DESC
        ");

        $statement->setFetchMode(\PDO::FETCH_CLASS, Post::class);

        $statement->execute();

        return $statement->fetchAll();
    }

    public function allVisible()
    {
        $statement = $this->db->prepare("
            SELECT * FROM posts 
            WHERE visibility != 0
            ORDER BY created DESC
        ");

        $statement->setFetchMode(\PDO::FETCH_CLASS, Post::class);

        $statement->execute();

        return $statement->fetchAll();
    }

    public function get($id)
    {
        $statement = $this->db->prepare("
            SELECT * FROM posts WHERE id = '$id'
        ");

        //$statement->bindValue(":id", $id);
        $statement->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        $statement->execute();

        return $statement->fetch();
    }

    public function constructImgPath($image)
    {
        $explodedImageName = explode('.', $image['name']);

        $image_extension = strtolower(end($explodedImageName));

        $allowed_extensions = array('png', 'jpg', 'jpeg');

        if (!in_array($image_extension, $allowed_extensions)) {
            $_SESSION['image_errors'] = 'Wrong file format. Allowed extensions: .jpg, .png, .jpeg';
            header("Location: /addNewPost");
        } else {
            if ($image['size'] > 2000000) {
                $_SESSION['image_errors'] = 'Image size too big. Max image upload size is 2MB';
                header("Location: /addNewPost");
            } else {
                $upload_destination = "/var/www/html/Blog/app/Uploaded_images/" . $image['name'];
                move_uploaded_file($image['tmp_name'], $upload_destination);

                $upload_destination_src = "Uploaded_images/" . $image['name'];

                return $upload_destination_src;
            }
        }
    }

    public function update(Post $post)
    {
        $statement = $this->db->prepare("
            UPDATE posts 
            SET title = ':title', content = ':content'
            WHERE id = ':id'
        ");

        $statement->bindValue(':title', $post->getTitle());
        $statement->bindValue(':content', $post->getContent());
        $statement->bindValue(':id', '5');

        $statement->execute();

        header("Location: /adminPanel");
    }

    public function changeVisibility($id, $visibility)
    {
        $visibilityChecker = null;

        if($visibility == true)
        {
            $visibilityChecker = 0;
        } else
        {
            $visibilityChecker = 1;
        }

        $statement = $this->db->prepare("
            UPDATE `posts` SET `visibility` = '$visibilityChecker' WHERE `posts`.`id` = '$id';
        ");

        $statement->execute();

    }

    public function delete($id)
    {
        $statement = $this->db->prepare("
            DELETE FROM posts WHERE id = '$id'
        ");

        $statement->execute();

    }

}