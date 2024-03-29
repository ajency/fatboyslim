<?php

require 'slim-pdo-config.php';
require 'csv_reader/class.chip_csv.php';
$app->get('/users', function () use ($app, $db) {

            $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

            if (isset($_GET['teamid'])) {
                users_not_in_team($_GET['teamid'], $db, $app, $offset);
            } elseif (isset($_GET['exclude_user'])) {



                $userids[] = $_GET['exclude_user'];

                $useraccess = $db->user_to_usercalendar()->where('user_id', trim($_GET['exclude_user']));

                foreach ($useraccess as $userid) {
                    $userids[] = $userid['access_to'];
                }
                $users = array();

                if (isset($_GET['term'])) {
                    $calendar_user = $db->users()->where("NOT id", $userids)->where('email like ?', $_GET['term'] . "%")->limit(20, $offset);
                    if (count($calendar_user)) {
                        $bold = '<span style="font-weight:bold;">' . trim($_GET['term']) . '</span>';
                        foreach ($calendar_user as $user) {
                            $users[] = array(
                                "id" => (int) $user["id"],
                                "full_name" => $user["first_name"] . " " . $user['last_name'],
                                "email" => str_ireplace($_GET['term'], $bold, $user["email"]),
                            );
                        }
                        $total = $users;
                    } else {
                        $total = $users;
                    }
                } elseif (!isset($_GET['term'])) {
                    $total = $db->users();
                    foreach ($db->users()->where("NOT id", $userids)->limit(20, $offset) as $user) {
                        $users[] = array(
                            "id" => (int) $user["id"],
                            "full_name" => $user["first_name"] . " " . $user['last_name'],
                            "email" => $user["email"],
                        );
                    }
                }
                $app->response()->header("Content-Type", "application/json");
                echo json_encode(array('data' => $users, 'total' => count($total)));
            } elseif (isset($_GET['access'])) {

                $userids = array();

                $users = array();
                $access_to = array();
                $useraccess = $db->user_to_usercalendar()->where('user_id', trim($_GET['access']));

                foreach ($useraccess as $userid) {
                    $userids[] = $userid['access_to'];
                    $access_to[] = $userid['write_access'];
                }
                $withacces = $db->users()->where('id', $userids);

                $total = count($useraccess);
                $i = 0;
                foreach ($withacces as $userdetails) {
                    $users[] = array(
                        "id" => (int) $userdetails["id"],
                        "full_name" => $userdetails["first_name"] . " " . $userdetails["last_name"],
                        "email" => $userdetails["email"],
                        "access" => $access_to[$i],
                        'mail'=>$userdetails["email"],
                        
                    );
                    $i = $i + 1;
                }

                $app->response()->header("Content-Type", "application/json");

                echo json_encode(array('data' => $users, 'total' => count($users)));
            } elseif (isset($_GET['term'])) {

                searchfor(trim($_GET['term']), $db, $app, $offset);
            } else {
                $users = array();
                $users_data = array();

                $user_to_teams = array();
                $team_names = array();
                $total = $db->users();
                $users = $db->users()->limit(30, $offset);
                foreach ($users as $user) {
                    $team_names = array();

                    $team_ids = $db->user_team()->where('user_id', $user["id"]);

                    foreach ($team_ids as $team_id) {

                        $user_to_teams[] = $team_id['team_id'];
                        $user_id[] = $team_id['user_id'];
                    }
                    if (count($team_ids) > 0) {
                        $teams = $db->teams()->where('id', $user_to_teams);

                        foreach ($teams as $user_to_team) {

                            $team_names[] = $user_to_team['team_name'];
                        }
                    } else {
                        $team_names = array();
                    }
                    $users_data[] = array(
                        "id" => (int) $user["id"],
                        "full_name" => $user["first_name"] . " " . $user["last_name"],
                        "email" => strstr( $user["email"], '@',true)."@",
                        "teams" => $team_names,
                        'mail'=>$user["email"]
                    );
                }


                $app->response()->header("Content-Type", "application/json");
                echo json_encode(array('data' => $users_data, 'total' => count($total)));
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
                    "full_name" => $user["first_name"] . "" . $user["last_name"],
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
                        "full_name" => $email_id["first_name"] . " " . $email_id['last_name'],
                        "email" => $email_id["email"],
                    );
                }
            }

            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $users_details, 'total' => count($users_details)));
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
            $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

            $teams = array();

            $total = $db->teams();

            $limit = isset($_GET['limit']) ? $_GET['offset'] : 0;

            if (isset($_GET['limit'])) {

                $teams = array();

                $teamids = array();

                $teamaccess = $db->user_to_teamcalendar()->where('user_id', trim($_GET['user']));

                foreach ($teamaccess as $teamid) {
                    $teamids[] = $teamid['team_id'];
                }
                if (isset($_GET['term'])) {
                    $teams_names = $db->teams()->where('NOT id', $teamids)->where('team_name like ?', "%" . trim($_GET['term']) . "%")->limit(7, $offset);
                    if (count($team_names)) {
                        foreach ($teams_names as $team) {

                            $teams[] = array(
                                "id" => (int) $team["id"],
                                "team_name" => $team["team_name"],
                            );
                        }
                    } else {
                        $total = array();
                    }
                    $total = $teams;
                } else {
                    foreach ($db->teams()->where('NOT id', $teamids)->limit(7, $offset) as $team) {

                        $teams[] = array(
                            "id" => (int) $team["id"],
                            "team_name" => $team["team_name"],
                        );
                    }
                }
                $total = $teams;
            } elseif (isset($_GET['access'])) {

                $userids = array();

                $users = array();

                $teamids = array();

                $teamaccess = $db->user_to_teamcalendar()->where('user_id', trim($_GET['access']));

                foreach ($teamaccess as $teamid) {
                    $teamids[] = $teamid['team_id'];
                    $access_to[] = $teamid['write_access'];
                }

                $teamswithacces = $db->teams()->where('id', $teamids);


                $i = 0;
                foreach ($teamswithacces as $teamdetails) {
                    $teams[] = array(
                        "id" => (int) $teamdetails["id"],
                        "team_name" => $teamdetails['team_name'],
                        "write_access" => $access_to[$i]
                    );
                    $i = $i + 1;
                }
                $total = $teams;
            } else {
                foreach ($db->teams() as $team) {

                    $teams[] = array(
                        "id" => (int) $team["id"],
                        "team_name" => $team["team_name"],
                    );
                }
                $total = $teams;
            }
            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $teams, 'total' => count($total)));
        });





