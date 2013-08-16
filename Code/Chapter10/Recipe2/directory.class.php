<?php

class DirectorySearch{
	public function __construct(){
	}
	
	public function connect($response, $user){
		$name = $user->first_name . " " . $user->last_name;
		$device = $_SESSION[SESSION_KEY]['number']++;
		if(isset($user->devices[$device])){
			if(!$user->devices[$device]->is_active){
				return connect($response, $user);
			}
			$dial = $response->addDial(array('action' => current_url()));
			$dial->addNumber($user->devices[$device]->value, array('url' => site_url('twiml/whisper?name='.urlencode($name))));
		} else {
		$response->append(AudioSpeechPickerWidget::getVerbForValue($user->voicemail, new Say("Please leave a message.")));
		$response->addRecord(array(
				'transcribe' => 'true',
				'transcribeCallback' => site_url('twiml/transcribe') ));
		}
		return $response;
	}
	public function promptMenu($response, $users){
		$gather = $response->addGather();
		foreach($users as $index => $user){
			$pos = $index + 1;
			$gather->addSay("Dial $pos for {$user->first_name} {$user->last_name}");
		}
		return $response;
	}
	public function searchPrompt($response){
		unset($_SESSION[SESSION_KEY]);
		$this->addMessage($response->addGather(), 'searchPrompt', 'Please enter the first few letters of the name, followed by the pound sign.');
		return $response;
	}
	public function errorResponse($response){
		return $this->addMessage($response, 'errorMessage', 'Sorry, an error occurred.');
	}
	public function addMessage($response, $name, $fallback){
		$message = AppletInstance::getAudioSpeechPickerValue($name);
		$response->append(AudioSpeechPickerWidget::getVerbForValue($message, new Say($fallback)));
		return $response;
	}
	public function getMatches($digits){
		$indexes = array();
		$matches = array();
		$users = OpenVBX::getUsers(array('is_active' => 1));
		foreach($users as $user) {
			$fname = $user->values['first_name'];
			$lname = $user->values['last_name'];
			$fdigits = $this->stringToDigits( $fname );
			$ldigits = $this->stringToDigits( $lname );
			if( stristr($fdigits,$digits) || stristr($ldigits,$digits) ){
				$matches[] = $user;
			}
		}
		return $matches;
	}
	private function stringToDigits($str) {
		$str = strtolower($str);
		$from = 'abcdefghijklmnopqrstuvwxyz';
		$to = '22233344455566677778889999';
		return preg_replace('/[^0-9]/', '', strtr($str, $from, $to));
	}
}