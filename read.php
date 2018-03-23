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

    public function __construct($firstName, $lastName, $phone) {
        $this -> firstName = $firstName;
        $this -> lastName = $lastName;
        $this -> phone = $phone;
    }
}