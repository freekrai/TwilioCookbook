<?php
	header('Content-type: text/xml');
	echo '<?xml version="1.0" encoding="UTF-8" ?>';

	$dialogue = trim($_REQUEST['dialogue']);
	$voice = (int) $_REQUEST['voice'];

	if (strlen($dialogue) == 0)
	{
		$dialogue = 'Please enter some text to be spoken.';
	}

	if ($voice == 1)
	{
		$gender = 'man';
	}
	else {
		$gender = 'woman';
	}
?>
<Response>
	<Say voice="<?php echo $gender; ?>"><?php echo htmlspecialchars($dialogue); ?></Say>
</Response>
