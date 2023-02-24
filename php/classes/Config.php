<?php


namespace Classes;


class Config // класс конфигурации для подключения к бд
{
    static $hostname = "127.0.0.1",$username = "root",$password = "",$dbname = "users";

 public static function getConnection(){
     $conn = mysqli_connect(Config::$hostname, Config::$username, Config::$password, Config::$dbname);
     if(!$conn){
         echo "Database connection error".mysqli_connect_error();
     }

     return $conn;
 }
}