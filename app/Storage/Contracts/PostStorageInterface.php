<?php

namespace Storage\Contracts;

use Models\Post;

interface PostStorageInterface
{
    public function store(Post $post);

    public function all();

    public function get($id);

    public function update(Post $post);

    public function changeVisibility($id, $visibility);

    public function delete($id);
}