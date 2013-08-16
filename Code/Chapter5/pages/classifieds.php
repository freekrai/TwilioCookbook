<?php
$results = classifieds( $_POST['FromCity'], $keywords );
$cnt = count( $results->item );
$i = 1;
$reply = array();
foreach($results->item as $item){
	$item->title = $item->title[0];
	$item->title = str_replace(" & "," and ",$item->title);
    $msg = $item->title."\n".$item->link;
    $reply[] = $msg;
    $i++;
	if( $i == 10)	break;			
}
print_sms_reply( $reply );

function classifieds( $location, $query ){
	$yelpql = "USE 'https://raw.github.com/yql/yql-tables/master/craigslist/craigslist.search.xml' as craiglist.search;select * from craiglist.search where location='".$location."' and type="sss" and query='".$query."'";
	$result = getResultFromYQL( $yelpql );
	return $result->query->results;
}
?>