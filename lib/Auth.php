<?php
require_once('db.php');
class Auth {
    function Auth()
    {
        mysql_connect('DB_NAME', 'DB_USER', 'DB_PASSWORD');
        mysql_select_db('DB_NAME');
    }
    
    public function addUser($user, $passwd, $email)
    {
        $mysql = new MySQL();
        $mysql->query("
        INSERT INTO ".$table_prefix."users VALUES (
        NULL,  '".addslashes($_POST[$user])."', '".sha1($_POST[$passwd])."', '".addslashes($_POST[$email])."');
        ", $db);
    }
    
    public function authUser($user, $passwd)
    {
        $q = '
        SELECT * FROM ".$table_prefix."users
        WHERE user="'. $user. '"
            AND passwd ="'. sha1($passwd). '"
        ';
        $r = $mysql->query($q);
        
        if (mysql_num_rows($r) == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
?>
