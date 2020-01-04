<?php
declare("strict_types=1");

namespace Generic;

class CentralizedAuthentication{
	function check_credentials($name, $password, $client){
		$dbh = new DB_Mysql_Prod();
		$cur = $dbh->prepare("
			SELECT
			userid
			FROM
			ss_users
			WHERE
			name = :1
			AND password = :2
			AND client = :3")->execute($name, md5($password), $client);
		$row = $cur->fetch_assoc();
		if($row){
			$userid = $row[‘userid’];
		}
		else{
			throw new SignonException("user is not authorized");
		}
		return $userid;
	}
	function check_credentialsFromCookie($userid, $server){
		$dbh = new DB_Mysql_Test();
		$cur = $dbh->prepare("
			SELECT
			userid
			FROM
			ss_users
			WHERE
			userid = :1
			AND server = :2")->execute($userid, $server);
		$row = $cur->fetch_assoc();
		if(!$row){
			throw new SignonException("user is not authorized");
		}
	}
}