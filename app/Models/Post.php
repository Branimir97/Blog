<?php

namespace Models;

class Post
{

    protected $id;
    protected $title;
    protected $img_path;
    protected $content;
    protected $postedBy;
    protected $created;
    protected $visibility;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getImgPath()
    {
        return $this->img_path;
    }

    /**
     * @param mixed $img_path
     */
    public function setImgPath($img_path)
    {
        $this->img_path = $img_path;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getPostedBy()
    {
        return $this->postedBy;
    }

    /**
     * @param mixed $postedBy
     */
    public function setPostedBy($postedBy)
    {
        $this->postedBy = $postedBy;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param mixed $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }


}