$app->get('/dbmigration', function ()use ($app, $db) {
//            mysql_connect("localhost", "root", "") or die(mysql_error());
//
//            mysql_query("CREATE database IF NOT EXISTS hospice_care") or die(mysql_error());
//
//            mysql_select_db("hospice_care") or die(mysql_error());
//
//            mysql_query("CREATE TABLE IF NOT EXISTS user_team ( id INT AUTO_INCREMENT PRIMARY KEY,user_id INT(30),
// team_id INT(30))") or die(mysql_error());
//
//            mysql_query("CREATE TABLE IF NOT EXISTS users ( id INT AUTO_INCREMENT PRIMARY KEY,full_name VARCHAR(30),
// email VARCHAR(30))") or die(mysql_error());
//
//            mysql_query("CREATE TABLE IF NOT EXISTS teams ( id INT AUTO_INCREMENT PRIMARY KEY,team_name VARCHAR(30)
// )") or die(mysql_error());
            //fetch users from google via python script
            $allUsers = fetchDomainUsers();

            //split all the users list
            $users = explode(",", $allUsers);

            for ($i = 0; $i < sizeof($users); $i++) {

                $existinguser = $db->users()->where('first_name', $users[$i]);

                if (count($existinguser) == 0) {

                    $userArray = array(
                        'full_name' => $users[$i],
                        'email' => $users[$i]
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

            $email = $_REQUEST['email'];

            $users = $db->users()->select('id')->where('email', $email);

            $user_id = 0;

            foreach ($users as $user) {
                $user_id = $user['id'];
                break;
            }

            $udata = array();
            $teams = array();

            $email_ids = array();
            /** users acces */
            foreach ($db->user_to_usercalendar()->where('user_id', $user_id) as $user) {
                $user_to_teams = $db->users()->where('id', $user['access_to']);

                foreach ($user_to_teams as $user_to_team) {
                    $email_ids[] = $user_to_team['email'];
                }
            }

            $teams[] = array(
                "id" => 12,
                "team" => 'My',
                "email" => $email_ids
            );

            $user_to_teams = array();

            $tdata = $db->user_to_teamcalendar()->where('user_id', $user_id);

            foreach ($tdata as $team) {

                $email_ids = array();

                $user_ids = $db->user_team()->where('team_id', $team["team_id"]);

                foreach ($user_ids as $uid) {

                    $user_to_teams = $db->users()->where('id', $uid['user_id']);
                    foreach ($user_to_teams as $user_to_team) {
                        $email_ids[] = $user_to_team['email'];
                    }
                }

                foreach ($db->teams()->where('id', $team["team_id"]) as $t)
                    $teamname = $t['team_name'];

                $teams[] = array(
                    "id" => $team["team_id"],
                    "team" => $teamname,
                    "email" => $email_ids
                );
            }



            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('teams' => $teams, 'total' => 0));
        });

$app->get('/user/calendarcolor/:email', function($email) use ($app, $db) {

            include_once('php/dbconfig.php');
            include_once('php/functions.php');
            include_once('OAuth.php');
            require('google-api-php-client/src/Google_Client.php');
            include('google-api-php-client/src/contrib/Google_CalendarService.php');
            require('twolegged.php');
            $sfGoogleCalendar = new sfGoogleApiCalendar($email);
            $calendar = $sfGoogleCalendar->getCalendar($email);

            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array($email, $calendar->backgroundColor));
        });

$app->get('/useraccesslist/:id/:withaccessId/:action/', function ($id, $withaccessId, $action) use ($app, $db) {

            if ($action == "remove") {

                $userIds = explode(",", $withaccessId);

                $userToUser = array();

                for ($index = 0; $index < sizeof($userIds); $index++) {
                    $data = $db->user_to_usercalendar()->where('access_to', $userIds[$index])->where('user_id', $id)->delete();
                }
            } else {

                if (isset($access_value)) {

                    //print_r($id);print_r("\n");print_r($action);exit();
//                    $entry_existing = $db->user_to_usercalendar()->where('user_id', $id)->where('access_to', $action);
//
//                    if (count($entry_existing) > 0) {
//                        foreach($entry_existing as $entry){
//                        $update_array = array(
//                        
//                            "write_access" => $access_value
//                        );
//
//                        $update_record = $db->user_to_usercalendar($entry['id'])->update($update_array);
//                        
//                          }                        
//                        } else {
//                        ;
//                    }
                } else {
                    $accesstoids = explode(",", $withaccessId);

                    $userToUser = array();

                    for ($index = 0; $index < sizeof($accesstoids); $index++) {

                        if (!empty($accesstoids[$index])) {
                            $userToUser = array(
                                'user_id' => $id,
                                'access_to' => $accesstoids[$index]
                            );
                            $data = $db->user_to_usercalendar()->insert($userToUser);
                        }
                    }
                }
            }





            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $userToUser));
        });

