<?php
error_reporting(0);
include_once("dbconfig.php");
include_once("functions.php");
include_once('../OAuth.php');
require('../google-api-php-client/src/Google_Client.php');
include('../google-api-php-client/src/contrib/Google_CalendarService.php');
require("../twolegged.php");

function addCalendar($st, $et, $sub, $ade) {
    $ret = array();
    $ret['IsSuccess'] = true;
    $ret['Msg'] = 'add success';
    $ret['Data'] = rand();
    return $ret;
}

function addDetailedCalendar($st, $et, $sub, $ade, $dscr, $loc, $color, $tz) {
    $ret = array();
    $ret['IsSuccess'] = true;
    $ret['Msg'] = 'add success';
    $ret['Data'] = rand();
    return $ret;
} 

function listCalendarByRange($calendar, $data, $email) {
    $cnt = count($calendar['items']);
    $gmtTimezone = new DateTimeZone('IST');
    //var_dump($calendar);
    for ($i = 0; $i < $cnt; $i++) {

        if(!isset($calendar['items'][$i]['summary']))
            continue;

        $fullday = 0;
        
        if(isset($calendar['items'][$i]['start']['date']))
        	$fullday = 0;
        
        $st = isset($calendar['items'][$i]['start']['date']) ? $calendar['items'][$i]['start']['date'] : $calendar['items'][$i]['start']['dateTime'];
        $et = isset($calendar['items'][$i]['end']['date']) ? $calendar['items'][$i]['end']['date'] : $calendar['items'][$i]['end']['dateTime'];
  
        $data['events'][] = array(
            rand(10000, 99999),
            $calendar['items'][$i]['summary'],
            $st,
            $et,
            $fullday,
            0, //more than one day event
            0, //Recurring event
            rand(-1, 13),
            0, //editable,
            '', //location
            '', //attends
           
        );
    }
   // print_r($data);
    return $data;
}

function listCalendar($email,$day, $type) {
		
	//$email = 'suraj@ajency.in';//anuj@ajency.in';
	
    $sfGoogleCalendar = new sfGoogleApiCalendar($email);

    $calendars = $sfGoogleCalendar->getCalendars();
    
    $data = array();

    foreach ($calendars->items as $cal){
        
        $calendar = $sfGoogleCalendar->getEvents($cal->id);
        
        if(!$calendar) continue;

        $data = listCalendarByRange($calendar,$data,$email);

    }
    
//    $data["issort"] = true;
//    $data["start"] 	= date('m/d/Y H:i', strtotime(date('m/d/Y',time())));
//    $data["end"] 	= date('m/d/Y H:i', strtotime("+30 days"));
//    $data["error"]	= null;
//exit();
    return $data;
}

function updateCalendar($id, $st, $et) {
    $ret = array();
    $ret['IsSuccess'] = true;
    $ret['Msg'] = 'Succefully';
    return $ret;
}

function updateDetailedCalendar($id, $st, $et, $sub, $ade, $dscr, $loc, $color, $tz) {
    $ret = array();
    $ret['IsSuccess'] = true;
    $ret['Msg'] = 'Succefully';
    return $ret;
}

function removeCalendar($id) {
    $ret = array();
    $ret['IsSuccess'] = true;
    $ret['Msg'] = 'Succefully';
    return $ret;
}

header('Content-type:text/javascript;charset=UTF-8');
$method = $_GET["method"];
$email  = $_GET["email"];  

switch ($method) {
    case "add":
        $ret = addCalendar($_POST["CalendarStartTime"], $_POST["CalendarEndTime"], $_POST["CalendarTitle"], $_POST["IsAllDayEvent"]);
        break;
    case "list":
        $ret = listCalendar($email,$_POST["showdate"], $_POST['viewtype']);
        break;
    case "update":
        $ret = updateCalendar($_POST["calendarId"], $_POST["CalendarStartTime"], $_POST["CalendarEndTime"]);
        break;
    case "remove":
        $ret = removeCalendar($_POST["calendarId"]);
        break;
    case "adddetails":
        $id = $_GET["id"];
        $st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
        $et = $_POST["etpartdate"] . " " . $_POST["etparttime"];
        if ($id) {
            $ret = updateDetailedCalendar($id, $st, $et, $_POST["Subject"], $_POST["IsAllDayEvent"] ? 1 : 0, $_POST["Description"], $_POST["Location"], $_POST["colorvalue"], $_POST["timezone"]);
        } else {
            $ret = addDetailedCalendar($st, $et, $_POST["Subject"], $_POST["IsAllDayEvent"] ? 1 : 0, $_POST["Description"], $_POST["Location"], $_POST["colorvalue"], $_POST["timezone"]);
        }
        break;
}
echo json_encode($ret);


