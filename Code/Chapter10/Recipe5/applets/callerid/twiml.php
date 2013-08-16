<?php
$response = new Response();
$keys = AppletInstance::getValue('keys');
$invalid = AppletInstance::getDropZoneUrl('invalid');

$selected_item = false;

$choices = AppletInstance::getDropZoneUrl('choices[]');
$keys = AppletInstance::getDropZoneValue('keys[]');
$router_items = AppletInstance::assocKeyValueCombine($keys, $choices);

if(isset($_REQUEST['From']) && array_key_exists($_REQUEST['From'], $router_items)){
	$routed_path = $router_items[$_REQUEST['From']];
	$response->addRedirect($routed_path);
	$response->Respond();
	exit;
}else if(isset($_REQUEST['Caller']) && array_key_exists($_REQUEST['Caller'], $router_items)){
	$routed_path = $router_items[$_REQUEST['Caller']];
	$response->addRedirect($routed_path);
	$response->Respond();
	exit;
}else{
	if(!empty($invalid)){
	    $response->addRedirect($invalid);    
		$response->Respond();
		exit;
	}else{	 
		$response->Respond();
		exit;
	}		
}