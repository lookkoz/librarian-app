<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        
    }

    public function signInAction()
    {
        $form = new Application_Form_UserSignIn();
        if($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)) {
                $email = $form->email->getValue();
                $password = $form->password->getValue();
                
                $adapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
                $adapter->setTableName('users')->setCredentialTreatment("SHA1(?)");
                $adapter->setIdentityColumn('email')->setCredentialColumn('password');
                $adapter->setIdentity($email)->setCredential($password);
                
                $result = $adapter->authenticate();
                $userData = $adapter->getResultRowObject(null, 'password');
                
                if($result->isValid() && $userData->status == 'active') {
                    $this->auth->getStorage()->write($adapter->getResultRowObject());
                    $user = new Application_Model_User();
                    $user->getUserByEmail($email);
                    $user->last_activity = new Zend_Db_Expr('NOW()');
                    $user->save();
                    $this->_helper->FlashMessenger('You have been logged in successfully');
                    return $this->_helper->redirector->gotoUrl('/');
                } elseif($userData->status == 'inactive') {
                    $this->_helper->FlashMessenger('Your account is not active.');
                    return $this->_helper->redirector->gotoUrl('/user/sign-in');
                }
                else {
                    $this->_helper->FlashMessenger('You have entered wrong credentials. Please try again.');
                    return $this->_helper->redirector->gotoUrl('/user/sign-in');
                }
            }
            else {
                $form->populate($formData);
            }
        }
        $this->view->form = $form;
    }


}



