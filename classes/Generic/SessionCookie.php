<?php
/**
* Created by Gbenga Ogunbule.
* User: Gbenga Ogunbule
* Date: 10/07/2019
* Time: 14:04
*/
namespace Generic;

class SessionCookie{

	/**
	* This method takes all the same details about a user we have previously been storing in a SQL database and saves them
	* in PHP session variables. It requires these arguments:
	* • $handle  A username
	* • $pass  A matching password
	* • $name  The user’s real name
	* • $email  The user’s e-mail address
	*/
	public function createSession($handle, $pass, $name, $email){
		if(!session_start()){
			return FALSE;
		}

		$_SESSION['handle'] = $handle;
		$_SESSION['pass'] = $pass;
		$_SESSION['name'] = $name;
		$_SESSION['email'] = $email;
		$_SESSION['ipnum'] = getenv("REMOTE_ADDR");
		$_SESSION['agent'] = getenv("HTTP_USER_AGENT");

		return TRUE;
}
	
	/**
	* This method opens a previously created PHP session and returns the session variables stored in it. It does not 
	*require any arguments.
	*/
	public function openSession(){
		if(!@session_start()){
			return [FALSE];
		}
		if(!isset($_SESSION['handle'])){
			return [FALSE];
		}

		$vars = [];
		$vars[] = $_SESSION['handle'];
		$vars[] = $_SESSION['pass'];
		$vars[] = $_SESSION['name'];
		$vars[] = $_SESSION['email'];
		return [TRUE, $vars];
	}

	/**
	* This method closes a previously created and/or opened PHP session and destroys any  associated data. It does not 
	* require any arguments.
	*/
	public function closeSession(){
		$_SESSION = [];

		if(session_id() != "" || isset($_COOKIE[session_name()])){
			setcookie(session_name(),'',time()-2592000,'/');
		}

		return @session_destroy();
	}

	/**
	* This method checks whether a session appears to not be secure, and if not, it closes the session. It does not require 
	* any arguments.
	*/
	public function secureSession(){
		$ipnum=getenv("REMOTE_ADDR");
		$agent=getenv("HTTP_USER_AGENT");

		if(isset($_SESSION['ipnum'])){
			if($ipnum != $_SESSION['ipnum'] || $agent != $_SESSION['agent']){
				closeSession();
				return FALSE;
			}else{
				return TRUE;
			}
		} else {
			return FALSE;
		}
	}

	/**
	* This method sets, reads, and deletes cookies. It requires the following arguments:
	* • $action  The action to take: set, read, or delete
	* • $cookie  The name to use for the cookie
	* • $value  The value to give the cookie
	* • $expire  The number of seconds after which the cookie will expire
	* • $path  The path to the cookie on the server
	*/
	public function manageCookie($action, $cookie, $value, $expire, $path){
		switch(strtolower($action)){
			case 'set':
				if($expire){
					$expire += time();
				}
				return setcookie($cookie, $value, $expire, $path);

			case 'read':
				if(isset($_COOKIE[$cookie])){
					return$_COOKIE[$cookie];
				} else{
					return FALSE;
				}

			case 'delete':
				if(isset($_COOKIE[$cookie])){
					return setcookie($cookie, NULL, time() - 60 * 60 * 24 * 30, NULL);
				}else{
					return FALSE;
				}

				return FALSE;
		}
	}

	/**
	* This method sets a cookie in a user’s browser with which you can tell whether or not they have been blocked from usin
	* g your site. It requires the following arguments:
	* • $action The action to take
	* • $handle The handle of the user to block
	* • $expire The number of seconds after which the cookie will expire
	*/
	public blockUserByCookie($action, $handle, $expire){
	if(strtolower($action) == 'block'){
		if($_SESSION['handle'] != $handle){
			return FALSE;
		}else{
			return manageCookie('set', 'user', $handle, $expire, '/');
		}

		return manageCookie('read','user', NULL, NULL, NULL);
	}
}