<?php

namespace Core;

class App
{
    protected $container;

    public function __construct()
    {
        $this->container = new Container(
            ['router' => function () {
                return new Router($this->container->db);
            }
            ]);
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function run()
    {
        return $this->container->router->route();
    }
}