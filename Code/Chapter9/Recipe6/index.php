<?php
session_start();
include 'Services/Twilio.php';
require("system/jolt.php");
require("system/pdo.class.php");
require("system/functions.php");

$_GET['route'] = isset($_GET['route']) ? '/'.$_GET['route'] : '/';
$app = new Jolt('site',false);
$app->option('source', 'config.ini');
#$pdo = Db::singleton();
$mysiteURL = $app->option('site.url');

$app->condition('signed_in', function () use ($app) {
        $app->redirect( $app->getBaseUri().'/login',!$app->store('user'));
});

$app->get('/login', function() use ($app){
        $app->render( 'login', array(),'layout' );
});
$app->post('/login', function() use ($app){
	$sql = "SELECT * FROM `user` WHERE `email`='{$_POST['user']}' AND `password`='{$_POST['pass']}'";
	$pdo = Db::singleton();
	$res = $pdo->query( $sql );
	$user = $res->fetch();
	if( isset($user['ID']) ){
		$_SESSION['uid'] = $user['ID'];
		$app->store('user',$user['ID']);
        $app->redirect( $app->getBaseUri().'/home');
    }else{
        $app->redirect( $app->getBaseUri().'/login');
    }
});
$app->get('/signup', function() use ($app){
        $app->render( 'register', array(),'layout' );
});
$app->post('/signup', function() use ($app){
	$client = new Services_Twilio($app->store('twilio.accountsid'), $app->store('twilio.authtoken') );
	extract($_POST);
	$timestamp = strtotime( $timestamp );
	$subaccount = $client->accounts->create(array(
		"FriendlyName" => $email
	));
	$sid = $subaccount->sid;
	$token = $subaccount->auth_token;
	$sql = "INSERT INTO 'user' SET `name`='{$name}',`email`='{$email}',`password`='{$password}',`phone_number`='{$phone_number}',`sid`='{$sid}',`token`='{$token}',`status`=1";
	$pdo = Db::singleton();
	$pdo->exec($sql);
	$uid = $pdo->lastInsertId();
	$app->store('user',$uid );
	//	log user in
    $app->redirect( $app->getBaseUri().'/phone-number');
});
$app->get('/phone-number', function() use ($app){
	$app->condition('signed_in');
	$user = $app->store('user');
	$client = new Services_Twilio($user['sid'], $user['token']);
	$app->render('phone-number');
});

$app->post("search", function() use ($app){
	$app->condition('signed_in');
	$user = get_user( $app->store('user') );
	$client = new Services_Twilio($user['sid'], $user['token']);
	$SearchParams = array();
	$SearchParams['InPostalCode'] = !empty($_POST['postal_code']) ? trim($_POST['postal_code']) : '';
	$SearchParams['NearNumber'] = !empty($_POST['near_number']) ? trim($_POST['near_number']) : '';
	$SearchParams['Contains'] = !empty($_POST['contains'])? trim($_POST['contains']) : '' ;
	try {
		$numbers = $client->account->available_phone_numbers->getList('US', 'Local', $SearchParams);
		if(empty($numbers)) {
			$err = urlencode("We didn't find any phone numbers by that search");
			$app->redirect( $app->getBaseUri().'/phone-number?msg='.$err);
			exit(0);
		}
	} catch (Exception $e) {
		$err = urlencode("Error processing search: {$e->getMessage()}");
		$app->redirect( $app->getBaseUri().'/phone-number?msg='.$err);
		exit(0);
	}
	$app->render('search',array('numbers'=>$numbers));
});

