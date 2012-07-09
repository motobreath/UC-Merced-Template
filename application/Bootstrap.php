<?php

include "CAS/CAS.php";

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initActionHelpers(){
        Zend_Controller_Action_HelperBroker::addPrefix("App_Controller_Action_Helper");
    }

    protected function _initViewHelpers(){
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $view->addHelperPath('App/View/Helper', 'App_View_Helper');
    }

    protected function _initNamespace(){
        Zend_Registry::set("namespace", "ITStatus");
    }

    protected function _initDB(){
        //MySQL -> default adapter
        $config=new Zend_Config_Ini(APPLICATION_PATH . "/configs/db.ini",APPLICATION_ENV);
        $db=Zend_Db::factory($config->database->adapter,$config->database);
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
    }

    protected function _initNavigation()
    {
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();

        //set top navigation
        $config=new Zend_Config_Xml(APPLICATION_PATH . "/configs/navigation.xml","nav");
        $navigation = new Zend_Navigation($config);

        //pass to view
        $view->nav=$navigation;

        //set admin navigation
        $configAdminNav=new Zend_Config_Xml(APPLICATION_PATH . "/configs/navigation.xml","adminNav");
        $adminNavigation = new Zend_Navigation($configAdminNav);

        //pass to view
        //note, have to pass to registry to access from view and not layout
        //not sure why here... but this works
        Zend_Registry::set("adminNav",$adminNavigation);
    }

}

