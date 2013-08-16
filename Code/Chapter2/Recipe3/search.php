<?php
	include 'Services/Twilio.php';
	include("config.php");
	$client = new Services_Twilio($accountsid, $authtoken);

	$SearchParams = array();
	$SearchParams['InPostalCode'] = !empty($_POST['postal_code']) ? trim($_POST['postal_code']) : '';
	$SearchParams['NearNumber'] = !empty($_POST['near_number']) ? trim($_POST['near_number']) : '';
	$SearchParams['Contains'] = !empty($_POST['contains'])? trim($_POST['contains']) : '' ;
	try {
		$numbers = $client->account->available_phone_numbers->getList('US', 'Local', $SearchParams);
		if(empty($numbers)) {
			$err = urlencode("We didn't find any phone numbers by that search");
			header("Location: buy-phone-number.php?msg=$err");
			exit(0);
		}
	} catch (Exception $e) {
		$err = urlencode("Error processing search: {$e->getMessage()}");
		header("Location: buy-phone-number.php?msg=$err");
		exit(0);
	}
?>
	<h3>Choose a Twilio number to buy</h3>
	<?php foreach($numbers->available_phone_numbers as $number){ ?>
	<form method="POST" action="buy.php">
	<label><?php echo $number->friendly_name ?></label>
	<input type="hidden" name="PhoneNumber" value="<?php echo $number->phone_number ?>">
	<input type="hidden" name="action" value="buy" />
	<input type="submit" name="submit" value="BUY" />
	</form>
	<?php } ?>