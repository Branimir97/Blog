<?php

namespace Controllers;

use Exceptions\TemplateNotFoundException;
use Models\View;
use Storage\MySqlDatabasePostStorage;

class PostDetailsController extends View
{

    protected $db;

    protected $postDetails;

    public function __construct(\PDO $db)
    {

        $this->db = $db;

        $this->postDetails = $this->getAction();

        try {
            echo parent::render('PostDetailsView', ['postDetails'=>$this->postDetails]);
        } catch(TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getAction()
    {

        $id = $_GET['id'];
        $postStorage = new MySqlDatabasePostStorage($this->db);
        return $postStorage->get($id);
    }
}