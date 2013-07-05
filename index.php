<?php

/** Bootstrap Slim */
require 'libs/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
require "libs/NotORM/NotORM.php";
$pdo = new PDO('mysql:dbname=hospice_care;host=localhost', 'root', '');
$db = new NotORM($pdo);


require 'fetchUsers.php';


//get the global app object
$app = new \Slim\Slim(array('debug' => true));

//get database object
$pdo = new PDO("mysql:dbname=hospice_care;host:localhost;", 'root', '');
$db = new NotORM($pdo);

$app->get('/users', function () use ($app, $db) {

            $users = array();

            $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

            $total = $db->users();

            foreach ($db->users()->limit(5, $offset) as $user) {

                $users[] = array(
                    "id" => (int) $user["id"],
                    "full_name" => $user["full_name"],
                    "email" => $user["email"],
                    "teams" => array("Team1", "Team2")
                );
            }
            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $users, 'total' => count($total)));
        });


$app->get('/dbmigration', function ()use ($app, $db) {
            mysql_connect("localhost", "root", "") or die(mysql_error());

            mysql_query("CREATE database IF NOT EXISTS hospice_care") or die(mysql_error());

            mysql_select_db("hospice_care") or die(mysql_error());
            
            mysql_query("CREATE TABLE IF NOT EXISTS user_team ( id INT AUTO_INCREMENT PRIMARY KEY,user_id INT(30), 
 team_id INT(30))") or die(mysql_error());

            mysql_query("CREATE TABLE IF NOT EXISTS users ( id INT AUTO_INCREMENT PRIMARY KEY,full_name VARCHAR(30), 
 email VARCHAR(30))") or die(mysql_error());

            mysql_query("CREATE TABLE IF NOT EXISTS teams ( id INT AUTO_INCREMENT PRIMARY KEY,team_name VARCHAR(30) 
 )") or die(mysql_error());

            //fetch users from google via python script
            $allUsers = fetchDomainUsers();

            //split all the users list
            $users = explode(",", $allUsers);

            for ($i = 0; $i < sizeof($users); $i++) {

                $existinguser = $db->users()->where('full_name', $users[$i]);

                if (count($existinguser) == 0) {

                    $userArray = array(
                        'name' => $users[$i],
                        'email_id' => $email
                    );

                    $data = $db->users()->insert($userArray);
                } else {
                    ;
                }
            }
        });




$app->run();