<?php


// Connects to your Database 
mysql_connect("localhost", "root", "") or die(mysql_error());

mysql_query("CREATE database IF NOT EXISTS hospice_care") or die(mysql_error());

mysql_select_db("hospice_care") or die(mysql_error());
mysql_query("CREATE TABLE IF NOT EXISTS user_team ( id INT AUTO_INCREMENT PRIMARY KEY,user_id INT(30), 
 team_id INT(30))") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS users ( id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(30), 
 email_id VARCHAR(30))") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS teams ( id INT AUTO_INCREMENT PRIMARY KEY,team_name VARCHAR(30) 
 )") or die(mysql_error());


$allUsers = fetchDomainUsers();

//split all the users list 
$users = explode(",", $allUsers);
for ($i = 0; $i < sizeof($users); $i++) {
    
    $email=$users[$i] . '@ajency.in';
    mysql_query("INSERT INTO users (name,email_id)
VALUES ('" . $users[$i] . "','" . $email . "')");
}



print("User imported");
?> 

