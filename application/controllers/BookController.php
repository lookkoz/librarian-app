<?php

class BookController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    /*
     * Books list
     */
    public function indexAction()
    {
        $page = (int) $this->getRequest()->getParam('page');
        
        $book = new Application_Model_Book();
        $paginator = $book->getPaginator();
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
        $this->view->books = $paginator;
    }
    
    public function addBookAction()
    {
        
    }
    
    public function editBookAction()
    {
        
    }
    
    public function borrowBookAction()
    {
        $isbn = (int) $this->getRequest()->getParam('isbn');
        $book = new Application_Model_Book();
        $book->find($isbn);
        
        $reader = new Application_Model_Reader();
        $reader->fetchAll();
        
        $this->view->reader = $readers;
        $this->view->book = $book;
    }
}

