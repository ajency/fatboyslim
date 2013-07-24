<?php

/** Bootstrap Slim */
require 'libs/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
require "libs/NotORM/NotORM.php";

require 'fetchUsers.php';
//get the global app object
$app = new \Slim\Slim(array('debug' => true));

//get database object
if ($_SERVER['HTTP_HOST'] == "localhost") {
    $pdo = new PDO("mysql:dbname=hospice_care;host:localhost;", 'root', '');
} else {
    //$pdo = new PDO('mysql:dbname=hospice;host=mysql.ajency.in', 'hospice1', 'temp123');
$pdo = new PDO('mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=db479756567;host:db479756567.db.1and1.com;','dbo479756567','hospicecare');
    
}
$db = new NotORM($pdo);
?>