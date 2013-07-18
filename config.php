<?php
/*
------------------------------------------------------
  www.idiotminds.com
--------------------------------------------------------
*/
session_start();

$base_url= filter_var('http://localhost/fatboyslim/', FILTER_SANITIZE_URL);

// Visit https://code.google.com/apis/console to generate your
// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.

define('CLIENT_ID','1082310462133.apps.googleusercontent.com');
define('CLIENT_SECRET','fSQZVeztcNKPnx2qYrOxSQv3');
define('REDIRECT_URI','http://localhost/fatboyslim/dashboard.php');
define('APPROVAL_PROMPT','auto');
define('ACCESS_TYPE','offline');