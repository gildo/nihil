<?php

    ob_start();

    include('../layout/header.php');

    /* check if an user want to login and if the login is correct */
    if (isset ($_POST['login']))
    {
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        login ($user, $pass);
    }

    /* .. if not ... */
    else
    { /* here down: the ugliest login form ever */ ?>

    <h2>login</h2>
    <form method="post" action="login.php">
        <table>
        <tr><td>username ?</td>
            <td><input type="text" name="user"/></td></tr>
        <tr><td>password ?</td>
            <td><input type="password" name="pass"/></td></tr>
        <tr><td>
            <input type="submit" name="login" value="login" />
        </tr>
        </table>
    </form>

<?php
    }
?>