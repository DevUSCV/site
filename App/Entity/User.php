<?php

namespace App\Entity;

class User {

    protected $user_id;
    protected $firstname;
    protected $lastname;
    private $address;
    protected $birth_date;    
    protected $subscribe_date;
    private $license;
    protected $phone;
    protected $email;
    protected $password;
    protected $status;

    function getUser_id() {
        return $this->user_id;
    }

    function getFirstname() {
        return $this->firstname;
    }

    function getLastname() {
        return $this->lastname;
    }

    function getAddress() {
        return $this->address;
    }

    function getBirth_date() {
        return $this->birth_date ? $this->birth_date->format("d/m/Y") : null;
    }

    function getLicense() {
        return $this->license;
    }

    function getPhonel() {
        return $this->phone;
    }
    
    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setBirth_date($birth_date) {
        $this->birth_date = $birth_date;
    }

    function setLicense($license) {
        $this->license = $license;
    }

    function setPhone($phone) {
        $this->phone = $phone;
    }
    
    function setEmail($email) {
        $this->email = $email;
    }

    function setPassword($password) {
        $this->password = $password;
    }
    
    function getSubscribe_date() {
        return $this->subscribe_date ? $this->subscribe_date->format("d/m/Y") : null;
    }

    function getStatus() {
        return $this->status;
    }

    function setSubscribe_date($subscribe_date) {
        $this->subscribe_date = $subscribe_date;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    
    
    public function jsonSerialize() {
        return array(
            'user_id' => $this->user_id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'birth_date' => $this->birth_date,
            'subscribe_date' => $this->subscribe_date,
            'status' => $this->status,
            'address' => $this->address,
            'license' => $this->license,
            'phone' => $this->phone,
            'email' => $this->email,
        );
    }

}
