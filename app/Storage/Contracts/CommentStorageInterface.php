<?php

namespace Storage\Contracts;

use Models\Comment;

interface CommentStorageInterface
{
    public function store(Comment $comment);

    public function get($id);

    public function delete($id);

}