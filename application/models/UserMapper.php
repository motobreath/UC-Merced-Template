<?php

/**
 * Maps to user table in db
 *
 * @author Chris
 */
class Application_Model_UserMapper {

    /**
     *
     * @var Zend_Db
     */
    public $db;

    public function __construct(){
        $this->db=Zend_Db_Table_Abstract::getDefaultAdapter();
    }

    public function save(Application_Model_User $user){
        $bind=array(
            "ucmnetID"=>$user->getUcmnetID(),
        );

        //check if user exists

        if($id=$user->getUserId()){
            $where="ucmnetID='" . $user->getUcmnetID() . "'";
            $this->db->update("appuser",$bind,$where);
        }
        else{
            $this->db->insert("AppUser", $bind);
            $user->setUserId($this->db->lastInsertId("AppUser"));
        }
    }

    public function find($username=null,$userId=null){
        if($username==null && $userId==null){
            throw new Exception("User Mapper find method requires a username or a userId, none given",500);
        }
        $sql=$this->db->select()->from("appuser");
        if($username){
            $sql->where("ucmnetID=?",$username);
        }
        if($userId){
            $sql->where("userId=?",$userId);
        }
        $rs=$this->db->fetchRow($sql);
        if($rs){
            $appUser=new Application_Model_User(array(
                "userId"=>$rs["userId"],
                "ucmnetID"=>$rs["ucmnetID"],
                ));
            return $appUser;
        }
        return false;
    }

}

?>
