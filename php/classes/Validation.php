<?php
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

namespace Classes;
class Validation
{

    static $empty_field_message = 'Поле обязательно для заполнения';
    static $firstname_error_message = 'Имя может содержать только буквы';
    static $lastname_error_message = 'Фамилия может содержать только буквы';
    static $sex_error_message = 'Пол должен быть представлен либо 0 либо 1';
    static $birthdate_error_year_message = 'Неккоректный год';
    static $birthdate_error_month_message = 'Неккоректный месяц';
    static $birthdate_error_day_message = 'Неккоректный день';


    //простейшая валидация, заточена на то чтобы на js части принимать массив и раскидывать сообщения по нужным полям валидации
    public function validate($firstname, $lastname, $birthdate, $sex, $city,$id=null)
    {
        $validate = new Validation();
        $msg = [];

        if (empty($firstname))
            $msg += [$firstname => Validation::$empty_field_message];
        else if(!preg_match('/^[a-zа-яё\s]+$/iu',$firstname))
            $msg += [$firstname => Validation::$firstname_error_message];


        if (empty($lastname))
            $msg += [$lastname => Validation::$empty_field_message];
        else if(!preg_match('/^[a-zа-яё\s]+$/iu',$lastname))
            $msg += [$lastname => Validation::$lastname_error_message];

        $birthdateArr =  explode("-",$birthdate);
        if (empty($birthdate))
            $msg += [$birthdate => Validation::$empty_field_message];
        else if($birthdateArr[0]<1880||$birthdateArr[0]>2018)
            $msg += [$birthdate => Validation::$birthdate_error_year_message];
        else if($birthdateArr[1]>12||$birthdateArr[1]<1)
            $msg += [$birthdate => Validation::$birthdate_error_month_message];
        else if($birthdateArr[2]>31||$birthdateArr[2]<1)
            $msg += [$birthdate => Validation::$birthdate_error_day_message];
        //примитивнейшая валидация, так как задачи сделать правильную не было, сделал лишь приблизительно

        if (empty($sex))
            $msg += [$sex => Validation::$empty_field_message];
        else if($sex != false && $sex != true)
            $msg += [$sex => Validation::$sex_error_message];

        if (empty($city))
            $msg += [$city => Validation::$empty_field_message];

        return $msg;
    }




}

