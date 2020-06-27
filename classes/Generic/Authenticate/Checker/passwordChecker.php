<?php
declare("strict_types=1");

namespace Generic\Authenticate\Checker;

/**
*
*/

class PasswordChecker{
	function check_credentials($name, $password){
		$dbh = new DB_Mysql_Prod();
		$cur = $dbh->execute("
			SELECT
			userid, password
			FROM
			users
			WHERE
			username = '$name'
			AND failures < 3");
		$row = $cur->fetch_assoc();
		if($row){
			if($password == $row['password']){
				return $row['userid'];
			}
			else{
				$cur = $dbh->execute("
					UPDATE
					users
					SET
					failures = failures + 1,
					last_failure = now()
					WHERE
					username = '$name'");
			}
		}
		throw new AuthException("user is not authorized");
	}
}