<?php 
// Set the numbers to call
$numbers = array("1234567890", "1234567891", "1234567892");
$number_index = isset($_REQUEST['number_index']) ? $_REQUEST['number_index'] : "0";
$DialCallStatus = isset($_REQUEST['DialCallStatus']) ? $_REQUEST['DialCallStatus'] : "";
 
header("content-type: text/xml"); 
 
if($DialCallStatus!="completed" && $number_index<count($numbers)){ 
?>
	<Response>
		<Dial action="call-screening.php?number_index=<?php echo $number_index+1 ?>">
			<Number url="areyouhuman.xml">
				<?php echo $numbers[$number_index] ?>
			</Number>
		</Dial>
	</Response>
<?php
} else {
?>
	<Response>
		<Hangup/>
	</Response>
<?php
}
?>