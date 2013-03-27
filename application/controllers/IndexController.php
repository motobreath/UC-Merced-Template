<?php

class IndexController extends Zend_Controller_Action
{
    /**
     *
     * @var Zend_Controller_Action_Helper_FlashMessenger
     */
    public $msg;

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {

    }

    public function loginAction()
    {
        //$sessionHelper=new App_Controller_Action_Helper_Session();
        $session=$this->getHelper("Session")->getSession();

        if(!isset($session->user)){
            $this->getHelper("CAS")->login();
            $this->getFlashMessenger()->setNamespace("statusMessages")->addMessage("Successfully Logged In");
            $this->getHelper("redirector")->gotoSimpleAndExit("index","index");
        }
    }

    public function layout2Action(){
        $this->_helper->_layout->setLayout('layout2');
    }

    public function layout3Action(){
        $this->_helper->_layout->setLayout('layout3');
    }

    public function logoutAction()
    {
        phpCAS::client(SAML_VERSION_1_1,"cas.ucmerced.edu",443,"/cas",false);
        Zend_Session::destroy("user");
        phpCAS::logoutWithRedirectService("http://faxanadu.ucmerced.edu:8008");
    }

    public function getFlashMessenger(){
        if(null===$this->msg){
            $this->msg=$this->getHelper("FlashMessenger");
        }
        return $this->msg;
    }


}





