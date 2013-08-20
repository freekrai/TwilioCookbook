<?php
	session_start();
	include("config.php");
	include("functions.php");
	
	if( isset($_POST['phone']) ){
		$ph = cleanVar( $_POST['phone'], 'phone' );
		$message = cleanVar( $_POST['message'], 'text' );
		$url = $_POST['himg'];
		$target_path = 'tmp/';
		$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 
		if( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path) ){
			$url = $myUrl.$target_path;
		}
		$tmms = new TwilioMMS($accountsid,$authtoken);
		$smsg = $tmms->sendMessage($ph,$fromNumber,$message,$url);
		echo "<pre>".print_r( $smsg,true )."</pre>";
	}else{
	?>
		<form enctype="multipart/form-data" action="send.php" method="POST">
			<ul>
				<li>
					Enter your phone number: <input type="tel" name="phone" />
				</li>
				<li>
					Enter your message: <input type="text" name="message" />
				</li>
				<li>
					Choose a file to upload: <input name="uploadedfile" type="file" />
				</li>
				<li>
					<input type="submit" value="Upload File" />
				</li>
			</ul>
		</form>
	<?php
	}
?>