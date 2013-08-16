<?php

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
