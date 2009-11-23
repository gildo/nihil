<?php
/*
	Copyright UserCake
	http://usercake.com
	
	Developed by: Adam Davis
*/

function sanitize($str)
{
	return strtolower(strip_tags(trim(($str))));
}

function isValidEmail($email)
{
	return preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",trim($email));
}

function minMaxRange($min, $max, $what)
{
	if(strlen(trim($what)) < $min)
	   return true;
	else if(strlen(trim($what)) > $max)
	   return true;
	else
	   return false;
}

//@ Thanks to - http://phpsec.org
function generateHash($plainText, $salt = null)
{
    if ($salt === null)
    {
        $salt = substr(md5(uniqid(rand(), true)), 0, 25);
    }
    else
    {
        $salt = substr($salt, 0, 25);
    }

    return $salt . sha1($salt . $plainText);
}

function replaceDefaultHook($str)
{
	global $websiteName,$websiteUrl,$emailDate,$default_hooks;

	return (str_replace($default_hooks,array($websiteName,$websiteUrl,$emailDate),$str));
}

function getUniqueCode($length = "")
{	
	$code = md5(uniqid(rand(), true));
	if ($length != "") return substr($code, 0, $length);
	else return $code;
}


?>