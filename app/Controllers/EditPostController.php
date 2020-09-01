<?php

namespace Controllers;

use Exceptions\TemplateNotFoundException;
use Models\View;
use Storage\MySqlDatabasePostStorage;

class EditPostController extends View
{
    protected $db;

    protected $error;

    protected $postDetails;

    public function __construct(\PDO $db)
    {
        $this->db = $db;

        $this->postDetails = $_GET['id'];

        if(isset($_SESSION['image_errors']))
        {
            $this->error = $_SESSION['image_errors'];
            session_destroy();
        }

        try {
            echo parent::render('EditPostView', ['error'=>$this->error, 'postDetails'=>$this->postDetails]);
        } catch (TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }
    }

    public function editAction()
    {

    }

}