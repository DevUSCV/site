<?php

namespace App\Entity;

use JsonSerializable;

/**
 * @Entity
 * @Table(name="license")
 */
class License implements \JsonSerializable {

    /**
     * @var string
     * @ID
     * @Column(type="string", length=255)
     */
    protected $number;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $lastname;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $firstname;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $sex;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $birth_date;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $address;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $zipcode;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $city;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $email;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $year;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $type;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $primo;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $practice;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $aptitude;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $club;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $date;
    
    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $qualification;
    
    /**
     * @var string
     * @Column(type="boolean")
     */
    protected $material;

    function getNumber() {
        return $this->number;
    }

    function getLastanme() {
        return $this->lastname;
    }

    function getFirstname() {
        return $this->firstname;
    }

    function getSex() {
        return $this->sex;
    }

    function getBirth_date() {
        return $this->birth_date;
    }

    function getAddress() {
        return $this->address;
    }

    function getZipcode() {
        return $this->zipcode;
    }

    function getCity() {
        return $this->city;
    }

    function getEmail() {
        return $this->email;
    }

    function getYear() {
        return $this->year;
    }

    function getType() {
        return $this->type;
    }

    function getPrimo() {
        return $this->primo;
    }

    function getPractice() {
        return $this->practice;
    }

    function getAptitude() {
        return $this->aptitude;
    }

    function getClub() {
        return $this->club;
    }

    function getDate() {
        return $this->date;
    }

    function getQualification() {
        return $this->qualification;
    }

    function setNumber($number) {
        $this->number = $number;
    }

    function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    function setSex($sex) {
        $this->sex = $sex;
    }

    function setBirth_date($birth_date) {
        $this->birth_date = $birth_date;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setZipcode($zipcode) {
        $this->zipcode = $zipcode;
    }

    function setCity($city) {
        $this->city = $city;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setYear($year) {
        $this->year = $year;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setPrimo($primo) {
        $this->primo = $primo;
    }

    function setPractice($practice) {
        $this->practice = $practice;
    }

    function setAptitude($aptitude) {
        $this->aptitude = $aptitude;
    }

    function setClub($club) {
        $this->club = $club;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setQualification($qualification) {
        $this->qualification = $qualification;
    }
    
    function getMaterial() {
        return $this->material;
    }

    function setMaterial($material) {
        $this->material = $material;
    }

        
    public function jsonSerialize() {
        return array(
            "number" => $this->number,
            "lastname" => $this->lastname,
            "firstname" => $this->firstname,
            "sex" => $this->sex,
            "birth_date" => $this->birth_date,
            "address" => $this->address,
            "zipcode" => $this->zipcode,
            "city" => $this->city,
            "email" => $this->email,
            "year" => $this->year,
            "type" => $this->type,
            "primo" => $this->primo,
            "practice" => $this->practice,
            "aptitude" => $this->aptitude,
            "club" => $this->club,
            "date" => $this->date,
            "qualification" => $this->qualification,
            "material" => $this->material
        );
    }

}
