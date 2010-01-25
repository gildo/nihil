<?php

//login ->

function login($username,$password){
	$password = md5(sha1($password));
	$query    = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}'";
	$res      = mysql_query($query) or die ("SQL error:".mysql_error());
	$rows     = mysql_num_rows($res);
	if($res != 1){
		print "Wrong username or password";
	}else{
		print "Login lates with success";
		setcookie('login',$password,time()+2000,'/');
	}
}

//is_admin ->

function is_admin($username,$password){
	$password = md5(sha1($password));
	$query    = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' AND powere = '1'";
	$res      = mysql_query($query) or die ("SQL error:".mysql_error());
	$rows     = mysql_num_rows($res);
	if($res != 1){
		print "Wrong username or password";
	}else{
		print "Login lates with success,hi admin";
		setcookie('login',$password,time()+2000,'/');
	}
}
?>
	
	
