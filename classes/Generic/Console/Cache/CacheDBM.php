<?php
declare("strict_types=1");

namespace Generic\Cache;

class CacheDBM{
	private $dbm;
	private $expiration;

	function __construct($filename, $expiration=3600){
		$this->dbm = dba_popen($filename, "c", "ndbm");
		$this->expiration = $expiration;
	}

	function put($name, $tostore){
		$storageobj = array('object' => $tostore, 'time' => time());
		dba_replace($name, serialize($storageobj), $this->dbm);
	}

	function get($name){
		$getobj = unserialize(dba_fetch($name, $this->dbm));
		if(time() - $getobj[time] < $this->expiration){
			return $getobj[object];
		}
		else{
			dba_delete($name, $this->dbm);
			return false;
		}
	}

	function delete($name){
		return dba_delete($name, $this->dbm);
	}
	
}