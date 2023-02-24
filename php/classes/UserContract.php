<?php
namespace Classes;
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
use Classes\Validation;
class UserContract //класс юзера
{

    private $firstname, $lastname, $birthdate, $sex, $id, $city;

    //свойства
    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $birthdate
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }


    function __construct($firstname, $lastname, $birthdate, $sex, $city,$id=null)// конструктор, поддерживает создание сразу в бд
        //с автоинкрементом или создание экземпляра без добавления в бд
    {
        $validateObj = new Validation();
        $firstnameVal = htmlspecialchars(strip_tags($firstname));
        $lastnameVal = htmlspecialchars(strip_tags($lastname));
        $birthdateVal = htmlspecialchars(strip_tags($birthdate));
        $sexVal = htmlspecialchars(strip_tags($sex));
        $cityVal = htmlspecialchars(strip_tags($city));
        if(isset($id))
            $idVal = htmlspecialchars(strip_tags($id));
        else
            $idVal =$id;

        
        $this->firstname = $firstnameVal;
        $this->lastname = $lastnameVal;
        $this->birthdate = $birthdateVal;
        $this->sex = $sexVal;
        $this->city = $cityVal;
        if ($id == null) {
            if(empty($validateObj->validate($firstnameVal,$lastnameVal,$birthdateVal,$sexVal,$cityVal,$idVal))){//простейшая валидация, примитивная
                $sql = mysqli_query(Config::getConnection(), "INSERT INTO users (firstname, lastname, birthdate,sex,city) 
            VALUES ('{$this->firstname}', '{$this->lastname}', '{$this->birthdate}','{$this->sex}','{$this->city}')");
                echo mysqli_error(Config::getConnection()) . "\n";
                $this->id = mysqli_insert_id(Config::getConnection());
            }
           else
               print_r($validateObj->validate($firstnameVal,$lastnameVal,$birthdateVal,$sexVal,$cityVal,$idVal));
        } else {
            $this->id = $idVal;
        }







    }

    public function saveToDatabase()//сохранение в бд экземпляра, можем поменять ему поля при помощи свойств
    {

        $sql = mysqli_query(Config::getConnection(), "UPDATE users SET firstname = '{$this->firstname}' , lastname = '{$this->lastname}', birthdate ='{$this->birthdate}' ,sex ='{$this->sex}' ,city = '{$this->city}' WHERE id = '{$this->id}'");
        echo mysqli_error(Config::getConnection()) . "\n";
        echo $sql;
    }

    public static function deleteFromDatabaseById($id) //удаление по айди
    {

        $sql = mysqli_query(Config::getConnection(), "DELETE FROM users WHERE id = '{$id}'");
        echo mysqli_error(Config::getConnection()) . "\n";

    }

    public function deleteFromDatabase()//удаление экземпляра
    {

        $sql = mysqli_query(Config::getConnection(), "DELETE FROM users WHERE id = '{$this->id}'");
        echo mysqli_error(Config::getConnection()) . "\n";

    }

    public static function getTextSex(UserContract $user){// форматирование пола
        if($user->getSex()==1)
            return "Муж";
        elseif($user->getSex()==0)
            return "Жен";
    }

    public static function getAge(UserContract $user){ //форматирование возраста
        $birthDate = explode("-",$user->getBirthdate());
        $d = $birthDate[2];
        $m = $birthDate[1];
        $y = $birthDate[0];
        if($m > date('m') || $m == date('m') && $d > date('d'))
            return (date('Y') - $y - 1);
        else
            return (date('Y') - $y);
    }

    public static function getUserById($id){ //получение юзера по айди

        $query = "SELECT * FROM users WHERE id = '$id'";
        $row = mysqli_fetch_assoc(mysqli_query(Config::getConnection(), $query));
        return (new UserContract($row["firstname"],$row["lastname"],$row["birthdate"],$row["sex"],$row["city"],$row["id"]));
    }

    public function getFormattedUser(){// получение форматированнного пользователя, решил возвращать не stdClass а экземпляр юзера
        return (new UserContract($this->id,$this->firstname,$this->lastname,UserContract::getAge($this),UserContract::getTextSex($this),$this->city));
    }
}
?>