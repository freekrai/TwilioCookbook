<h3>Choose a Twilio number to buy</h3>
<?php 	foreach($numbers->available_phone_numbers as $number){ ?>
	<form method="POST" action="<?=$uri?>/buy">
	<label><?php echo $number->friendly_name ?></label>
	<input type="hidden" name="PhoneNumber" value="<?php echo $number->phone_number ?>">
	<input type="hidden" name="action" value="buy" />
	<input type="submit" name="submit" value="BUY" />
	</form>
<?php 	}	?>
