<?php
/*
------------------------------------------------------
  www.idiotminds.com
--------------------------------------------------------
*/
require_once 'config.php';
require_once 'lib/Google_Client.php';
require_once 'lib/Google_Oauth2Service.php';

$client = new Google_Client();
$client->setApplicationName("Google UserInfo PHP Starter Application");

$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(REDIRECT_URI);
$client->setApprovalPrompt(APPROVAL_PROMPT);
$client->setAccessType(ACCESS_TYPE);

$oauth2 = new Google_Oauth2Service($client);

if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['token'] = $client->getAccessToken();
  echo '<script type="text/javascript">window.close();</script>'; exit;
}

if (isset($_SESSION['token'])) {
 $client->setAccessToken($_SESSION['token']);
}

if (isset($_REQUEST['error'])) {
 echo '<script type="text/javascript">window.close();</script>'; exit;
}

if ($client->getAccessToken()) {
  $user = $oauth2->userinfo->get();

  // These fields are currently filtered through the PHP sanitize filters.
  // See http://www.php.net/manual/en/filter.filters.sanitize.php
  $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);

  // The access token may have been updated lazily.
  $_SESSION['token'] = $client->getAccessToken();

  header( 'Location: dashboard.php');

} else {
  $authUrl = $client->createAuthUrl();
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8">
    <title>Signin with Google Account</title>
<script src="js/jquery.js" type="text/javascript"></script>
<style src="css/style.css" type="text/css"></style>
<script type="text/javascript" src="js/oauthpopup.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	 $('a.login').oauthpopup({
            path: '<?php if(isset($authUrl)){echo $authUrl;}else{ echo '';}?>',
			width:650,
			height:350,
        });

		$('a.logout').googlelogout({
			redirect_url:'<?php echo $base_url; ?>logout.php'
		});

});
</script>
<script type="text/templates" id="login-forms">


</script>
</head>
<body style="background: #FAFAFA;">
    <div id="main_container">
        <div id="login-box" style="width: 300px;margin: auto;margin-top: 20%;border: 2px solid #ECE9E9;border-radius: 10px;padding-top: 20px;padding-bottom: 20px;">
		<?php if(isset($personMarkup)): ?>
		<?php print $personMarkup ?>
		<?php endif ?>
		<?php
		  if(isset($authUrl)) {
		    print "<a class='login' href='javascript:void(0);'><img alt='Signin in with Google' src='signin_google.png' style=' margin: auto; display: block; '/></a>";
		  } else {
		   print "<a class='logout' href='javascript:void(0);'>Logout</a>";
		  }
		?>
		</div>
    </div>

</body>
</html>