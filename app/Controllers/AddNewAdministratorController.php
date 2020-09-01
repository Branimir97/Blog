<?php

namespace Controllers;

use Exceptions\TemplateNotFoundException;
use Models\View;

class AddNewAdministratorController extends View
{
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;

        try {
            echo parent::render('NewAdministratorView');

        } catch(TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }

    }
}