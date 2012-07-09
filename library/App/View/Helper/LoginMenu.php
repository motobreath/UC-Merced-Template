<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IsLoggedIn
 *
 * @author Chris
 */
class App_View_Helper_LoginMenu
    extends Zend_View_Helper_Abstract
{
    public function loginMenu(){

        $sessionHelper=new App_Controller_Action_Helper_Session();
        $session=$sessionHelper->getSession();
        if(isset($session->user)){
            $username=$session->user->getName();
            $output= "<li>Welcome $username</li>
                    <li><a href='/'>Home</a></li>
                    <li>|</li>";
            if($session->user->getIsAdmin()){
                $output.="<li><a href='/admin'>Admin</a></li>
                        <li>|</li>";

            }
            $output.= "<li><a href='/index/logout'>Logout</a></li>";
        }
        else{
            $output = "<li>Welcome Guest</li>
                    <li><a href='/'>Home</a></li>
                    <li>|</li>
                    <li><a href='/index/login'>Login</a></li>";
        }
        return $output;
    }
}

?>
