<?php
/**
 * Created by PhpStorm.
 * User: Kalev
 * Date: 23.03.2018
 * Time: 21:16
 */
class OrderLine {
    public $firstName;
    public $lastName;
    public $phone;
    public $id;

    public function __construct($firstName, $lastName, $phone, $id) {
        $this -> firstName = $firstName;
        $this -> lastName = $lastName;
        $this -> phone = $phone;
        $this -> id = $id;
    }
}