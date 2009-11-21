<?php
if (isset($UNCONFIGURED))  {
	die ("Monkey!, read first your config.php");
}
if (file_exists('install.php'))
    die("<p>Monkey!, the file 'install.php' exists. Please read the README file.</p></body></html>");
?>
