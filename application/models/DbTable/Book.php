<?php

class Application_Model_DbTable_Book extends Zend_Db_Table_Abstract
{

    protected $_name = 'book';
    
    public function selectAll() {
        $select = $this->select()->setIntegrityCheck(false)->from($this->_name)
            ->joinLeft('lent', 'lent.book_isbn=book.isbn', array('is_lent' => 'book_isbn'));
        return $select;
    }
    
}

