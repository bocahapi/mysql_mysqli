<?php

/**
 * Copyright 2011 John H White <https://github.com/johnhwhite>
 * 
 * Implements the mysql_* functions using the mysqli oop methods. Rather than
 * rewriting a large codebase to take advantage of the mysqli functions, load
 * this using http://us3.php.net/manual/en/ini.core.php#ini.auto-prepend-file
 * and then open /etc/php.d/mysql.ini to comment out the mysql extension.
 */
 
if (!extension_loaded('mysql')) {

	class MySQL_MySQLi_Connection extends mysqli {
		private $last_result;

		function real_query($q) {
			if ($this->last_result && $this->last_result instanceof mysqli_result) $this->last_result->free();
			$r = parent::real_query($q);
			$this->last_result = $r;
			return $r;
		}
	}

	function &_mysql_get_connection($conn=false) {
		if ($conn===false) return $GLOBALS['mysqli_connection'];
		return $conn;
	}

	function &mysql_connect($host=false,$user=false,$pw=false,$dbname="") {
		$con_id = uniqid('mysqli_',true);
		if ($host===false) $host = ini_get("mysqli.default_host");
		if ($user===false) $user = ini_get("mysqli.default_user");
		if ($pw===false) $pw = ini_get("mysqli.default_pw");
		$GLOBALS[$con_id] =& new MySQL_MySQLi_Connection($host,$user,$pw,$dbname);
		$GLOBALS['mysqli_connection'] =& $GLOBALS[$con_id];
		return $GLOBALS[$con_id];
	}

	function mysql_affected_rows($conn=false) {
		return _mysql_get_connection($conn)->affected_rows;
	}

	function mysql_client_encoding($conn=false) {
		return _mysql_get_connection($conn)->character_set_name();
	}

	function mysql_close($conn=false) {
		return _mysql_get_connection($conn)->close();
	}

	function mysql_data_seek($result,$row) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		return $result->data_seek($row);
	}

	function mysql_db_name($conn=false) {
		$q = mysql_unbuffered_query('select database()',$conn);
		return mysql_result($q,0);
	}

	function mysql_dbname($conn=false) {
		$q = mysql_unbuffered_query('select database()',$conn);
		return mysql_result($q,0);
	}

	function mysql_errno($conn=false) {
		return _mysql_get_connection($conn)->errno;
	}

	function mysql_error($conn=false) {
		return _mysql_get_connection($conn)->error;
	}

	function mysql_escape_string($s,$conn=false) {
		return _mysql_get_connection($conn)->escape_string($s);
	}

	function mysql_fetch_array($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		return $result->fetch_array();
	}

	function mysql_fetch_assoc($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		return $result->fetch_assoc();
	}

	function mysql_fetch_field($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		return $result->fetch_field();
	}

	function mysql_fetch_lengths($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		return $result->lengths;
	}

	function mysql_fetch_object($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		return $result->fetch_object();
	}

	function mysql_fetch_row($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		return $result->fetch_row();
	}

	function mysql_field_flags($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		$f = $result->fetch_field_direct();
		return $f->flags;
	}

	function mysql_field_len($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		$f = $result->fetch_field_direct();
		return $f->length;
	}

	function mysql_field_name($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		$f = $result->fetch_field_direct();
		return $f->name;
	}

	function mysql_field_seek($result,$field) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		return $result->field_seek($field);
	}

	function mysql_field_table($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		$f = $result->fetch_field_direct();
		return $f->table;
	}

	function mysql_field_type($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		$f = $result->fetch_field_direct();
		return $f->type;
	}

	function mysql_fieldflags($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		$f = $result->fetch_field_direct();
		return $f->flags;
	}

	function mysql_fieldlen($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		$f = $result->fetch_field_direct();
		return $f->length;
	}

	function mysql_fieldname($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		$f = $result->fetch_field_direct();
		return $f->name;
	}

	function mysql_fieldtable($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		$f = $result->fetch_field_direct();
		return $f->table;
	}

	function mysql_fieldtype($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		$f = $result->fetch_field_direct();
		return $f->type;
	}

	function mysql_free_result($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		return $result->free();
	}

	function mysql_freeresult($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		return $result->free();
	}

	function mysql_get_client_info($conn=false) {
		return _mysql_get_connection($conn)->get_client_info;
	}

	function mysql_get_host_info($conn=false) {
		return _mysql_get_connection($conn)->host_info;
	}

	function mysql_get_proto_info($conn=false) {
		return _mysql_get_connection($conn)->protocol_version;
	}

	function mysql_get_server_info($conn=false) {
		return _mysql_get_connection($conn)->get_server_info();
	}

	function mysql_info($conn=false) {
		return _mysql_get_connection($conn)->info;
	}

	function mysql_insert_id($conn=false) {
		return _mysql_get_connection($conn)->insert_id;
	}

	function mysql_list_dbs($conn=false) {
		return mysql_query('show databases',$conn);
	}

	function mysql_list_processes($conn=false) {
		return mysql_query('show processlist',$conn);
	}

	function mysql_listdbs($conn=false) {
		return mysql_query('show databases',$conn);
	}

	function mysql_num_fields($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		return $result->field_count;
	}

	function mysql_num_rows($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		return $result->num_rows;
	}

	function mysql_numfields($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		return $result->field_count;
	}

	function mysql_numrows($result) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		return $result->num_rows;
	}

	function mysql_ping($conn=false) {
		return _mysql_get_connection($conn)->ping();
	}

	function mysql_query($q,$conn=false) {
		$db =& _mysql_get_connection($conn);
		$r = $db->real_query($q);
		if ($r===false) {
			error_log('SQL error: '.$db->error.' with '.$q);
			return false;
		} elseif ($db->field_count)
			return $db->store_result();
		return true;
	}

	function mysql_real_escape_string($s,$conn=false) {
		return _mysql_get_connection($conn)->real_escape_string($s);
	}

	function mysql_result($result,$row,$field=0) {
		if (empty($result) || !($result instanceof MySQLi_Result)) return false;
		if ($result->num_rows==1 || $result->data_seek($row)) {
			if (is_int($field)) {
				$r = mysql_fetch_row($result);
				return $r[$field];
			} elseif (strpos($field,'.')) {
				list($tb,$field) = explode('.',$field);
			}
			$r = mysql_fetch_assoc($result);
			return $r[$field];
		}
		return false;
	}

	function mysql_select_db($db,$conn=false) {
		return _mysql_get_connection($conn)->select_db($db);
	}

	function mysql_selectdb($db,$conn=false) {
		return _mysql_get_connection($conn)->select_db($db);
	}

	function mysql_set_charset($charset,$conn=false) {
		return _mysql_get_connection($conn)->set_charset($charset);
	}

	function mysql_stat($conn=false) {
		return _mysql_get_connection($conn)->stat();
	}

	function mysql_thread_id($conn=false) {
		return _mysql_get_connection($conn)->thread_id;
	}

	function mysql_unbuffered_query($q,$conn=false) {
		$db =& _mysql_get_connection($conn);
		$r = $db->real_query($q);
		if ($r===false) {
			error_log('SQL error: '.$db->error.' with '.$q);
			return false;
		} elseif ($db->field_count)
			return $db->use_result();
		return true;
	}

}

?>