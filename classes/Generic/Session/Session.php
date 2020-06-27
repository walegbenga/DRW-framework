<?php
declare("strict_types=1");

namespace Generic\Session;

class Session{
	static $dbh;
	function __construct(){
		
	}
	public function open($savePath, $sessionName){
		Session::$dbh = new PDO();
		return(true);
	}
	
	public function close(){
		return(true);
	}
	
	public function read($id){
		$result = Session::$dbh->prepare("SELECT session_data
			FROM sessions
			WHEREsession_id = :1")->execute($id);
		$row = $result->fetch_assoc();
		return $row['session_data'];
	}
	
	public function write($id, $sess_data){
		$clean_data = mysql_escape_string($sess_data);
		Session::$dbh->execute("REPLACE INTO
			sessions
			(session_id, session_data, modtime)
			VALUES('$id', '$clean_data', now())");
	}
	
	public function destroy($id){
		Session::$dbh->execute("DELETE FROM sessions
			WHERE session_id = '$id'");
		$_SESSION = array();
	}
	
	public function gc($maxlifetime){
		$ts = time() - $maxlifetime;
		Session::$dbh->execute("DELETE FROM sessions
			WHERE modtime < from_unixtimestamp($ts)");
	}
}