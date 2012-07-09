<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Chris
 */
class Application_Model_User {

    public $userId;
    public $ucmnetID;
    public $name;
    public $isAdmin;

    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . strtoupper($name);
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid cycle property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . ucfirst($name);
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid cycle property');
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);

        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getUcmnetID() {
        return $this->ucmnetID;
    }

    public function setUcmnetID($ucmnetID) {
        $this->ucmnetID = $ucmnetID;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getIsAdmin() {
        return $this->isAdmin;
    }

    public function setIsAdmin($isAdmin) {
        $this->isAdmin = $isAdmin;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

}

?>
