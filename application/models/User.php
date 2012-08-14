<?php

class Application_Model_User
{
    protected $_id;
    protected $_email;
    protected $_firstname;
    protected $_lastname;
    protected $_status;
    protected $_createDate;
    protected $_lastActivity;
    
    protected $_mapper;
    
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $filter = new Zend_Filter_Word_UnderscoreToCamelCase();
        $method = 'set' . $filter->filter($name);
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid user property');
        }
        $this->$method($value);
    }
    
    public function __get($name)
    {
        $filter = new Zend_Filter_Word_UnderscoreToCamelCase();
        $method = 'get' . $filter->filter($name);
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid user property');
        }
        return $this->$method();
    }
    
    public function setOptions(array $options)
    {
        $filter = new Zend_Filter_Word_UnderscoreToCamelCase();
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . $filter->filter($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    
    public function setId($id) {
        $this->_id = (int)$id;
        return $this;
    }
    public function getId() {
        return $this->_id;
    }

    public function setEmail($email) {
        $this->_email = $email;
        return $this;
    }
    public function getEmail() {
        return $this->_email;
    }

    public function setPassword($password) {
        $this->_password = $password;
        return $this;
    }
    public function getPassword() {
        return $this->_password;
    }

    public function setUsername($username) {
        $this->_username = $username;
        return $this;
    }
    public function getUsername() {
        return $this->_username;
    }
    
    public function setFirstname($firstname) {
        $this->_firstname = $firstname;
        return $this;
    }
    public function getFirstname() {
        return $this->_firstname;
    }

    public function setLastname($lastname) {
        $this->_lastname = $lastname;
        return $this;
    }
    public function getLastname() {
        return $this->_lastname;
    }
    
    public function setStatus($status) {
        $this->_status = $status;
        return $this;
    }
    public function getStatus() {
        return $this->_status;
    }
    
    public function setCreateDate($createDate) {
        $this->_createDate = $createDate;
        return $this;
    }
    public function getCreateDate() {
        return $this->_createDate;
    }
    
    public function setLastActivity($lastActivity) {
        $this->_lastActivity = $lastActivity;
        return $this;
    }    
    public function getLastActivity() {
        return $this->_lastActivity;
    }
    
    public function setMapper($mapper) {
        $this->_mapper = $mapper;
        return $this;
    }

    /**
     * @return Application_Model_UserMapper
     */
    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Application_Model_UserMapper());
        }
        return $this->_mapper;
    }

    public function save() {
        if($this->getId() == 0)
            $this->setId($this->getMapper()->save($this));
        else 
            $this->getMapper()->save($this);
        return $this->getId();
    }

    public function fetchAll() {
        return $this->getMapper()->fetchAll();
    }

    public function find($id) {
        $this->getMapper()->find($id, $this);
        return $this;
    }
    
    public function __toArray()
    {
        return array(
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'username' => $this->getUsername(),
            'firstname' => $this->getFirstname(),
            'lastname' => $this->getLastname(),
            'status' => $this->getStatus(),
            'create_date' => $this->getCreateDate(),
            'last_activity' => $this->getLastActivity(),
        );
    }

}