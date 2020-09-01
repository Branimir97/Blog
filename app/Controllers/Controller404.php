<?php

namespace Controllers;

use Exceptions\TemplateNotFoundException;
use Models\View;

class Controller404 extends View
{
    public function __construct()
    {
        try
        {
            echo parent::render('View404');

        } catch (TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }
    }
}