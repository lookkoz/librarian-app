<?php

class Application_Model_UserMapper
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
     * @return Application_Model_DbTable_User
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_User');
        }
        return $this->_dbTable;
    }
   
    public function save(Application_Model_User $user) 
    {
        $data = $user->__toArray();
        
        if (null === ($id = $user->getId())) {
            unset($data['id']);
            return $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
    
    public function find($id, Application_Model_User $user)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $this->setUserData($result->current(), $user);
        return $user;
    }

    private function setUserData($row, Application_Model_User &$user) {
        $user->setId($row->id)
            ->setEmail($row->email)
            ->setPassword($row->password)
            ->setFirstname($row->firstname)
            ->setLastname($row->lastname)
            ->setAddress($row->address)
            ->setCity($row->city)
            ->setPostcode($row->postcode)
            ->setRole($row->role)
            ->setCreateDate($row->create_date)
            ->setStatus($row->status)
            ->setLastActivity($row->last_activity);
    }
}