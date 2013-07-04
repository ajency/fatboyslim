<?php

/** Bootstrap Slim */
require 'libs/Slim/Slim.php';
\Slim\Slim::registerAutoloader();

/** Bootstrap NotORM */ 
require "libs/NotORM/NotORM.php";

//get the global app object
$app = new \Slim\Slim(array('debug' => true));

//get database object
$pdo = new PDO("mysql:dbname=hospice;host:localhost;", 'root','');
$db = new NotORM($pdo);

$app->get('/users', function () use ($app, $db) {
	
	$users = array();

	$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

	$total = $db->users();
	
	foreach ($db->users()->limit(2,$offset) as $user) {
		
		$users[]  = array(
				"id" 		=> (int)$user["id"],
				"full_name"	=> $user["full_name"],
				"email"		=> $user["email"],
				"teams" 	=> array("Team1", "Team2")
		);
	}
	$app->response()->header("Content-Type", "application/json");
	echo json_encode(array('data' => $users, 'total' => count($total)));
	
});

$app->run();