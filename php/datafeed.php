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
    //$data['events'][]=array();
    $cnt = count($calendar['items']);
    $gmtTimezone = new DateTimeZone('IST');
    $attendes=array();
    $attendes_names=array();
    //var_dump($calendar);
    for ($i = 0; $i < $cnt; $i++) {

        if(!isset($calendar['items'][$i]['summary']))
            continue;

        $fullday = 0;
        
        if(isset($calendar['items'][$i]['start']['date']))
        	$fullday = 0;
        
        
        $location=isset($calendar['items'][$i]['location']) ? $calendar['items'][$i]['location'] : '';
        $st = isset($calendar['items'][$i]['start']['date']) ? $calendar['items'][$i]['start']['date'] : $calendar['items'][$i]['start']['dateTime'];
        $et = isset($calendar['items'][$i]['end']['date']) ? $calendar['items'][$i]['end']['date'] : $calendar['items'][$i]['end']['dateTime'];
   for($att_index=0;$att_index<sizeof($calendar['items'][$i]['attendees']);$att_index++)
   {
       
       $attendes_names[]=$calendar['items'][$i]['attendees'][$att_index]['displayName'];
    $attendes_emails[]=$calendar['items'][$i]['attendees'][$att_index]['email'];
    
    
   }
   $attendes=implode(",",$attendes_names);
   $emails=implode(",",$attendes_emails);
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
            $location, //location
            $attendes, //attends
            $emails
           
        );
    }
   
   // print_r($data);
   return $data;
}

function date3339($timestamp=0) {

    if (!$timestamp) {
        $timestamp = time();
    }
    $date = date('Y-m-d\TH:i:s', $timestamp);

    $matches = array();
    if (preg_match('/^([\-+])(\d{2})(\d{2})$/', date('O', $timestamp), $matches)) {
        $date .= $matches[1].$matches[2].':'.$matches[3];
    } else {
        $date .= 'Z';
    }
    return $date;
}

function listCalendar($email,$day, $type) {
	
    $from = date3339(strtotime('2013-02-01'));//date3339(strtotime('first day of this month'));
    $to   = date3339(strtotime('2013-02-28'));//date3339(strtotime('last day of this month'));

	$sfGoogleCalendar = new sfGoogleApiCalendar($email);
    $calendars = $sfGoogleCalendar->getCalendars();

   // $calendar = $sfGoogleCalendar->getEvents($email);
   // $data = listCalendarByRange($calendar,$data,$email);

    
    foreach ($calendars->items as $cal){
        //$sfGoogleCalendar->setDuration($from,$to);
        $calendar = $sfGoogleCalendar->getEvents($cal->id);
        
        $data = listCalendarByRange($calendar,$data,$email);
    } 


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


