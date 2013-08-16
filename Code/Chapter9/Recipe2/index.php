<?php
include 'Services/Twilio.php';
require("config.php");
require("system/jolt.php");
require("system/pdo.class.php");
require("system/functions.php");

$_GET['route'] = isset($_GET['route']) ? '/'.$_GET['route'] : '/';
$app = new Jolt('site',false);
$app->option('source', 'config.ini');
#$pdo = Db::singleton();
$mysiteURL = $app->option('site.url');

//      Conditions      --------------------------------------------------------------------------------------------

$app->condition('signed_in', function () use ($app) {
        $app->redirect( $app->getBaseUri().'/login',!$app->store('user'));
});

//      Login   --------------------------------------------------------------------------------------------

$app->get('/login', function() use ($app){
        $app->render( 'login', array(),'layout' );
});
$app->post('/login', function() use ($app){
	$sql = "SELECT * FROM `user` WHERE `email`='{$_POST['user']}' AND `password`='{$_POST['pass']}'";
	$pdo = Db::singleton();
	$res = $pdo->query( $sql );
	$user = $res->fetch();
	if( isset($user['ID']) ){
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
});
$app->get('/', function() use ($app){
	$app->render( 'home' );
});
$app->listen();