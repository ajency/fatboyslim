<?php

function is_admin() {
    require "libs/NotORM/NotORM.php";
    if ($_SERVER['HTTP_HOST'] == "localhost") {
        $pdo = new PDO("mysql:dbname=hospice_care;host:localhost;", 'root', '');
    } else {
        $pdo = new PDO('mysql:dbname=hospice;host=mysql.ajency.in', 'hospice1', 'temp123');
    }
    $db = new NotORM($pdo);

    $is_admin = $db->users()->where('email', trim($_SESSION['email']));
    if (count($is_admin) > 0) {
       foreach($is_admin as $isadmin){
           
        if ($isadmin['is_admin'] == 1)
            return true;
        else
            return false;
    }
    }
}

//	if(!isset($_SESSION['is_admin']))
//	return false;	