<?php

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
    $cnt = 20;
    $gmtTimezone = new DateTimeZone('IST');
    for ($i = 0; $i < $cnt; $i++) {

        if(!isset($calendar['items'][$i]['summary']))
            continue;

        if (rand(0, 10) > 8) {
            $alld = 1;
        } else {
            $alld = 0;
        }
        $st = $calendar['items'][$i]['start']['date'];
        $et = $calendar['items'][$i]['end']['date'];

        /*
        $data['events'][] = array(
            'id '       => rand(10000, 99999),
            'summary'   => $calendar['items'][$i]['summary'],
            'start'     => php2JsTime(strtotime($st)),
            'end'       => php2JsTime(strtotime($et)),
            'assigned'  => $email
        );
        */
        $data['events'][] = array(
            rand(10000, 99999),
            $calendar['items'][$i]['summary'],
            php2JsTime(strtotime($st)),
            php2JsTime(strtotime($et)),
            $email
        );
    }
    return $data;
}

function listCalendar($email,$day, $type) {
    $sfGoogleCalendar = new sfGoogleApiCalendar($email);

    $calendars = $sfGoogleCalendar->getCalendars();
    
    $data = array();

    foreach ($calendars->items as $cal){
        
        $calendar = $sfGoogleCalendar->getEvents($cal->id);
        
        if(!$calendar) continue;
        
        switch ($type) {
            case "month":
                $st = mktime(0, 0, 0, date("m", $sTime), 1, date("Y", $sTime));
                $et = mktime(0, 0, -1, date("m", $eTime) + 1, 1, date("Y", $eTime));
                $cnt = 50;
                break;
            case "week":
               $phpTime = js2PhpTime($day);
                //suppose first day of a week is monday 
                $monday = date("d", $phpTime) - date('N', $phpTime) + 1;
                $st = mktime(0, 0, 0, date("m", $phpTime), $monday, date("Y", $phpTime));
                $et = mktime(0, 0, -1, date("m", $phpTime), $monday + 7, date("Y", $phpTime));
                $cnt = 20;
                break;
            case "day":
                $phpTime = js2PhpTime($day);
                $st = mktime(0, 0, 0, date("m", $phpTime), date("d", $phpTime), date("Y", $phpTime));
                $et = mktime(0, 0, -1, date("m", $phpTime), date("d", $phpTime) + 1, date("Y", $phpTime));
                $cnt = 5;
                break;
        }

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


