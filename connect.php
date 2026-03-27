<?php

define("DATABASE", "mysql:host=localhost;dbname=footballplayers;charset=utf8");
define("USER_NAME", "sukhpreet");
define("PASSWORD", "gorgonzola7!");

try{
    $db = new PDO(DATABASE, USER_NAME, PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connection Successful";
}
catch(PDOException $e){
    print "Connection failed: " . $e->getMessage();
    die();
}

?>