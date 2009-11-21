<?php

// *** MySQL Class *** //
class MySQL {
	function __construct() {
		$this->connection = @mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		if(!$this->connection_estab()) die("Unable to connect to MySQL");
		if(!@mysql_select_db(DB_NAME, $this->connection)) die("Unable to select database");
	}
	function __destruct() {
		@mysql_close($this->connection);
	}
	function connection_estab() {
		if(!$this->connection) return false;
		return true;
	}
	function query($query) {
		$this->query_result = @mysql_query($query, $this->connection) or die(mysql_error($this->connection));
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
