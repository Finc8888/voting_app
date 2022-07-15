<?php
namespace User;

class User {
    private $name;
    private $role;
    private $country;
    private $age;

    public function __construct($name, $role = "user", $country = "", $age =" ")
    {
        $this->name = $name;
        $this->role = $role;
        $this->country = $country;
        $this->age = $age;
    }
    private function init($con) {
        if (!$con->get('user')){
           $con->set('user', 0); 
        }
    }
    public function save($con) {
        $this->init($con);
        $userId = $con->incr('user');
        $userId = (string) $userId;
        $user = "user:$userId";
        $created = date("d.m.Y");
        $con->hmset($user, [
            "name" => $this->name,
            "role" => $this->role,
            "country" => $this->country,
            "age" => $this->age,
            "created" => $created

        ]);
        return $userId;
    }
    static function get($con, $user) {
        return $con->hvals($user);
    }

}