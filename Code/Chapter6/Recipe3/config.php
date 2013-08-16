<?php
	session_start();
	$accountsid = '';	//	YOUR TWILIO ACCOUNT SID
	$authtoken = '';	//	YOUR TWILIO AUTH TOKEN
	$fromNumber = '';	//	PHONE NUMBER CALLS WILL COME FROM

	$toNumber = ''; 	//	PHONE NUMBER TO FORWARD CALLS TO
	$canned = 'Thank you for the message'; //	CANNED MESSAGE TO SEND TO CALLER