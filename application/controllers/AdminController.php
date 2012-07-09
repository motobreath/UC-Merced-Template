<?php

class AdminController extends Zend_Controller_Action
{

    /**
     * @var Zend_Controller_Action_Helper_FlashMessenger
     *
     */
    public $msg = null;

    public function preDispatch()
    {
        //$sessionHelper=new App_Controller_Action_Helper_Session();
        $session=$this->getHelper("Session")->getSession();

        if(!isset($session->user)){
            $this->getHelper("CAS")->login();
        }
        $appUser=$session->user;
        $isAdmin=$appUser->getIsAdmin();
        if(!$isAdmin){
            $this->getFlashMessenger()->setNamespace("UCStatusError")->addMessage("Access Denied");
            //$redirector=new Zend_Controller_Action_Helper_Redirector();
            $this->getHelper("redirector")->gotoSimpleAndExit("index","index");
        }

    }

    public function init()
    {
        $contextSwitch = $this->_helper->getHelper('ContextSwitch');
        $contextSwitch->addActionContext("modifyadmin", array('json'))
                ->addActionContext("checkadmin", array('json'))
                ->initContext();
    }

    public function indexAction()
    {
        $this->view->sampleForm=new Application_Form_Sample();
    }

    public function getFlashMessenger()
    {
        if(null===$this->msg){
            $this->msg=$this->getHelper("FlashMessenger");
        }
        return $this->msg;
    }

    public function usersAction()
    {
        $layout = Zend_Layout::getMvcInstance();
        $layoutView = $layout->getView();

        $layoutView->bodyClass="adminUsers";
        $form=new Application_Form_AdminUsers();
        $form->setAction("/admin/users");
        $this->view->form=$form;

        if($this->getRequest()->isPost()){
            if($form->isValid($this->_getAllParams())){
                $admin=new Application_Model_Admins(array(
                    "ucmnetID"=>$this->_getParam("ucmnetid")
                ));
                $adminMapper=new Application_Model_AdminsMapper();
                $adminMapper->insert($admin);
                $msg=$this->getHelper("FlashMessenger");
                $msg->addMessage("<p class='success'><strong>Success!</strong> Administrator was added. Add another?</p>");
                $this->_redirect("/admin/users");
            }

        }
    }

    public function modifyadminAction()
    {
        $mapper=new Application_Model_AdminsMapper();
        $mapper->delete($this->_getParam("admin"));
    }

    public function checkadminAction(){
        if(!$this->_getParam("admin")){
            return false;
        }
        $validate=new App_Validate_IsAdministrator();
        $this->view->messages=array("isValid"=>$validate->isValid($this->_getParam("admin")));
    }


}



