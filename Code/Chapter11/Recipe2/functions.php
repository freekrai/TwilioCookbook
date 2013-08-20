<?php
	class TwilioMMS{
		public $sid;
		public $token;
		public  function __construct($sid,$token){
			$this->sid = $sid;
			$this->token = $token;
		}
		public function sendMessage($to,$from,$body,$murl){
			$url = "https://api.twilio.com/2010-04-01/Accounts/{$this->sid}/Messages";
			$data = array();
			$data["To"]=$to;
			$data['From']=$from;
			$data['Body']=$body;
			$data['ContentUrls']=$murl;
			$ch = curl_init();
			$timeout=5;
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
			curl_setopt($ch, CURLOPT_USERPWD, "{$this->sid}:{$this->token}");
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			$output = curl_exec($ch);
			curl_close($ch);
			
			$output = simplexml_load_string($output);
			return $output;
		}
	}
	function cleanVar($retVal,$type=''){
		switch($type){
			case 'phone':
				$retVal = preg_replace("/[^0-9]/", "", $retVal);
				break;
			case 'text':
			default:
				$retVal = urldecode($retVal);
				$retVal = preg_replace("/[^A-Za-z0-9 ,']/", "", $retVal);
				break;
		}
		return $retVal;
	}
