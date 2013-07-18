<?php

/**
 * Depends on oauth-php library
 * @link http://code.google.com/p/oauth-php/
 * svn co http://oauth-php.googlecode.com/svn/trunk/library/
 */
abstract class sfGoogleApi {

    protected $developerKey;
    protected $consumerKey;
    protected $consumerSecret;
    protected $requestorId;
    protected $consumer;
    protected $parameters;

    public function __construct($requestId) {

        $this->requestorId = $requestId;

        # Setup Consumer
        $this->developerKey = 'AIzaSyCYRYhj5ZK23-YjPjq6El7r3dIUxxKGE6c';
        $this->consumerKey = 'ajency.in';
        $this->consumerSecret = 'dPGErANi0Y/NBLyctRjKOESQ';

        $this->consumer = new OAuthConsumer($this->consumerKey, $this->consumerSecret, NULL);
        $this->parameters = array(
            'xoauth_requestor_id' => $this->requestorId,
            'key' => $this->developerKey,
        );
    }

    public function getRequestorId() {

        return $this->requestorId;
    }

    /**
     * Makes an HTTP request to the specified URL
     * @param string $http_method The HTTP method (GET, POST, PUT, DELETE)
     * @param string $url Full URL of the resource to access
     * @param string $auth_header (optional) Authorization header
     * @param string $postData (optional) POST/PUT request body
     * @return string Response body from the server
     */
    protected function send_request($http_method, $url, $auth_header = null, $postData = null, $extra_headers = array()) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        $headers = array();

        if ($auth_header) {
            $headers = array_merge($headers, array($auth_header));
        }

        if ($extra_headers) {
            $headers = array_merge($headers, $extra_headers);
        }

        switch ($http_method) {
            case 'GET':
                break;
            case 'POST':
                if (!isset($extra_headers['content-type'])) {
                    $headers[] = 'Content-Type: application/json; charset=UTF-8';
                } else {
                    $headers[] = $extra_headers['content-type'];
                }

                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
                break;
            case 'PUT':
                $headers[] = 'Content-Type: application/atom-xml';
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $http_method);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
                break;
            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $http_method);
                break;
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_VERBOSE, true);

        $response = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (!$response) {
            $response = curl_error($curl);
        }

        curl_close($curl);
        return $response;
    }

    /**
     * Joins key:value pairs by inner_glue and each pair together by outer_glue
     * @param string $inner_glue The HTTP method (GET, POST, PUT, DELETE)
     * @param string $outer_glue Full URL of the resource to access
     * @param array $array Associative array of query parameters
     * @return string Urlencoded string of query parameters
     */
    protected function implode_assoc($inner_glue, $outer_glue, $array) {
        $output = array();
        foreach ($array as $key => $item) {
            $output[] = $key . $inner_glue . urlencode($item);
        }
        return implode($outer_glue, $output);
    }

}

class sfGoogleApiCalendar extends sfGoogleApi {

    /**
     * Creates a new calendar in Google
     * @param string $title
     * @param string $summary
     * @param boolean $selected
     * @return Zend_Gdata_Calendar_ListEntry
     */
    public function createCalendar($summary, $description, $colorId = 1, $selected = true) {

        $base_feed = 'https://www.googleapis.com/calendar/v3/calendars';

        $request = OAuthRequest::from_consumer_and_token($this->consumer, NULL, 'POST', $base_feed, $this->parameters);
        $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $this->consumer, null);

        $data = json_encode(array(
            'summary' => $summary,
            'description' => $description,
            'colorId' => $colorId,
            'selected' => true
        ));

        // Make signed OAuth request to the Contacts API server
        $url = $base_feed . '?' . $this->implode_assoc('=', '&', $this->parameters);
        $response = $this->send_request($request->get_normalized_http_method(), $url, $request->to_header(), $data);

        $object = json_decode($response);

        if (isset($object->error)) {
            return false;
        }

