<?php
class exampleConfig{
 
    public function __construct(){
         
    }

    public static function serverId(){
        return getenv('SocketlabsInjectionServerId');
    }

    public static function password(){
        return getenv('SocketlabsInjectionApiKey', true) ?: getenv('SocketlabsInjectionApiKey');
    }

    public static function proxy() { 
        return "http://127.0.0.1:8888";
    }

    public static function endpoint() {
        return "https://inject.socketlabs.com/api/v1/email";
    }

}