$app->get('/userwriteaccesslist/:id/:withaccessId/:action/:access_value', function ($id, $withaccessId, $action, $access_value) use ($app, $db) {

            if ($action == "remove") {

                $userIds = explode(",", $withaccessId);

                $userToUser = array();

                for ($index = 0; $index < sizeof($userIds); $index++) {
                    $data = $db->user_to_usercalendar()->where('access_to', $userIds[$index])->where('user_id', $id)->delete();
                }
            } else {
                $userToUser = array();
                if (isset($access_value)) {
                    $entry_existing = $db->user_to_usercalendar()->where('user_id', $id)->where('access_to', $action);

                    if (count($entry_existing) > 0) {
                        foreach ($entry_existing as $existing) {
                            $update_array = array(
                                "write_access" => $access_value
                            );
                            print_r($existing['id']);
                            $update_record = $db->user_to_usercalendar[$existing['id']]->update($update_array);
                        }
                    } else {
                        ;
                    }
                } else {
                    $accesstoids = explode(",", $withaccessId);

                    $userToUser = array();

                    for ($index = 0; $index < sizeof($accesstoids); $index++) {

                        if (!empty($accesstoids[$index])) {
                            $userToUser = array(
                                'user_id' => $id,
                                'access_to' => $accesstoids[$index]
                            );
                            $data = $db->user_to_usercalendar()->insert($userToUser);
                        }
                    }
                }
            }

            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $userToUser));
        });
