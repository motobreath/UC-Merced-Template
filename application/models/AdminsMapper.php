<?php

/**
 * Maps to user table in db
 *
 * @author Chris
 */
class Application_Model_AdminsMapper {

    /**
     *
     * @var Zend_Db
     */
    public $db;

    public function __construct(){
        $this->db=Zend_Db_Table_Abstract::getDefaultAdapter();
    }

    public function fetchAll(){
        $sql=$this->db->select()->from("admins")->join("AppUser","admins.userId=AppUser.userId");
        $rs=$this->db->fetchAll($sql);
        $results=array();
        if($rs){
            foreach($rs as $admin){
                $results[]=new Application_Model_Admins(array(
                    "ucmnetID"=>$admin["ucmnetID"],
                    "adminID"=>$admin["ID"]
                ));
            }
            return $results;
        }
    }

    /**
     *
     * @param Application_Model_Admins $admin
     * @return Bool
     */
    public function insert(Application_Model_Admins $admin){

        $sql=$this->db->select()->from("AppUser")->where("ucmnetID=?",$admin->getUcmnetID());
        $rs=$this->db->fetchRow($sql);
        if($rs){
            $admin->setUserId($rs["userId"]);
        }
        else{
            //insert into users table too
            $user=new Application_Model_User(array("ucmnetID"=>$admin->getUcmnetID()));
            $userMapper=new Application_Model_UserMapper();
            $userMapper->save($user);
            $admin->setUserId($this->db->lastInsertId("AppUser"));
        }

        $bind=array(
            "userId"=>$admin->getUserId()
        );
        return $this->db->insert("admins",$bind);
    }

    /**
     *
     * @param String $ucmnetid
     */
    public function delete($adminId){
        return $this->db->delete("admins","ID=$adminId" );
    }



}

?>
