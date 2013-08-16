<?php
class Test{
	protected $callSid;
	protected $plugin;
	public function __construct($plugin){
		$this->setPlugin($plugin);
		$this->getCI()->load->helper('form');
		$this->getCI()->load->helper('url');
	}
	public function callFlow($flow){
		$twiml = new Response();
		$twiml->addPause();
		$twiml->addRedirect( site_url('twiml/applet/voice/' . $flow .'/start') );
		$this->startClientCall($twiml);
	}
	protected function Echo($twiml){
		return "http://twimlets.com/echo?Twiml=" . $twiml->asURL(true);
	}
	protected function attemptRedirect($twiml){
		if( !$this->getCallSid() ){
			return false;
		}
		$response = $this->getTwilio()->request("Accounts/".$this->getCI()->twilio_sid."/Calls/" . $this->getCallSid(), "GET");
		if( $response->IsError ){
			return false;
		}
		if( $response->ResponseXml->Call->Status != "in-progress" ){
			return false;
		}
		$response = $this->getTwilio()->request("Accounts/".$this->getCI()->twilio_sid."/Calls/" . $this->getCallSid(), "POST",array("Url" => $this->Echo($twiml)));
		if( $response->IsError ){
			return false;
		}
		if( $response->ResponseXml->Call->Status != "in-progress" ){
			return false;
		}
		return true;
	}
	protected function startClientCall($twiml){
		if( $this->attemptRedirect($twiml) ){
			return;
		}
		$response = $this->getTwilio()->request(
			"Accounts/".$this->getCI()->twilio_sid."/Calls",
			"POST",
			array("Caller" => $this->getClient(),
				"To" => 	$this->getClient(),
				"Url" => $this->Echo($twiml)
			)
		);
		if( $response->IsError ){
			throw new Exception('error starting call');
		}
		$this->callSid = (string) $response->ResponseXml->Call->Sid;
	}
	public function getClient(){
		$client = false;
		foreach(OpenVBX::getCurrentUser()->devices as $device){
			if( 'client:' == substr($device->value, 0, strlen('client:')) ){
				$client = $device->value;
				break;
			}
		}
		if(!$client){
			throw new Exception('could not find client');
		}
		return $client;
	}
	public function getFlows(){
		$flows = array();
		foreach(OpenVBX::getFlows() as $flow){
			$flows[ $flow->values['id'] ] = $flow->values['name'];
		}
		return $flows;
	}
	public function setCallSid($sid){
		$this->callSid = $sid;
	}
	public function getCallSid(){
		return $this->callSid;
	}
	public function getPluginInfo($key){
		$info = $this->getPlugin()->getInfo(); 
		return $info[$key];
	}
	public function getPlugin (){
		return $this->plugin;
	}
	public function setPlugin (Plugin $plugin){
		$this->plugin = $plugin;
	}
	public function getCI (){
		if( empty($this->ci) ){
			$this->setCI(CI_Base::get_instance());
		}
		return $this->ci;
	}
	public function setCI (CI_Base $ci){
		$this->ci = $ci;
	}
	public function getTwilio (){
		if( empty($this->twilio) ){
			$this->setTwilio(	new TwilioRestClient($this->getCI()->twilio_sid, $this->getCI()->twilio_token) );
		}
		return $this->twilio;
	}
	public function setTwilio ($twilio){
		$this->twilio = $twilio;
	}
}