<?php
	function cleanVar($key){
		$retVal = '';
		$retVal = isset( $_REQUEST[$key]) ? $_REQUEST[$key] : '';
		switch($key){
			case 'username':
			case 'password':
				$retVal = preg_replace("/[^A-Za-z0-9]/", "", $retVal);
				break;
			case 'phone_number':
				$retVal = preg_replace("/[^0-9]/", "", $retVal);
				break;
			case 'message':
				$retVal = urldecode($retVal);
				$retVal = preg_replace("/[^A-Za-z0-9 ,']/", "", $retVal);
				break;
			default:
				break;
		}
		return $retVal;
	}

	function user_generate_token($username, $phoneNum, $method='calls'){
	    global $accountsid, $authtoken, $fromNumber;
	    $password = substr(md5(time().rand(0, 10^10)), 0, 10);
	    $_SESSION['username'] = $username;
	    $_SESSION['password'] = $password;
	    $client = new Services_Twilio($accountsid, $authtoken);
	    $content = "Your newly generated password is ".$password." To repeat that, your password is ".$password;
	    $item = $client->account->$method->create(
	                $fromNumber,    // The Twilio number we're sending from
	                $phoneNum,      // The user's phone number
	                $content
	            );
	    $message = "A new password has been generated and sent to your phone number.";
	    return $message;
	}
	function user_login($username, $submitted) {
	    $stored = $_SESSION['password'];
	    if ($stored == $submitted) {
	        $message = "Hello and welcome back $username";
	    } else {
	        $message = "Sorry, that's an invalid username and password combination.";
	    }
	    unset($_SESSION['username']);
	    unset($_SESSION['password']);
	    return $message;
	}
?>