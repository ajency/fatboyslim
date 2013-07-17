<?php

/** Bootstrap Slim */
require 'libs/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
require "libs/NotORM/NotORM.php";

//require 'fetchUsers.php';

//get the global app object
$app = new \Slim\Slim(array('debug' => true));

//get database object
$pdo = new PDO("mysql:dbname=hospice_care;host:localhost;", 'root', '');
$db = new NotORM($pdo);

$app->get('/users', function () use ($app, $db) {

            $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

            if (isset($_GET['teamid'])) {
                users_not_in_team($_GET['teamid'], $db, $app, $offset);
            } else {
                $users = array();

                $user_to_teams = array();



                $total = $db->users();

                foreach ($db->users()->limit(5, $offset) as $user) {

                    $team_names = array();

                    $team_ids = $db->user_team()->where('user_id', $user["id"]);

                    foreach ($team_ids as $team_id) {

                        $user_to_teams = $db->teams()->where('id', $team_id['team_id']);
                    }

                    foreach ($user_to_teams as $user_to_team) {

                        $team_names[] = $user_to_team['team_name'];
                    }

                    $users[] = array(
                        "id" => (int) $user["id"],
                        "full_name" => $user["full_name"],
                        "email" => $user["email"],
                        "teams" => $team_names
                    );
                }
                $app->response()->header("Content-Type", "application/json");
                echo json_encode(array('data' => $users, 'total' => count($total)));
            }
        });

/*
 *  fetch users who are not in a particular team
 *  teams tab
 */
$app->get('/notinteam/:teamid', function ($teamid) use ($app, $db) {



            $userIds = array();

            $existingusers = $db->user_team()->where("team_id", $teamid);
            if (count($existingusers) > 0) {
                foreach ($existingusers as $existinguser)
                    $userIds[] = $existinguser['user_id'];
            }

            $users = $db->users()->where("NOT id", $userIds);
            foreach ($users as $user) {

                $users_details[] = array(
                    "user_id" => (int) $user["id"],
                    "full_name" => $user["full_name"],
                    "email" => $user["email"],
                );
            }


            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $users_details, 'total' => count($users_details)));
        });

/*
 *  fetch users who are not in a particular team
 *  teams tab
 */
$app->get('/addNewTeam/', function () use ($app, $db) {


            $name = trim($_GET['team']);

            $check_team_exists = $db->teams()->where("team_name", $name);
            if (count($check_team_exists) == 0) {
                $newTeam = array(
                    "team_name" => $name
                );
                $db->teams()->insert($newTeam);



                $total = $db->teams();

                foreach ($db->teams() as $team) {

                    $teams[] = array(
                        "id" => (int) $team["id"],
                        "team_name" => $team["team_name"],
                    );
                }

                $app->response()->header("Content-Type", "application/json");
                echo json_encode(array('data' => $teams, 'status' => '200'));
            } else {
                $app->response()->header("Content-Type", "application/json");
                echo json_encode(array('data' => "", 'status' => '401'));
            }
        });



/*
 *  fetch teams members based on team id
 *  teams tab
 * 
 */
$app->get('/team/:id', function ($id) use ($app, $db) {

            $team_members = array();

            $team_id = $id;

            $users_details = array();

            if (null === $id)
                $users_details = array();


            $total = $db->user_team()->where('team_id', $team_id);
            foreach ($total as $user_team) {

                $user_name = $db->users()->where('id', $user_team['user_id']);
                foreach ($user_name as $email_id) {
                    $users_details[] = array(
                        "user_id" => (int) $email_id["id"],
                        "full_name" => $email_id["full_name"],
                        "email" => $email_id["email"],
                    );
                }
            }

            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $users_details, 'total' => count($total)));
        });


/*
 *  add to team 
 *  ajax call
 * 
 */
$app->get('/addToTeam/:id/:team_id', function ($id, $team_id) use ($app, $db) {

            $userIds = explode(",", $id);

            $userToTeam = array();

            for ($index = 0; $index < sizeof($userIds); $index++) {

                if (!empty($userIds[$index])) {
                    $userToTeam = array(
                        'user_id' => $userIds[$index],
                        'team_id' => $team_id
                    );
                    $data = $db->user_team()->insert($userToTeam);
                }
            }



            if ($team_id == null)
                $userToTeam = "Please select a team";


            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $userToTeam));
        });


/*
 *  remove from team
 * ajax call
 * 
 */
$app->get('/removefromTeam/:id/:team_id', function ($id, $team_id) use ($app, $db) {

            $userIds = explode(",", $id);

            $userToTeam = array();

            for ($index = 0; $index < sizeof($userIds); $index++) {
                $data = $db->user_team()->where('user_id', $userIds[$index])->where('team_id', $team_id)->delete();
            }




            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $userToTeam));
        });
$app->get('/teams', function () use ($app, $db) {

            $teams = array();

            $total = $db->teams();

            foreach ($db->teams() as $team) {

                $teams[] = array(
                    "id" => (int) $team["id"],
                    "team_name" => $team["team_name"],
                );
            }
            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $teams));
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

/*
 * fetch all teams from the system for the calendar view
 */
$app->get('/allinteam', function () use ($app, $db) {

            $teams = array();

            $user_to_teams = array();

            $total = $db->teams();

            foreach ($db->teams() as $team) {
                $email_ids = array();
                $team_names = array();

                $user_ids = $db->user_team()->where('team_id', $team["id"]);
                if (count($user_ids) > 0) {
                    foreach ($user_ids as $user_id) {

                        $user_to_teams = $db->users()->where('id', $user_id['user_id']);
                        foreach ($user_to_teams as $user_to_team) {

                            $email_ids[] = $user_to_team['email'];
                        }
                        
                    }
                } else {
                    $email_ids = array();
                }
                $users[] = array(
                            "id"=>$team['id'],
                            "team" => $team['team_name'],
                            "email" => $email_ids
                        );
            }
            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $users, 'total' => count($total)));
        });

$app->get('/user/calendarcolor/:email', function($email) use ($app, $db){
   
    include_once('php/dbconfig.php');
    include_once('php/functions.php');
    include_once('OAuth.php');
    require('google-api-php-client/src/Google_Client.php');
    include('google-api-php-client/src/contrib/Google_CalendarService.php');
    require('twolegged.php');
    $sfGoogleCalendar = new sfGoogleApiCalendar($email);
    $calendar = $sfGoogleCalendar->getCalendar($email);

    $app->response()->header("Content-Type", "application/json");
    echo json_encode(array($email ,$calendar->backgroundColor));
 
 });

$app->run();

function users_not_in_team($teamid, $db, $app, $offset) {
    $userIds = array();

    $total = $db->users();

    $existingusers = $db->user_team()->where("team_id", $teamid);
    if (count($existingusers) > 0) {
        foreach ($existingusers as $existinguser)
            $userIds[] = $existinguser['user_id'];
    }

    $users = $db->users()->where("NOT id", $userIds);
    foreach ($users->limit(5, $offset) as $user) {

        $users_details[] = array(
            "id" => (int) $user["id"],
            "full_name" => $user["full_name"],
            "email" => $user["email"],
            "teams" => array()
        );
    }


    $app->response()->header("Content-Type", "application/json");
    echo json_encode(array('data' => $users_details, 'total' => count($total)));
}

