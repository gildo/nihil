<?php
function sanitize_vars(&$vars, $signatures, $redir_url = NULL)
{
    $tmp = array();
    
    /* doc string needed here */
    foreach ($signatures as $home => $sig) {
        if (!isset($vars [$home]) &&
        isset($sig['required']) && $sig['required'])
    {
    
        /* another doc str */
        if ($redir_url) {
            header("Location: $redir_url");
        } else {
            echo "Monkey!, parameter $name not exist - no redirection";
        }
        exit();
    }
        /* another doc */
        $tmp[$name] = $vars[$name];
        if (isset($sig['type'])) {
            settype($tmp[$name], $sig['type']);
        }

        /* doc string!!!!!!!!!! */
        if (isset($sig['function'])) {
            $tmp[$name] = $sig['function']($tmp[$name]);
        }
     }
     $vars = $tmp;
}
    $sigs = array(
        'prod_id' => array('required' => TRUE, 'type' => 'int'),
        'desc' => array('required' => TRUE, 'type' => 'string',
            'function' => 'addslashes')
    );
    
    sanitize_vars(&$_GET, $sigs,
        "http://{$_SERVER['SERVER_NAME']}/err.php?cause=vars");
?>
