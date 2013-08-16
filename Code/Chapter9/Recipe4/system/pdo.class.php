<?php

class Db {	
	private $pdoInstance;
	private static $instance;
	private function __construct() {
		global $app;
		$dbhost = $app->option('mysql.dbhost');
		$dbname = $app->option('mysql.dbname');
		$dbuser = $app->option('mysql.dbuser');
		$dbpass = $app->option('mysql.dbpass');

		$this->pdoInstance = new PDO("mysql:host={$dbhost};dbname={$dbname}",$dbuser,$dbpass);
		$this->pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		$this->pdoInstance->exec("set names 'utf8'");
	}
	private function __clone() {}
	public static function singleton() {
		if (!isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	/* pdo functions */
	public function quote($str){
		return $this->pdoInstance->quote($str);
	}
	public function lastInsertId(){
		return $this->pdoInstance->lastInsertId();
	}	
	public function query($str){
		try {
			return $this->pdoInstance->query($str);
		} catch (PDOException $e) {
			echo "Error : <br />".$str."<br />". $e->getMessage() . "<br />".$e->getTraceAsString();
			exit;
		}
	}
	public function exec($str){
		try {
			return $this->pdoInstance->exec($str);
		} catch (PDOException $e) {
			echo "Error : <br />".$str."<br />". $e->getMessage() . "<br />".$e->getTraceAsString();
			exit;
		}
	}
   
}