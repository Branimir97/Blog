<?php

namespace Core;

use Controllers\Controller404;

class Router
{
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function route()
    {

        $url = $_SERVER['REQUEST_URI'];

        $urlParts = explode('/', $url);

        if (count($urlParts) > 4) {
            return new Controller404();
        }

        if (isset($urlParts[1])) {
            if ($urlParts[1] == '') {
                $controller = 'Home';
            } else {
                $controller = $urlParts[1];
            }
        }
        if (isset($urlParts[2])) {

            if (strpos($urlParts[2], '?')) {
                $explodedGetQuery = explode('?', $urlParts[2]);
                $getQuery = '?' . $explodedGetQuery[1];
                $viewAction = rtrim($urlParts[2], $getQuery) . 'Action';
            } else {
                $viewAction = $urlParts[2] . 'Action';
            }
        } else
        {
            $viewAction = 'indexAction';
        }

        $controllerFile = 'Controllers/' . ucfirst($controller) . 'Controller' . '.php';

        if (!file_exists($controllerFile)) {
            return new Controller404();

        } else {

            $controllerClass = 'Controllers\\' . ucfirst($controller) . 'Controller';

            $controllerClass = new $controllerClass($this->db);

            if (isset($viewAction)) {

                $controllerMethods = get_class_methods($controllerClass);

                if (!in_array($viewAction, $controllerMethods)) {
                    return new Controller404();
                } else {
                    $controllerClass->$viewAction();
                }
            } else {
                return $controllerClass;
            }
        }
    }
}