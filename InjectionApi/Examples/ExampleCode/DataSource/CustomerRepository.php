<?php
//root path relative to this include
include_once (__DIR__ . "../../DataSource\Customer.php");


class CustomerRepository{

    public function GetData(){

        $customer1 = new Customer("Recipient", "One", "recipient1@example.com", "Green");
        $customer2 = new Customer("Recipient", "Two", "recipient2@example.com", "Red");
        $customer3 = new Customer("Recipient", "Three", "recipient3@example.com", "Blue");
        $customer4 = new Customer("Recipient", "Four", "recipient4@example.com", "Orange");

        $results = array();

        array_push($results, $customer1, $customer2, $customer3, $customer4);

        return $results;
    }

}