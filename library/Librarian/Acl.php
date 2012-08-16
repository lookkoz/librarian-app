<?php

class Zweeno_Acl extends Zend_Acl
{
    /**
     * Set up access control lists
     */
    public function __construct()
    {
        /**
         * Set up roles
         */
        $this->addRole(new Zend_Acl_Role('librarian'))
             ->addRole(new Zend_Acl_Role('reader'));

        /**
         * Set up resources
         */
        $this->add(new Zend_Acl_Resource('default_error'));
        $this->add(new Zend_Acl_Resource('default_index'));
        $this->add(new Zend_Acl_Resource('default_user'));
        $this->add(new Zend_Acl_Resource('default_book'));
        $this->add(new Zend_Acl_Resource('default_category'));

        /**
         * Allow for all (we use black list)
         */
        $this->allow();

        /**
         * Set up privileges for reader
         */
        $this->deny('reader', 'default_book', array('edit', 'add'));
        $this->deny('reader', 'default_category');
        $this->deny('reader', 'default_user');
    }

    /**
     * Override to add default role.
     *
     * @param string $role
     * @param string $resource
     * @param string $privilege
     * @return boolean
     */
    public function isAllowed($role = null, $resource = null, $privilege = null)
    {
        if (is_null($role)) {
            $role = 'guest';
        }

        return parent::isAllowed($role, $resource, $privilege);
    }
}