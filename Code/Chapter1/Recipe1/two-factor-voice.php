<?php
	session_start();
	include 'Services/Twilio.php';
	include 'config.php';
	include("functions.php");
	$username = cleanVar('username');
	$password = cleanVar('password');
	$phoneNum = cleanVar('phone_number');
	if( isset($_POST['action']) ){
		if( isset($_POST['username']) && isset($_POST['phone_number']) ){
			$message = user_generate_token($username, $phoneNum);
		}else if( isset($_POST['username']) && isset($_POST['password']) ){
			$message = user_login($username, $password);
		}
		header("Location: two-factor-voice.php?message=" . urlencode($message));
		exit;
	}
?>
<html>
<body>
	<p>Please enter a username, and a phone number you can be reached at, we will then call you with your one-time password</p>
	<span id="message">
	<?php
		echo cleanVar('message');
		$action = (isset($_SESSION['password'])) ? 'login' : 'token';
	?>
	</span>
	<form id="reset-form"  method="POST" class="center">
	<input type="hidden" name="action" value="<?php echo $action; ?>" />
	<p>Username: <input type="text" name="username" id="username" value="<?php echo $_SESSION['username']; ?>" /></p>
	<?php if (isset($_SESSION['password'])) { ?>
	<p>Password: <input type="password" name="password" id="password" /></p>
	<?php } else { ?>
	<p>Phone Number: <input type="text" name="phone_number" id="phone_number" /></p>
	<?php } ?>
	<p><input type="submit" name="submit" id="submit" value="login!" /></p>
	<p>&nbsp;</p>
	</form>
</body>
</html>