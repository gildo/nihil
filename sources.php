    	<script type="text/javascript" src="lib/SyntaxHighlighter/scripts/shCore.js"></script>
    	<script type="text/javascript" src="lib/SyntaxHighlighter/scripts/shBrushBash.js"></script>
    	<script type="text/javascript" src="lib/SyntaxHighlighter/scripts/shBrushCpp.js"></script>
    	<script type="text/javascript" src="lib/SyntaxHighlighter/scripts/shBrushCSharp.js"></script>
    	<script type="text/javascript" src="lib/SyntaxHighlighter/scripts/shBrushCss.js"></script>
    	<script type="text/javascript" src="lib/SyntaxHighlighter/scripts/shBrushDelphi.js"></script>
    	<script type="text/javascript" src="lib/SyntaxHighlighter/scripts/shBrushDiff.js"></script>
    	<script type="text/javascript" src="lib/SyntaxHighlighter/scripts/shBrushGroovy.js"></script>
    	<script type="text/javascript" src="lib/SyntaxHighlighter/scripts/shBrushJava.js"></script>
    	<script type="text/javascript" src="lib/SyntaxHighlighter/scripts/shBrushJScript.js"></script>
    	<script type="text/javascript" src="lib/SyntaxHighlighter/scripts/shBrushPhp.js"></script>
    	<script type="text/javascript" src="lib/SyntaxHighlighter/scripts/shBrushPlain.js"></script>
    	<script type="text/javascript" src="lib/SyntaxHighlighter/scripts/shBrushPython.js"></script>
    	<script type="text/javascript" src="lib/SyntaxHighlighter/scripts/shBrushRuby.js"></script>
    	<script type="text/javascript" src="lib/SyntaxHighlighter/scripts/shBrushScala.js"></script>
    	<script type="text/javascript" src="lib/SyntaxHighlighter/scripts/shBrushSql.js"></script>
    	<script type="text/javascript" src="lib/SyntaxHighlighter/scripts/shBrushVb.js"></script>
    	<script type="text/javascript" src="lib/SyntaxHighlighter/scripts/shBrushXml.js"></script>
    	<link type="text/css" rel="stylesheet" href="lib/SyntaxHighlighter/styles/shCore.css"/>
    	<link type="text/css" rel="stylesheet" href="lib/SyntaxHighlighter/styles/shThemeDarkBlood.css"/>
    	<script type="text/javascript">
    		SyntaxHighlighter.config.clipboardSwf = 'lib/SyntaxHighlighter/scripts/clipboard.swf';
    		SyntaxHighlighter.all();
    	</script>
<?php

    error_reporting(0);
    require_once('layout/header.php');
    $query = "SELECT * FROM `sources`";
    $ris = mysql_query ($query) or die ("Errore nell'esecuzione della query");
    $data = mysql_fetch_array (mysql_query ($query), MYSQL_ASSOC);
    
?>

    <table><tr></br><td>Script</td></br><td>Language</td></br></tr></br>
<?php
    if (admin_exists ())
    {
       	while ($data = mysql_fetch_array ($ris , MYSQL_ASSOC))
        {   	
    	if (is_logged () && login (mysql_real_escape_string ($_COOKIE ['_user']),
    	mysql_real_escape_string ($_COOKIE ['_pass'])))
 
		    print "<td><a href = 'source-{$data ['id']}'>{$data ['name']}</a>
		    		    \n<td>{$data ['language']}</td>\n<td><a href = 'admin.php?mode=delete&id={$data ['id']}'>rm</a></td>
		    <br>\n<td><a href = 'admin.php?mode=edit&id={$data ['id']}'>edit</a></td>\n</tr>";
	    else
		    print "<tr>\n<td><a href = 'source-{$data ['id']}'>{$data ['name']}</a></td>\n<td>{$data ['language']}</td>\n</tr>";
}
    }
 
 
    $mode = $_GET ['mode'];
    switch ($mode)
    {

    	case "show":
        	if (isset ($_GET ['id']))
        	{
        		$id = intval ($_GET ['id']);
        		if (!exists ($id))
        			header ("Location: index.php");
        		$query = "SELECT * FROM `sources` WHERE `id` = '{$id}'";
        		$row = mysql_fetch_array (mysql_query ($query) , MYSQL_ASSOC);
        		print "Author: " . $row ['name'] . "<br>";
        		print "Description: " . $row ['description'] . "<br>";
        		print "Language: " . $row ['language'] . "<br><br><br>";
        		print ("<pre class='brush:". $row ['language'] .";'>" . $row ['source'] . "</pre><br><br><br>");
        	}
        	break;
        	
        	}
     
        
?>
   </table> </div>
    
<?php

    require_once('themes/footer.php');
    
?>
