<?php

class Application_Model_Reader
{
    protected $_id;
    protected $_firstname;
    protected $_lastname;
    protected $_address;
    protected $_city;
    protected $_postcode;
    protected $_createDate;
    
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
    
    public function setAddress($address) {
        $this->_address = $address;
        return $this;
    }
    public function getAddress() {
        return $this->_address;
    }
    
    public function setCity($city) {
        $this->_city = $city;
        return $this;
    }
    public function getCity() {
        return $this->_city;
    }
    
    public function setPostcode($postcode) {
        $this->_postcode = $postcode;
        return $this;
    }
    public function getPostcode() {
        return $this->_postcode;
    }

    public function setCreateDate($createDate) {
        $this->_createDate = $createDate;
        return $this;
    }
    public function getCreateDate() {
        return $this->_createDate;
    }
    
    public function setMapper($mapper) {
        $this->_mapper = $mapper;
        return $this;
    }

    /**
     * @return Application_Model_ReaderMapper
     */
    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Application_Model_ReaderMapper());
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
            'firstname' => $this->getFirstname(),
            'lastname' => $this->getLastname(),
            'address' => $this->getAddress(),
            'city' => $this->getCity(),
            'postcode' => $this->getPostcode(),
            'create_date' => $this->getCreateDate(),
        );
    }

}