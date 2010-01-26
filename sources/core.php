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
	$query    = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' AND power = '1'";
	$res      = mysql_query($query) or die ("SQL error:".mysql_error());
	$rows     = mysql_num_rows($res);
	if($res != 1){
		print "Wrong username or password";
	}else{
		print "Login lates with success,hi admin";
		setcookie('login',$password,time()+2000,'/');
	}
}

//register ->

function register($username,$password,$email,$power){
	$password = md5(sha1($password));
	$control  = "SELECT * FROM users WHERE password = '{$password}'";
	$res      = mysql_query($control) or die ("SQL error:".mysql_error());
	$rows     = mysql_num_rows($res);
	if($rows != 1){
		$query    = "INSERT INTO users ('username','password','email','power') VALUES ('$username','$password','$email','$power')";
		$res      = mysql_query($query) or die ("SQL error:".mysql_error());
		if($res){
			print "User in users with success";
		}else{
			print "Trouble registering";
		}
	}else{
		print "Username or password that is' present";
	}
}

	
?>
	
	
