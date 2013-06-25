<?php

/**
 * View helper to broker flash messenger messages
 *
 * @author Chris
 */
class App_View_Helper_GetMessages {

    public function getMessages(){

        $flashMessenger=Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
        $messages = $flashMessenger->getMessages();
        if($messages){

            $output.="<div class='msg homepage'>";
            foreach($messages as $msg){
                $output.=$msg;
            }
            $output.="</div>";

            return $output;
        }
        $flashMessenger->setNamespace('UCStatusError');
        $messages=$flashMessenger->getMessages();
        if($messages){

            $output="<div class='msg error'>";
            foreach($messages as $msg){
                $output.=$msg;
            }
            $output.="</div>";
           
            return $output;
        }


    }

}

?>
