<?php
/*
	This array is your company directory, the format is as follows:
		'extension'=> array(
			'phone'=>'phone number to call',
			'firstname'=>'first name',
			'lastname' => 'lastname'
		)
*/

	$directory = array(
		'0'=> array(
			'phone'=>'415-555-1111',
			'firstname' => 'John',
			'lastname' => 'Smith'
		),
		'1234'=> array(
			'phone'=>'415-555-2222',
			'firstname' => 'Joe',
			'lastname' => 'Doe'
		),
		'4321'=> array(
			'phone'=>'415-555-3333',
			'firstname' => 'Eric',
			'lastname' => 'Anderson'
		),
	);

/*
	This little piece of fun lets you take a person's last name and assign matching digits from phone numbers... :)
*/
	$indexes = array();
	foreach($directory as $k=>$row){
		$digits = stringToDigits( $row['lastname'] );
		$indexes[ $digits] = $k;
	}

	function stringToDigits($str) {
		$str = strtolower($str);
		$from = 'abcdefghijklmnopqrstuvwxyz';
		$to = '22233344455566677778889999';
		return preg_replace('/[^0-9]/', '', strtr($str, $from, $to));
	}

	function getPhoneNumberByExtension($ext){
		global $directory;
		if( isset( $directory[$ext] ) ){
			return $directory[$ext];
		}
		return false;
	}
	function getPhoneNumberByDigits($digits){
		global $directory,$indexes;
		$search = false;
		foreach( $indexes as $i=>$ext ){
			if( stristr($i,$digits) ){
				$line = $directory[ $ext ];
				$search = array();
				$search['name']= $line['firstname']." ".$line['lastname'];
				$search['extension']=$ext;
			}
		}
		return $search;
	}
?>