<?php

class Application_Form_UserSignIn extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('class', 'sign-in-form');
        
        $this->addElement('text', 'email', array(
            'label'     => 'E-mail',
            'required'  => true,
            'filters'   => array('StripTags', 'StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(3, 128)),
                new Zend_Validate_EmailAddress(),
            )
        ));
        
        $this->addElement('password', 'password', array(
            'label'     => 'Password',
            'required'  => true,
            'filters'   => array('StripTags', 'StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(3, 45))
            )
        ));
        
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Sign In',
        ));
        
        //$this->_setDecorators();
        
        $this->email->setAttrib('class', 'input');
        $this->password->setAttrib('class', 'input');
    }


}

