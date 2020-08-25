<?php
class exampleConfig{

    public function __construct(){

    }

    public static function serverId(){
        return getenv('SOCKETLABS_SERVER_ID');
    }

    public static function password(){
        return getenv('SOCKETLABS_INJECTION_API_KEY', true) ?: getenv('SOCKETLABS_INJECTION_API_KEY');
    }

    public static function proxy() {
        return "http://127.0.0.1:8888";
    }

    public static function endpoint() {
        return "https://inject.socketlabs.com/api/v1/email";
    }

}