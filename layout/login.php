<?php

    ob_start();

    include('../layout/header.php');

    $a = new Auth();

    if(is_logged())
    {
        echo ("You are already logged in!!!!! <br>");
        echo ("Return back! (or delete you're cookie ) ");
        die();
    }

    /* check if an user want to login and if the login is correct */
    if (isset ($_POST['login']))
    {
        $user = htmlentities($_POST['user']);
        $pass = htmlentities($_POST['pass']);
        $passa = md5(sha1($pass));
        $a->login ($user, $passa);
    }

    /* .. if not ... */
    else
    { /* here down: the ugliest login form ever */ ?>

    <h2>login</h2>
    <form method="post" action="login">
        <table>
        <tr><td>username :</td>
            <td><input type="text" name="user"/></td></tr>
        <tr><td>password :</td>
            <td><input type="password" name="pass"/></td></tr>
        <tr><td>
            <input type="submit" name="login" value="login" />
        </tr>
        </table>
    </form>

<?php
    }

    include('../layout/footer.php');

?>
