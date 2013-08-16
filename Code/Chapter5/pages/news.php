<?php
	$results = news( );
	$i = 1;
	$reply = array();
	foreach($results->item as $item){
		$msg = $item->title;
		$reply[] = $msg;
	}
	print_sms_reply( $reply );

	function news( ){
		$yelpql = 'select title from rss where url="http://rss.news.yahoo.com/rss/topstories" LIMIT 10';
		$result = getResultFromYQL( $yelpql );
		return $result->query->results;
	}
?>