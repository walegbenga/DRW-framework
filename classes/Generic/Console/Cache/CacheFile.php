<?php
declare("strict_types=1");

namespace Generic\Cache;

class CacheFile{
	private $filename;
	private $tempfilename;
	private $expiration;
	private $fp;
	
	public function __construct(string $filename, $expiration = false){
		$this->filename = $filename;
		$this->tempfilename = "$filename." . getmygid();
		$this->expiration = $expiration;
	}
	
	public function put($buffer){
		if(($this->fp = fopen($this->tempfilename, "w")) == false){
			return false;
		}
		fwrite($this->fp, $buffer);
		fclose($this->fp);
		rename($this->tempfilename, $this->filename);
		return true;
	}

	public function get(){
		if($this->expiration){
			$stat = @stat($this->filename);
			if($stat[9]){
				if(time() > $modified + $this->expiration){
					unlink($this->filename);
					return false;
				}
			}
		}
		return @file_get_contents($this->filename);
	}

	public function remove(){
		@unlink($filename);
	}
	
	public function begin(){
		if(($this->fp = fopen($this->tempfilename, “w”)) == false){
			return false;
		}
		ob_start();
	}
	public function end(){
		$buffer = ob_get_contents();
		ob_end_flush();
		if(strlen($buffer)){
			fwrite($this->fp, $buffer);
			fclose($this->fp);
			rename($this->tempfilename, $this->filename);
			return true;
		}
		else{
			flcose($this->fp);
			unlink($this->tempfilename);
			return false;
		}
	}
	
}