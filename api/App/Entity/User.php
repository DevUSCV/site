<?php

namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;
use JsonSerializable;

/**
 * @Entity
 * @Table(name="user")
 */
class User implements JsonSerializable {

    /**
     * @var integer
     *
     * @Id
     * @Column(name="user_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $user_id;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $firstname;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $lastname;

    /**
     * @OneToOne(targetEntity="Address")
     * @JoinColumn(name="address_id", referencedColumnName="address_id")
     */
    private $address;

    /** @Column(type="datetime", name="birth_date") */
    protected $birth_date;
    
    /** @Column(type="datetime", name="subscribe_date") */
    protected $subscribe_date;

    /**
     * @OneToOne(targetEntity="License")
     * @JoinColumn(name="license_id", referencedColumnName="license_id")
     */
    private $license;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $phone;
    
    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $email;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $password;
    
    /**
     * @var string
     * @Column(type="string", length=255)
     */
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
        return $this->birth_date;
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
    
    function getSubscribe_date_date() {
        return $this->subscribe_date_date;
    }

    function getStatus() {
        return $this->status;
    }

    function setSubscribe_date_date($subscribe_date_date) {
        $this->subscribe_date_date = $subscribe_date_date;
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
