<?php
/**
 * Get a Zend_Session object
 *
 * @author Chris
 */
class App_Controller_Action_Helper_Session
    extends Zend_Controller_Action_Helper_Abstract
{
    private $session = null;
    private $namespace = null;

    /**
     * Implement direct() to allow direct access from controller
     * @return Zend_Session
     */
    public function direct(){
        return $this->getSession();
    }

    /**
     * Get Zend session object
     * @return Zend_Session
     */
    public function getSession()
    {
        if(null===$this->session){
            $this->session=new Zend_Session_Namespace($this->getNamespace());
        }
        return $this->session;
    }

    /**
     *
     * @return type
     */
    private function getNamespace()
    {
        if(null===$this->namespace){
            if(Zend_Registry::isRegistered("namespace")){

                $this->namespace=Zend_Registry::get("namespace");
            }
            else{
                //if namespace not set in bootstrap, use generic namespace
                //call helper to generate random char string
                $rnd=new App_Controller_Action_Helper_RandomCharacterGenerator();
                $this->namespace=$rnd->generateSequence();
                Zend_Registry::set("namespace",$this->namespace);
            }
        }
        return $this->namespace;
    }
}

?>
