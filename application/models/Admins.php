<?php
/**
 * Description of Admins
 *
 * @author Chris
 */
class Application_Model_Admins
    extends Application_Model_User
{


    public $adminID;

    public function getAdminID() {
        return $this->adminID;
    }

    public function setAdminID($adminID) {
        $this->adminID = $adminID;
    }



}

?>
