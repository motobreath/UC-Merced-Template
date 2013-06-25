<?php

/**
 * Cassify Application. Will run on every page request to check CAS session
 * first login saves user and stores in session
 *
 * NOTE: CAS include library included in bootstrapinclude "CAS/CAS.php";
 *
 * @author Chris
 */

class App_Controller_Action_Helper_CAS
    extends Zend_Controller_Action_Helper_Abstract
{

    /**
     *
     * @var Application_Model_UserMapper
     */
    private $userMapper;

    /**
     *
     * @param Zend_Controller_Action_Helper_FlashMessenger
     */
    private $msg;

    public function login() {

        $sessionHelper=new App_Controller_Action_Helper_Session();
        $session=$sessionHelper->getSession();

        if(!isset($session->user)){
            phpCAS::client(SAML_VERSION_1_1,"cas.ucmerced.edu",443,"/cas",false);
            phpCAS::setNoCasServerValidation();
            phpCAS::forceAuthentication();
            $userName=phpCAS::getUser();
            $attributes=phpCAS::getAttributes();

            $appUser=new Application_Model_User(array(
                "ucmnetID"=>$userName,
                "name"=>$attributes["cn"]
            ));

            //NOTE:
            //Try/catch here to correctly throw errors
            //this needs to be done better than var_dump to
            //trap errors. When moving to prod do that.

            //is admin?
            try{
                $validator=new App_Validate_IsAdministrator();
                if(!$validator->isValid($appUser->getUcmnetID())){
                    $appUser->setIsAdmin(true);
                }
            }
            catch(Exception $e){
                $msg=$this->getFlashMessenger();
                $msg->setNamespace("UCStatusError")->addMessage("Cannot login. This message has been logged.");
                $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
                $redirector->gotoUrl('/');
            }

            try{
                //check if we need to update or insert
                $appUserCheck=$this->getUserMapper()->find($appUser->getUcmnetID());
                if($appUserCheck){
                    $appUser->setUserId($appUserCheck->getUserId());
                }
            }
            catch(Exception $e){
                var_dump($e);
                die();
            }

            //finally save to session and save
            $this->getUserMapper()->save($appUser);
            $session->user=$appUser;

        }

    }

    private function getUserMapper(){
        if($this->userMapper===null){
            $this->userMapper=new Application_Model_UserMapper();
        }
        return $this->userMapper;
    }

    private function getFlashMessenger(){
        if($this->msg===null){
            $this->msg=new Zend_Controller_Action_Helper_FlashMessenger;
        }
        return $this->msg;
    }

}

?>
