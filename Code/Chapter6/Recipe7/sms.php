<?php
	$people = array(
		"+14158675309"=>"Curious George",
		"+14158675310"=>"Boots",
		"+14158675311"=>"Virgil"
	);
	if(!$name = $people[$_REQUEST['From']]) {
		$name = "Monkey";
	}
	header("content-type: text/xml");
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Say>Hello <?php echo $name ?>.</Say>
    <Sms><?php echo $name ?>, thanks for the call!</Sms>
</Response>