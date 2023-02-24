<?php
namespace Classes;
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
use Classes\UserContract;
class Users
{

    private $usersId =[],$users=[];

    /**
     * @return array
     */

    /**
     * Users constructor.
     * @param $method
     * @param mixed ...$var
     */
    public function __construct($method,...$var) // указание метода выборки, и диапазон, в случае с != несколько чисел
    {
        $query ="";
        if($method==">")
            $query = "SELECT `id` FROM `users` WHERE id > $var[0] ";


            elseif($method=="<")
                $query = "SELECT `id` FROM `users` WHERE id < $var[0] ";

            elseif($method=="!=") {
                $query = "SELECT `id` FROM `users` WHERE id != ";
                for ($i = 0; $i < count($var); $i++) {
                    if ($i != count($var) - 1)
                        $query .= $var[$i] . " and ";
                    else
                        $query .= $var[$i];
                }
            }

                $rows = mysqli_query(Config::getConnection(), $query);
                if ($rows->num_rows > 0) {

                    while ($row = $rows->fetch_assoc()) {
                        array_push($this->usersId, $row["id"]);

                    }
                } else {
                    echo "0 results";
                }
                echo mysqli_error(Config::getConnection()) . "\n";

            }




    public function getUsers()//получение юзеров по выборке из конструктора
    {

            $this->users = array();
            foreach ($this->usersId as $value)
                array_push($this->users, UserContract::getUserById($value));
            return $this->users;

    }

    public function deleteUsers()// удаление юзеров по полученным юзерам на основе выборки
    {

            $this->getUsers();

            foreach ($this->users as $user) {
                $user->deleteFromDatabase();
            }


    }


}