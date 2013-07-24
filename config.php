<?php

/*
  ------------------------------------------------------
  www.idiotminds.com
  --------------------------------------------------------
 */
session_start();

if ($_SERVER['HTTP_HOST'] == "localhost") {
    $base_url = filter_var('http://localhost/fatboyslim/', FILTER_SANITIZE_URL);
    define('CLIENT_ID', '1082310462133.apps.googleusercontent.com');
    define('CLIENT_SECRET', 'fSQZVeztcNKPnx2qYrOxSQv3');
    define('REDIRECT_URI', 'http://localhost/fatboyslim/dashboard.php');
    define('APPROVAL_PROMPT', 'force');
    define('ACCESS_TYPE', 'offline');
} else {
    $base_url = filter_var('http://calendar.hcscsupport.com/', FILTER_SANITIZE_URL);

// Visit https://code.google.com/apis/console to generate your
// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.

    define('CLIENT_ID', '1082310462133.apps.googleusercontent.com');
    define('CLIENT_SECRET', 'fSQZVeztcNKPnx2qYrOxSQv3');
    define('REDIRECT_URI', 'http://calendar.hcscsupport.com/dashboard.php');
    define('APPROVAL_PROMPT', 'auto');
    define('ACCESS_TYPE', 'offline');



//$base_url= filter_var('http://calendar.hcscsupport.com/', FILTER_SANITIZE_URL);
//
//// Visit https://code.google.com/apis/console to generate your
//// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
//
//define('CLIENT_ID','1082310462133.apps.googleusercontent.com');
//define('CLIENT_SECRET','fSQZVeztcNKPnx2qYrOxSQv3');
//define('REDIRECT_URI','http://calendar.hcscsupport.com/dashboard.php');
//define('APPROVAL_PROMPT','auto');
//define('ACCESS_TYPE','offline');
} 

//else {
//    $base_url = filter_var('http://ajency.in/hospice/', FILTER_SANITIZE_URL);
//
//// Visit https://code.google.com/apis/console to generate your
//// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
//
//    define('CLIENT_ID', '562168324591.apps.googleusercontent.com');
//    define('CLIENT_SECRET', '82dI4px-fB0kufBQQ6wyZbND');
//    define('REDIRECT_URI', 'http://ajency.in/hospice/dashboard.php');
//    define('APPROVAL_PROMPT', 'force');
//    define('ACCESS_TYPE', 'offline');
//}