$app->get('/teamwriteaccesslist/:id/:withaccessId/:action/:access_value', function ($id, $withaccessId, $action, $access_value) use ($app, $db) {
            $userToUser = array();

            if (isset($access_value)) {
                $entry_existing = $db->user_to_teamcalendar()->where('user_id', $id)->where('team_id', $action);

                if (count($entry_existing) > 0) {
                    foreach ($entry_existing as $existing) {
                        $update_array = array(
                            "write_access" => $access_value
                        );

                        $update_record = $db->user_to_teamcalendar[$existing['id']]->update($update_array);
                    }
                } else {
                    
                }
            }


            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $userToUser));
        });

$app->get('/teamaccesslist/:id/:withaccessId/:action', function ($id, $withaccessId, $action) use ($app, $db) {

            if ($action == "remove") {

                $userIds = explode(",", $withaccessId);

                $userToUser = array();

                for ($index = 0; $index < sizeof($userIds); $index++) {
                    $data = $db->user_to_teamcalendar()->where('team_id', $userIds[$index])->where('user_id', $id)->delete();
                }
            } else {
                $accesstoids = explode(",", $withaccessId);

                $userToUser = array();

                for ($index = 0; $index < sizeof($accesstoids); $index++) {

                    if (!empty($accesstoids[$index])) {
                        $userToUser = array(
                            'user_id' => $id,
                            'team_id' => $accesstoids[$index]
                        );
                        $data = $db->user_to_teamcalendar()->insert($userToUser);
                    }
                }
            }





            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $userToUser));
        });

$app->post('/csvupload/', function () use ($app, $db) {

            if (file_exists("upload/" . $_FILES["file"]["name"])) {
                unlink("upload/".$_FILES["file"]["name"]);
            }

            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]); // moves the file from temp to uplod folder

            $args=array(
              'csv_file'=>"upload/" . $_FILES["file"]["name"],  
              'csv_delimiter'=>';',
              'csv_fields_num'            =>   TRUE,
              'csv_head_read'     =>   TRUE,
              'csv_head_label'            =>   TRUE,

                );
            $object_csv = new Chip_csv();
            $csv_output = $object_csv->get_read( $args );
            print_r($csv_output);exit();
            
            $app->response()->header("Content-Type", "application/json");
           // echo json_encode(array('data' => "hurray"));
        });

$app->get('/get-calendars/:email', function($email) use ($app,$db){

    error_reporting(0);
    include_once("dbconfig.php");
    include_once("functions.php");
    include_once('OAuth.php');
    require('google-api-php-client/src/Google_Client.php');
    include('google-api-php-client/src/contrib/Google_CalendarService.php');
    require("twolegged.php");

    $sfGoogleCalendar = new sfGoogleApiCalendar($email);
    $calendars = $sfGoogleCalendar->getCalendars();
    $cals = array();
    foreach ($calendars->items as $cal){
       $cals[] = array('id'                 => $cal->id,
                        'summary'           => $cal->summary,
                        'backgroundColor'   => $cal->backgroundColor);
    } 

    $app->response()->header("Content-Type", "application/json");

    echo json_encode($cals);
});

$app->get('/get-events', function() use ($app,$db){

    $email = $_GET['email'];
    $cal_id = $_GET['calendar_id'];
    $cal_color = $_GET['calendar_color'];

    error_reporting(1);
    //include_once("dbconfig.php");
    include_once("functions.php");
    include_once('OAuth.php');
    require('google-api-php-client/src/Google_Client.php');
    include('google-api-php-client/src/contrib/Google_CalendarService.php');
    require("twolegged.php");

    $data['events'][] = array();
    $sfGoogleCalendar = new sfGoogleApiCalendar($email);
     
    $calendar = $sfGoogleCalendar->getEvents($cal_id);
        
    if($calendar == null || false == $calendar) 
        $data['events'][] = array();
    else   
        $data = listCalendarByRange($calendar,$cal_id,$cal_color);
    
    $app->response()->header("Content-Type", "application/json");

    echo json_encode($data);
});