        return $object;
    }

    /**
     * Returns all calendars for a user
     * @return array[stdClass] An array of all the Calendars
     */
    public function getCalendars() {

        $base_feed = 'https://www.googleapis.com/calendar/v3/users/me/calendarList';
        $request = OAuthRequest::from_consumer_and_token($this->consumer, NULL, 'GET', $base_feed, $this->parameters);
        $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $this->consumer, null);

        // Make signed OAuth request to the Contacts API server
        $url = $base_feed . '?' . $this->implode_assoc('=', '&', $this->parameters);

        $response = $this->send_request($request->get_normalized_http_method(), $url, $request->to_header());

        $object = json_decode($response);

        if (isset($object->error)) {
            return false;
        }

        return $object;
    }

    /**
     * Gets a specific calendar.
     * @param string $calendarId
     * @return stdClass|false The Calendar object
     */
    public function getCalendar($calendarId) {

        $base_feed = 'https://www.googleapis.com/calendar/v3/users/me/calendarList/';

        # Get specific calendar
        $base_feed .= $calendarId;

        $request = OAuthRequest::from_consumer_and_token($this->consumer, NULL, 'GET', $base_feed, $this->parameters);
        $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $this->consumer, null);

        // Make signed OAuth request to the Contacts API server
        $url = $base_feed . '?' . $this->implode_assoc('=', '&', $this->parameters);

        $response = $this->send_request($request->get_normalized_http_method(), $url, $request->to_header());

        $object = json_decode($response);
        print_r($object);
        exit();
        if (isset($object->error)) {
            return false;
        }

        return $object;
    }

    /**
     * Inserts a new event into the Calendar
     * @param stdClass $event
     * @param string $calendarId
     */
    public function insertEvent($event, $calendarId) {

        $base_feed = 'https://www.googleapis.com/calendar/v3/calendars/primary/events';

        if ($calendarId) {
            $base_feed = str_replace('primary', $calendarId, $base_feed);
        }

        $request = OAuthRequest::from_consumer_and_token($this->consumer, NULL, 'POST', $base_feed, $this->parameters);
        $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $this->consumer, null);

        $data = json_encode($event);

        // Make signed OAuth request to the Contacts API server
        $url = $base_feed . '?' . $this->implode_assoc('=', '&', $this->parameters);
        $response = $this->send_request($request->get_normalized_http_method(), $url, $request->to_header(), $data);
        print_r($response);
        exit();
        $object = json_decode($response);

        if (isset($object->error)) {
            return false;
        }

        return $object;
    }

    /**
     * Executes a batch request to the Google Calendar v2.1
     * @param string $calendarId
     * @param string $batch XML Batch request
     */
    public function executeBatch($calendarId, $batch) {
        $base_feed = 'https://www.google.com/calendar/feeds/' . $calendarId . '/private/full/batch';

        $request = OAuthRequest::from_consumer_and_token($this->consumer, NULL, 'POST', $base_feed, $this->parameters);
        $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $this->consumer, null);

        // Make signed OAuth request to the Contacts API server
        $url = $base_feed . '?' . $this->implode_assoc('=', '&', $this->parameters);
        $response = $this->send_request($request->get_normalized_http_method(), $url, $request->to_header(), $batch, array('Gdata-Version: 2.1'));
    }

    function getEvents($calendarId) {
        $base_feed = 'https://www.googleapis.com/calendar/v3/calendars/'.$calendarId.'/events';

        $request = OAuthRequest::from_consumer_and_token($this->consumer, NULL, 'GET', $base_feed, $this->parameters);
        $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $this->consumer, null);

        // Make signed OAuth request to the Contacts API server
        $url = $base_feed . '?' . $this->implode_assoc('=', '&', $this->parameters);
        $response = $this->send_request($request->get_normalized_http_method(), $url, $request->to_header());
       $object = json_decode($response,TRUE);

        if (isset($object->error)) {
            return false;
        }

        return $object;
    }

    
    function getUsers()
    {
      $base_feed = 'https://apps-apis.google.com/a/feeds/user/#readonly';

        $request = OAuthRequest::from_consumer_and_token($this->consumer, NULL, 'POST', $base_feed, $this->parameters);
        $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $this->consumer, null);

        // Make signed OAuth request to the Contacts API server
        $url = $base_feed . '?' . $this->implode_assoc('=', '&', $this->parameters);
        $response = $this->send_request($request->get_normalized_http_method(), $url, $request->to_header());
       $object = json_decode($response);

        if (isset($object->error)) {
            return false;
        }

        return $object;  
    }
}

/**
 * Example Use
 */
//require('OAuth.php');
//require('google-api-php-client/src/Google_Client.php');
//include('google-api-php-client/src/contrib/Google_CalendarService.php');
//$event = new Google_Event();
//$event->setSummary('Appointment');
//$event->setLocation('Somewhere');
//$start = new Google_EventDateTime();
//$start->setDateTime('2011-06-03T10:00:00.000-07:00');
//$event->setStart($start);
//$end = new Google_EventDateTime();
//$end->setDateTime('2011-06-03T10:25:00.000-07:00');
//$event->setEnd($end);

//$sfGoogleCalendar = new sfGoogleApiCalendar('avanti@ajency.in');
//$calendar = $sfGoogleCalendar->getEvents('ajency.in_opmps6n2jkeo2keh16v6nj8nkc@group.calendar.google.com');
////$sfGoogleCalendar->getCalendars();
//exit();
//
//$events=array();
//
//for($i=0;$i<20;$i++)
//{
//    
//    $events[]=array(
//        $calendar['items'][$i]['summary'],
//        $calendar['items'][$i]['location'],
//        $calendar['items'][$i]['start']['dateTime'],
//        $calendar['items'][$i]['end']['dateTime']
//    );
//    
//    
//}
// 
//    echo json_encode(array('Events' => $events, 'error' => ""));
//
//
//
////$contacts=$sfGoogleCalendar->getUsers();
//
//exit();
