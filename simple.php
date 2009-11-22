<?php
require_once 'lib/Auth.php';
require_once 'lib/sanitize.php';

$sigs = array(
    'user' => array ('required' => TRUE, 'type' => 'string',
        'function' => 'addslashes'),
    'passwd' => array ('required' => TRUE, 'type' => 'string',
        'function' => 'addslashes')
);
sanitize_vars(&$_POST, $sigs);

$a = new Auth();
$a->addUser($_POST['user'], $_POST['passwd']);

$a = new Auth();
echo $a->authUser($_POST['user'], $_POST['passwd']) ? 'OK' : 'ERROR';
?>
