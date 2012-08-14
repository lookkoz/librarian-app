<?php

class Application_Model_Book
{
    protected $_isbn;
    protected $_title;
    protected $_author;
    protected $_year;
    
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
            throw new Exception('Invalid book property');
        }
        $this->$method($value);
    }
    
    public function __get($name)
    {
        $filter = new Zend_Filter_Word_UnderscoreToCamelCase();
        $method = 'get' . $filter->filter($name);
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid book property');
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
    
    public function setIsbn($isbn) {
        $this->_isbn = (int)$isbn;
        return $this;
    }
    public function getIsbn() {
        return $this->_isbn;
    }

    public function setTitle($title) {
        $this->_title = $title;
        return $this;
    }
    public function getTitle() {
        return $this->_title;
    }

    public function setAuthor($author) {
        $this->_author = $author;
        return $this;
    }
    public function getAuthor() {
        return $this->_author;
    }

    public function setYear($year) {
        $this->_year = $year;
        return $this;
    }
    public function getYear() {
        return $this->_year;
    }
    
    public function setMapper($mapper) {
        $this->_mapper = $mapper;
        return $this;
    }

    /**
     * @return Application_Model_BookMapper
     */
    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Application_Model_BookMapper());
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
            'title' => $this->getTitle(),
            'author' => $this->getAuthor(),
            'year' => $this->getYear(),
        );
    }

}