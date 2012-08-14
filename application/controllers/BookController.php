<?php

class BookController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $book = new Application_Model_Book();
        $this->view->$book = $book->fetchAll();
    }


}

