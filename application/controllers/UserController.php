<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $user = new Application_Model_User();
        $this->view->users = $user->fetchAll();
    }
    
    
    
}

