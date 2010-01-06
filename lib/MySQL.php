<?php

// *** MySQL Class *** //
class MySQL {

    function connect()
	{
		mysql_connect(host, user, pass);
		mysql_select_db(db);
	}
	
	function __destruct()
	{
		@mysql_close($this->connection);
	}
	
	function connection_estab() {
		if(!$this->connection) return false;
		return true;
	}
	
	function query($sql) {
        $sql = mysql_query($sql) or die (mysql_error());
        return $sql;
	}
	
	function get_result() {
		return $this->query_result;
	}
	
	function free_result() {
		return mysql_free_result($this->query_result);
	}
	
	function affected_rows() {
		return mysql_affected_rows($this->connection);
	}
}
?>
