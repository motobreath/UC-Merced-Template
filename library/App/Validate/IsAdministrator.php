<?php

/**
 * Checks if user is administrator for an app (grad or undergrad)
 *
 * @author Chris
 */
class App_Validate_IsAdministrator extends Zend_Validate_Abstract {

    const INVALID_URL = 'adminAlreadyExists';

    protected $_messageTemplates = array(
    self::INVALID_URL => "'%value%' is already an admin.",
    );

    public function isValid($value){
        $this->_setValue($value);
        $db=Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql=$db->select()->from("admins")
                ->join("appuser","admins.userId=appuser.userId")
                ->where("appuser.ucmnetID=?",$value);
        $rs=$db->fetchOne($sql);

        if($rs){
            $this->_error(self::INVALID_URL);
            return false;
        }

        return true;


    }

}

?>
