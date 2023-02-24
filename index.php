<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TestProject</title>
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div>
<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require dirname(__DIR__) . '\slmax-testovoe-zadanie\php\init.php';
use Classes\UserContract;
use Classes\Users;

//$user = new UserContract("Иван","Иванов","1989-11-29",true,"Минск");


//UserContract::deleteFromDatabaseById(110);

/*$user = UserContract::getUserById(80);
print_r($user->getFormattedUser());*/
//$users = new Users("!=",3,4,6);
/*$users = new Users(">",10);
$users ->deleteUsers();*/

/*$users = new Users("<",70);
$users->deleteUsers();*/




?>
</div>

</body>
</html>