<?php

/** Bootstrap Slim */
require 'libs/Slim/Slim.php';
\Slim\Slim::registerAutoloader();

/** Bootstrap NotORM */ 
require "libs/NotORM/NotORM.php";

$app = new \Slim\Slim(array('debug' => true));

$app->get('/hello/:name', function ($name) {
	echo "Hello, $name";
});

$app->run();