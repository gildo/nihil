<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>minimo &rsaquo; Installer</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="usr/style.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php 
    // Check if config.php has been created
    if (!file_exists('config.php'))
        die("<p>The file 'config.php' not exists.</p></body></html>");
    include("config.php");
    include("lib/db.php");

//Check if the db tables exists
$mysql = new MySQL();
$mysql->query("SHOW TABLES FROM ".DB_NAME." LIKE '".$table_prefix."%'");
    if(mysql_num_rows($mysql->get_result()) > 0) die("DB Tables found, Monkey!");
    if(!isset($_GET['step'])) {
?>

<form name="install" action="install.php?step=1" method="POST">
<b>Site informations</b><br />
site name:          <input type="text" name="sitename" /><br />
admin name:      <input type="text" name="user" /><br />
admin password:         <input type="password" name="pswd" /><br />
<input type="submit" name="submit" value="Submit" />
</form>


<?php
}
elseif($_GET['step'] == 1) {
	$mysql->query("
CREATE TABLE `".$table_prefix."users` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`username` VARCHAR(30) NOT NULL,
`password` CHAR(32) NOT NULL,
 PRIMARY KEY(id),
 INDEX(username, password)
) TYPE = MYISAM ;");
	$mysql->query("
CREATE TABLE `".$table_prefix."session` (
uid CHAR(32) NOT NULL,
user_id INT UNSIGNED NOT NULL,
creation_date INT UNSIGNED NOT NULL,
INDEX(uid)
) TYPE = MYISAM ;", $db);
	$mysql->query("
CREATE TABLE `".$table_prefix."pages` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`content` LONGTEXT NOT NULL
) TYPE = MYISAM ;", $db);
	$mysql->query("
CREATE TABLE `".$table_prefix."options` (
`name` VARCHAR ( 1000 ) NOT NULL ,
`value` VARCHAR ( 1000 ) NOT NULL
) TYPE = MYISAM ;", $db);
	$mysql->query("
INSERT INTO ".$table_prefix."users VALUES (
NULL,  '".addslashes($_POST['user'])."', '".sha1($_POST['pswd'])."');
", $db);
	$mysql->query("
INSERT INTO ".$table_prefix."options VALUES (
'site_name', '".addslashes($_POST['sitename'])."');
", $db);
	//Destroy the object
	$mysql = "";
	echo "Installation successful<br />";
}
?>
<br />
</p>

</body>
</html>
