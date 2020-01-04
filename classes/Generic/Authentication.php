<?php
declare(strict_types=1);

/**
 * Created by Gbenga Ogunbule.
 * User: Gbenga Ogunbule
 * Date: 24/12/2018
 * Time: 16:59
 */

namespace Generic;
class Authentication {
    private $users;
    private $usernameColumn;
    private $passwordColumn;
    #private $name;

    public function __construct(DatabaseTable $users, $usernameColumn, $passwordColumn) {
        session_start();
        $this->users = $users;
        $this->usernameColumn = $usernameColumn;
        $this->passwordColumn = $passwordColumn;
        #$this->name;
    }

    public function login($username, $password) {
        $user = $this->users->find($this->usernameColumn, strtolower($username));

        if (!empty($user) && password_verify($password, $user[0]->{$this->passwordColumn})) {
            session_regenerate_id();
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $user[0]->{$this->passwordColumn};
			
            return true;
        }
        else {
            return false;
        }
    }

    public function isLoggedIn() {
        if (empty($_SESSION['username'])) {
            return false;
        }
        
        $user = $this->users->find($this->usernameColumn, strtolower($_SESSION['username']));

        if (!empty($user) && $user[0]->{$this->passwordColumn} === $_SESSION['password']) {
            return true;
        }
        else {
            return false;
        }
    }
    
    public function getUser() {
        if ($this->isLoggedIn()) {
            $user = $this->users->find($this->usernameColumn, strtolower($_SESSION['username']));
            $userId = '';
            foreach ($user as $u) {
                if($u->id){
                    $userId = $u->id;
                }
            }
           /* $updateLastActivity = [
                'id' => $userId,
                'lastActivity' => $_SESSION['lastActivity']
            ];*/
		
            return $this->users->find($this->usernameColumn, strtolower($_SESSION['username']))[0];
        }
        else {
            return false;
        }
    }

    public function setSession($time){
        if(isset($_SESSION[$this->name])){
        
            $this->name = $_SESSION[$this->name];
        
        }elseif (isset($_COOKIE[$this->name])) {
            $this->name = $_COOKIE[$this->name];
            $_SESSION[$this->name] = $this->name;
            // Regenerate cookie for valid days you specify eg 604800(7days)
            setcookie('$this->name', $this->name, time() + $time);
        }else{
            //Generate cart_id and save it to $name, the session and a cookie(on subsequent requests $name will be populated from the session)

            $this->name = md5(uniqid(rand(), true));

            //Store cart_id in the session
            $_SESSION[$this->name] = $this->name;

            setcookie('$this->name', $this->name, time() + $time);
        }
    }

    public function getSession(){
        //Ensure we have a session for the current visitor
        if (!isset($this->name)) {
            setSession();
        }
    }
}