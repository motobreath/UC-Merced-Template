<?php

/**
 * View Helper to display admins
 *
 * @author Chris
 */
class App_View_Helper_DisplayAdmins
{

    public $view;

    public function displayAdmins(){
        $adminMapper=new Application_Model_AdminsMapper();
        $admins=$adminMapper->fetchAll();
        return $this->view->partial("partials/displayAdmins.phtml",array("admins"=>$admins));
    }

    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }



}

?>
