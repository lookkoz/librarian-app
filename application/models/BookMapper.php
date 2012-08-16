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
    
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Book();
            $this->setBookData($row, $entry);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function getPaginator() {
        $select = $this->getDbTable()->selectAll();
        $adapter = new Zend_Paginator_Adapter_DbSelect($select);
        return new Zend_Paginator($adapter);
    }
    
    public function borrowBook() {
        
    }

    private function setBookData($row, Application_Model_Book &$book) {
        $book->setIsbn($row->isbn)
            ->setTitle($row->title)
            ->setAuthor($row->author)
            ->setYear($row->year);
    }
}