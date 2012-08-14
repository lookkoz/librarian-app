<?php

class Application_Model_BookMapper
{
    protected $_dbTable;
    
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
    
    /**
     * @return Application_Model_DbTable_Book
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Book');
        }
        return $this->_dbTable;
    }
   
    public function save(Application_Model_Book $book) 
    {
        $data = $book->__toArray();
        
        if (null === ($id = $book->getId())) {
            unset($data['id']);
            return $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
    
    public function find($id, Application_Model_Book $book)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $this->setBookData($result->current(), $book);
        return $book;
    }

    private function setBookData($row, Application_Model_Book &$book) {
        $book->setIsbn($row->isbn)
            ->setTitle($row->title)
            ->setAuthor($row->author)
            ->setYear($row->year);
    }
}