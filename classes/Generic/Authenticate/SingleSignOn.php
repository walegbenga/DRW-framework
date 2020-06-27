<?php
declare("strict_types=1");

namespace Generic\Authenticate;

/**
*
*/

class SingleSignOn{
	private $cypher = 'blowfish';
	private $mode = 'cfb';
	private $key = 'choose a better key';
	private $td;
	private $glue = '|';
	private $clockSkew = 60;
	private $myversion = 1;
	private $client;
	private $authserver;
	private $userId;
	
	public $originatingUri;
	
	public function __construct(){
		// set up our mcrypt environment
		$this->td = mcrypt_module_open ($this->cypher, '', $this->mode, '');
	}

	public function generateAuthRequest(){
		$parts = [$this->myversion, time(),
			$this->client, $this->originatingUri];
		$plaintext = implode($this->glue, $parts);
		$request = $this->_encrypt($plaintext);
		header("Location: $client->server?request=$request");
	}

	public function processAuthRequest($crypttext){
		$plaintext = $this->_decrypt($crypttext);
		list($version, $time, $this->client, $this->originatingUri) =
		explode($this->glue, $plaintext);
		
		if( $version != $this->myversion){
			throw new SignonException("version mismatch");
		}
		
		if(abs(time() - $time) > $this->clockSkew){
			throw new SignonException("request token is outdated");
		}

	}

	public function generateAuthResponse(){
		$parts = array($this->myversion, time(), $this->userId);
		$plaintext = implode($this->glue, $parts);
		$request = $this->_encrypt($plaintext);
		header("Location: $this->client$this->originatingUri?response=$request");
	}

	public function processAuthResponse($crypttext){
		$plaintext = $this->_decrypt($crypttext);
		list ($version, $time, $this->userId) = explode($this->glue, $plaintext);
	
		if( $version != $this->myversion){
			throw new SignonException("version mismatch");
		}
	
		if(abs(time() - $time) > $this->clockSkew){
			throw new SignonException("response token is outdated");
		}
		return $this->userId;
	}
	
	protected function _encrypt($plaintext){
		$iv = mcrypt_create_iv (mcrypt_enc_get_iv_size ($td), MCRYPT_RAND);
		mcrypt_generic_init ($this->td, $this->key, $iv);
		$crypttext = mcrypt_generic ($this->td, $plaintext);
		mcrypt_generic_deinit ($this->td);
		
		return $iv . $crypttext;
	}
	
	protected function _decrypt($crypttext){
		$ivsize = mcrypt_get_iv_size($this->td);
		$iv = substr($crypttext, 0, $ivsize);
		$crypttext = substr($crypttext, $ivsize);
		mcrypt_generic_init ($this->td, $this->key, $iv);
		$plaintext = mdecrypt_generic ($this->td, $crypttext);
		mcrypt_generic_deinit ($this->td);
		
		return $plaintext;
	}
}