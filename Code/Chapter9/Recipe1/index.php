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

$app->get('/', function() use ($app){
	$app->render( 'home' );
});
$app->listen();