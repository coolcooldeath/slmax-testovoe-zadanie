<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
function myAutoloader($class) { // автолоадер + тут идет ограничение на подклюбчение класса юзеров если нет класса ЮзерКонтракт
    $class = str_replace("\\", "/", $class);
    if($class!="Classes\Users"){
        require __DIR__."/$class.php";
    }
    else
    if(class_exists("Classes\UserContract"))
        require __DIR__."/$class.php";
    else
        echo "Ошибка загрузки класса UserContract";



}
spl_autoload_register("myAutoloader");

