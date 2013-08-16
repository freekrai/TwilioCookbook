<?php

class DataStore {
	public $token;
	public function __construct($token){
		$this->token = $token;
		$path = '_cache/';
		if( !is_dir($path) ){
			mkdir($path,0777);
		}
		if( !is_writable($path) ){
			chmod($path,0777);
		}
		return true;
	}
	public function Get($key){
		return $this->_fetch($this->token.'-'.$key);
	}
	public function Set($key,$val,$ttl=6000){
		return $this->_store($this->token.'-'.$key,$val,$ttl);
	}
	public function Delete($key){
		return $this->_nuke($this->token.'-'.$key);
	}
	private function _getFileName($key) {
		return '_cache/' . ($key).'.store';
	}
	private function _store($key,$data,$ttl) {
		$h = fopen($this->_getFileName($key),'a+');
		if (!$h) throw new Exception('Could not write to cache');
		flock($h,LOCK_EX);
		fseek($h,0);
		ftruncate($h,0);
		$data = serialize(array(time()+$ttl,$data));
		if (fwrite($h,$data)===false) {
			throw new Exception('Could not write to cache');
		}
		fclose($h);
	}
	private function _fetch($key) {
		$filename = $this->_getFileName($key);
		if (!file_exists($filename)) return false;
		$h = fopen($filename,'r');
		if (!$h) return false;
		flock($h,LOCK_SH);
		$data = file_get_contents($filename);
		fclose($h);
		$data = @unserialize($data);
		if (!$data) {
			unlink($filename);
			return false;
		}
		if (time() > $data[0]) {
			unlink($filename);
			return false;
		}
		return $data[1];
	}
	private function _nuke( $key ) {
		$filename = $this->_getFileName($key);
		if (file_exists($filename)) {
			return unlink($filename);
		} else {
			return false;
		}
	}
}