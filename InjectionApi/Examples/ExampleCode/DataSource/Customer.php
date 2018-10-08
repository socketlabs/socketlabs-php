<?php

class Customer{
    
    public $firstName;

    public $lastName;

    public $email;

    public $favoriteColor;


    public function __construct($firstName, $lastName, $email, $favoriteColor){
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->favoriteColor = $favoriteColor;
    }

}