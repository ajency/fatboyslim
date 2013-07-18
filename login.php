<?php
	if('POST' == $_SERVER['REQUEST_METHOD'])
	{
		session_start();
		session_regenerate_id (true);
		$_SESSION['user_id']= 27;  
		$_SESSION['user_name'] = 'Anuk Khurana';
		$_SESSION['user_level'] = 1;
		$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

		setcookie("user_id", $_SESSION['user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
		setcookie("user_name",$_SESSION['user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
		header("Location: dashboard.php");
	}
?>
<html>
<head>
</head>
<body>
	<form name="form1" method="post" action="login.php">
	<strong>Member Login </strong>
	Username: <input name="myusername"; type="text" id="myusername" />
	Password: <input name="mypassword" type="password" id="mypassword" />
	<input type="submit" name="Submit" value="Login" /></form>
</body>
</html>