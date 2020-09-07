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
            INSERT INTO posts(title, intro, img_path, content, postedBy, created, visibility)
            VALUES (:title, :intro, :img_path, :content, :postedBy, :created, :visibility)
        ");

        $statement->bindValue(':title', $post->getTitle());
        $statement->bindValue(':intro', htmlspecialchars($post->getIntro()));
        $statement->bindValue(':img_path', $post->getImgPath());
        $statement->bindValue(':content', htmlspecialchars($post->getContent()));
        $statement->bindValue(':postedBy', $post->getPostedBy());
        $statement->bindValue(':created', $post->getCreated()->format("Y-m-d H:i:s"));
        $statement->bindValue(':visibility', $post->getVisibility());
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
            SELECT * FROM posts WHERE id = :id
        ");

        $statement->bindValue(":id", $id);
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

        $imgPath = $this->getImgPath($post->getId());

        if ($imgPath !== $post->getImgPath()) {
            unlink($imgPath);
        }

        $statement = $this->db->prepare("
            UPDATE posts 
            SET title = :title, intro = :intro, img_path = :img_path, content = :content
            WHERE id = :id
        ");

        $statement->bindValue(':title', $post->getTitle());
        $statement->bindValue(':intro', $post->getIntro());
        $statement->bindValue(':img_path', $post->getImgPath());
        $statement->bindValue(':content', $post->getContent());
        $statement->bindValue(':id', $post->getId());

        $statement->execute();

        header("Location: /adminPanel");
    }

    public function changeVisibility($id)
    {

        $visibility = $this->getVisibility($id);

        $visibilityChecker = null;

        if ($visibility == 1) {
            $visibilityChecker = 0;
        } else {
            $visibilityChecker = 1;
        }

        $statementStoreVisibility = $this->db->prepare("
            UPDATE posts
            SET visibility = :visibility 
            WHERE id = :id;
        ");

        $statementStoreVisibility->bindValue(':visibility', $visibilityChecker);

        $statementStoreVisibility->bindValue(':id', $id);

        $statementStoreVisibility->execute();

        header("Location: /adminPanel");

    }

    public function getVisibility($id)
    {
        $statement = $this->db->prepare("
            SELECT visibility
            FROM posts
            WHERE id = :id
        ");

        $statement->bindValue(':id', $id);
        $statement->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        $statement->execute();

        return $statement->fetch()->getVisibility();
    }

    public function getImgPath($id)
    {
        $statement = $this->db->prepare("
            SELECT img_path 
            FROM posts
            WHERE id = '$id'
        ");

        $statement->setFetchMode(\PDO::FETCH_CLASS, Post::class);

        $statement->execute();

        return $statement->fetch()->getImgPath();
    }

    public function delete($id)
    {

        $imgPath = $this->getImgPath($id);

        unlink($imgPath);

        $statement = $this->db->prepare("
            DELETE FROM posts WHERE id = '$id'
        ");

        $statement->execute();

        $this->deleteComments($id);

        header("Location: /adminPanel");

    }

    public function deleteComments($post_id)
    {
        $statement = $this->db->prepare("
            DELETE FROM comments
            WHERE post_id =  :id
        ");

        $statement->bindValue(':id', $post_id);

        $statement->execute();
    }

}