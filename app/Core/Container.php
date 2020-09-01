<?php

namespace Core;

class Container implements \ArrayAccess
{
    protected $offsets = [];
    protected $cache = [];

    public function __construct(array $offsets)
    {
        foreach ($offsets as $key => $offset)
        {
            $this->offsets[$key] = $offset;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->offsets[$offset]);
    }

    public function offsetGet($offset)
    {
        if(!$this->has($offset))
        {
            return;
        }

        if(isset($this->cache[$offset]))
        {
            return $this->cache[$offset];
        }

        $item = $this->offsets[$offset]($this);
        $this->cache[$offset] = $item;
        return $item;
    }

    public function offsetSet($offset, $value)
    {
        $this->offsets[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        if($this->has($offset)) {
            unset($this->offsets[$offset]);
        }
    }

    public function has($offset)
    {
        return $this->offsetExists($offset);
    }

    public function __get($property)
    {
        return $this->offsetGet($property);
    }
}