$app->post("buy", function() use ($app){
	$app->condition('signed_in');
	$user = get_user( $app->store('user') );
	$client = new Services_Twilio($user['sid'], $user['token']);
	$PhoneNumber = $_POST['PhoneNumber'];
	try {
		$number = $client->account->incoming_phone_numbers->create(array(
			'PhoneNumber' => $PhoneNumber
		));
		$phsid = $number->sid;
		if ( !empty($phsid) ){
			$sql = "INSERT INTO numbers (user_id,number,sid) VALUES('{$user['ID']}','{$PhoneNumber}','{$phsid}');";
			$pdo = Db::singleton();
			$pdo->exec($sql);
			$fid = $pdo->lastInsertId();
			$ret = editNumber($phsid,array(
				"FriendlyName"=>$PhoneNumber,
				"VoiceUrl" => $mysiteURL."/voice?id=".$fid,
				"VoiceMethod" => "POST",
				"SmsUrl" => $mysiteURL."/sms?id=".$fid,
				"SmsMethod" => "POST",
			),$user['sid'], $user['token']);
		}
	} catch (Exception $e) {
		$err = urlencode("Error purchasing number: {$e->getMessage()}");
		$app->redirect( $app->getBaseUri().'/phone-number?msg='.$err);
		exit(0);
	}
	$msg = urlencode("Thank you for purchasing $PhoneNumber");
	header("Location: index.php?msg=$msg");
	$app->redirect( $app->getBaseUri().'/home?msg='.$msg);
	exit(0);
});
$app->route('/voice', function() use ($app){
	header("Content-type: text/xml");
	$fid = $_GET['id'];
	$from = preg_replace("/[^0-9]/", "", $_POST['From']);
	$pdo = Db::singleton();
	$sql = "SELECT * FROM numbers WHERE ID='{$fid}';";
	$res = $pdo->query( $sql );
	$number = $res->fetch();
	$fromNumber = $number['number'];
	if( $user = get_user($number['user_id']) ){
		$_SESSION['uid'] = $user['ID'];
		$toNumber = $user['phone_number'];
		$name = $user['name'];
		$response = new Services_Twilio_Twiml();
		$response->dial($toNumber, array('timeout' => 5));
		$response->say("I'm sorry, $name is not available at this time. Please leave a message after the tone.");
		$response->record(array(
			'transcribeCallback' => 'transcribe.php?uid='.$user['ID'].'&From=' . $from,
			'transcribe' => 'true'
		));
		print $response;
		exit;
	}

});

$app->route('/transcribe', function() use ($app){
	header("Content-type: text/xml");
	$uid = $_GET['uid'];
	if( $user = get_user( $uid ) ){
		$filter     = "!@#$^&%*()+=-[]\/{}|:<>?,.";
		$recording  = preg_replace("/[$filter]/", "", $_POST['RecordingUrl']);
		$transcript = preg_replace("/[$filter]/", "", $_POST['TranscriptionText']);
		$from   = preg_replace("/[^0-9]/", "", $_GET['From']);
		$subject = "You have a new voicemail transcription from " . $from;
		$body = "You received voicemail." .
	            "\n\nHere is the recording: $recording" .
	            "\n\nAnd here is the transcription:\n $transcript";
		mail($user['email'], $subject, $body);
		exit;
	}
});

$app->route('/call', function() use ($app){
	$app->condition('signed_in');
	$uid = $app->store('user');
	$user = get_user( $uid );
	$client = new Services_Twilio($user['sid'], $user['token']);
	$pdo = Db::singleton();
	$sql = "SELECT * FROM numbers WHERE user_id='{$user['ID']}' LIMIT 1;";
	$res = $pdo->query( $sql );
	$number = $res->fetch();
	$fromNumber = $number['number'];
	$toNumber = $user['phone_number'];
	$call = $client->account->calls->create($fromNumber, $toNumber, '/callback?number=' . $_REQUEST['number']);

});
$app->route('/callback', function() use ($app){
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Say>A person at the number <?php echo $_REQUEST['number']?> is calling</Say>
    <Dial><?php echo $_REQUEST['number']?></Dial>
</Response>
<?php
});
$app->get('/logout', function() use ($app){
        $app->store('user',0);
        $app->redirect( $app->getBaseUri().'/login');
});
$app->get('/home', function() use ($app){
	$app->condition('signed_in');
	$uid = $app->store('user');
	$user = get_user( $uid );
	$client = new Services_Twilio($user['sid'], $user['token']);
	$app->render('dashboard',array(
		'user'=>$user,
		'client'=>$client
	));
});
$app->get('/delete', function() use ($app){
	$app->condition('signed_in');
});
$app->get('/', function() use ($app){
	$app->render( 'home' );
});
$app->listen();