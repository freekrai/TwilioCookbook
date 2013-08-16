<?php
	$results = find( $from, $keywords );
	$cnt = count( $results->businesses );
	$i = 1;
	$reply = array();
	foreach($results->businesses as $business){
		$business->name = str_replace(" & "," and ",$business->name);
	    $msg = $business->name."\n".$business->address1."\n".$business->city ." ".$business->state .", ".$business->zip;
	    $reply[] = $msg;
	    $i++;
	}
	print_sms_reply( $reply );


function find( $location, $query ){
	$yelpql = "use 'http://github.com/spullara/yql-tables/raw/master/yelp/yelp.review.search.xml' as yelp; select * from yelp where term='".$query."' and location='".$location."' and ywsid='AMP_5mIt_VCZiw7xYK0DJw'";
	$result = getResultFromYQL( $yelpql );
	return $result->query->results;
}
?>