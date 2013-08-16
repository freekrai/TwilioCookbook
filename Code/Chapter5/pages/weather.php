<?php

	$location = whereami( $from );
	$results = weather( $location->woeid );
	$forecast = $results->channel->item->forecast;
	$today = $forecast[0];
	$tomorrow = $forecast[1];
	$reply = array();
	$reply[] = "Current Conditions: ".$today->text."\nHigh: ".$today->high.", Low: ".$today->low;
	$reply[] = "Tomorrow: ".$tomorrow->text."\nHigh: ".$tomorrow->high.", Low: ".$tomorrow->low;
	print_sms_reply( $reply );


function whereami($location){
	$yql = 'select * from geo.places where text="'.$location.'"';
	$result = getResultFromYQL( $yql );
	return $result->query->results->place;
}
function weather($woeid){
	$yql = 'select * from weather.forecast where woeid='.$woeid;
	$result = getResultFromYQL( $yql );
	return $result->query->results;
}
?>