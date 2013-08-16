<?php
function remEntities($str) {
  return str_replace("&#8206;","", str_replace("&nbsp","",$str) );
}

function print_sms_reply ($sms_reply){
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";    
	echo "<Response>\n";
	if( !is_array($sms_reply) ){
		echo '<Sms>'.$sms_reply.'</Sms>';
	}else{
		$cnt = count($sms_reply);
		$i = 1;
		foreach($sms_reply as $line){
			$line = $line." (".$i."/".$cnt.")";
			echo '<Sms>'.$line.'</Sms>';
			$i++;
		}
	}
	echo "</Response>\n";
}

function get_query($url){
	$curl = curl_init($url);
	curl_setopt($curl,CURLOPT_HEADER,false);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	$data = curl_exec($curl);
	curl_close($curl);
	return $data;
}

function getResultFromYQL($yql_query, $env = '') {
	$yql_base_url = "http://query.yahooapis.com/v1/public/yql";
	$yql_query_url = $yql_base_url . "?q=" . urlencode($yql_query);
	$yql_query_url .= "&format=json";
	if ($env != '') {
		$yql_query_url .= '&env=' . urlencode($env);
	}
	$session = curl_init($yql_query_url);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	$json = curl_exec($session);
	curl_close($session);
	return json_decode($json);
}