function listCalendarByRange($calendar, $cal_id, $cal_color) {
    $cnt = count($calendar['items']);
    $gmtTimezone = new DateTimeZone('IST');
    $attendes=array();
    $attendes_names=array();
    
    for ($i = 0; $i < $cnt; $i++) {

        if(!isset($calendar['items'][$i]['summary']))
            continue;

        $fullday = 0;
        
        if(isset($calendar['items'][$i]['start']['date']))
            $fullday = 0;
        
        
        $location=isset($calendar['items'][$i]['location']) ? $calendar['items'][$i]['location'] : '';
        $st = isset($calendar['items'][$i]['start']['date']) ? $calendar['items'][$i]['start']['date'] : $calendar['items'][$i]['start']['dateTime'];
        $et = isset($calendar['items'][$i]['end']['date']) ? $calendar['items'][$i]['end']['date'] : $calendar['items'][$i]['end']['dateTime'];
   
        $attendes='';
        $emails='';

        $data['events'][] = array(
                                'eid'       => $calendar['items'][$i]['id'],
                                'summary'   => $calendar['items'][$i]['summary'],
                                'start_time'=> $st,
                                'end_time'  => $et,
                                'fullday'   => $fullday,
                                'oneplus'   => 0, //more than one day event
                                'recurring' => 0, //Recurring event
                                'random'    => rand(-1, 13),
                                'editable'  => 0, //editable,
                                'location'  => $location, //location
                                'cal_id'    => $cal_id,
                                'event_color' => $cal_color      
        );
    }
   
   // print_r($data);
   return $data;
}



$app->run();

function users_not_in_team($teamid, $db, $app, $offset) {
    $userIds = array();

    $users_details = array();
    $existingusers = $db->user_team()->where("team_id", $teamid);
    if (count($existingusers) > 0) {
        foreach ($existingusers as $existinguser)
            $userIds[] = $existinguser['user_id'];
    }

    $users = $db->users()->where("NOT id", $userIds);
    $total = $users;
    if (isset($_GET['term'])) {


        foreach ($users->where('email like ?', "%" . trim($_GET['term']) . "%")->limit(20, $offset) as $user) {
            $bold = '<span style="font-weight:bold;">' . trim($_GET['term']) . '</span>';
            $users_details[] = array(
                "id" => (int) $user["id"],
                "full_name" => $user["first_name"] . " " . $user["last_name"],
                "email" => str_ireplace($_GET['term'], $bold, $user["email"]),
                "teams" => array()
            );
        }
        // $total = $users_details;
    } else {
        $total = $db->users();


        foreach ($users->limit(20, $offset) as $user) {

            $users_details[] = array(
                "id" => (int) $user["id"],
                "full_name" => $user["first_name"] . " " . $user["last_name"],
                "email" => $user["email"],
                "teams" => array()
            );
        }
    }

    $app->response()->header("Content-Type", "application/json");
    echo json_encode(array('data' => $users_details, 'total' => count($total)));
}

function searchfor($term, $db, $app, $offset) {

    $teams = array();
    $search_results = $db->users()->where('email like ?', $term . "%")->limit(30, $offset);
    if (count($search_results) > 0) {
        foreach ($search_results as $searched_name) {
            $teams = array();
            $team_ids = $db->user_team()->where('user_id', $searched_name["id"]);
            if (count($team_ids) > 0) {
                foreach ($team_ids as $team_id) {

                    $team_id_s = $db->teams()->where('id', $team_id['team_id']);

                    foreach ($team_id_s as $team_n) {

                        $teams[] = $team_n['team_name'];
                    }
                }
            } else {
                $teams = array();
            }

            $bold = '<span style="font-weight:bold;">' . $term . '</span>';
            $searched_users[] = array(
                "id" => (int) $searched_name["id"],
                "full_name" => $searched_name["first_name"] . "" . $searched_name["last_name"],
                "email" => strstr(str_ireplace($term, $bold, $searched_name["email"]), '@',true)."@",
                'mail'=>$searched_name["email"],
                "teams" => $teams
            );
        }
    } else {
        $searched_users = array(
        );
    }
    $app->response()->header("Content-Type", "application/json");
    echo json_encode(array('data' => $searched_users, 'total' => count($search_results)));
}

