<?php

function getRecording($caSID){
	global $accountsid,$authtoken;
    $version = '2010-04-01';
    $url = "https://api.twilio.com/2010-04-01/Accounts/{$accountsid}/Calls/{$caSID}/Recordings.xml";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "{$accountsid}:{$authtoken}");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    $output = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    $output = simplexml_load_string($output);
    echo "<table>";
    foreach ($output->Recordings->Recording as $recording) {
        echo "<tr>";
        echo "<td>".$recording->Duration." seconds</td>";
        echo "<td>".$recording->DateCreated."</td>";
        echo '<td><audio src="https://api.twilio.com/2010-04-01/Accounts/'.$sid.'/Recordings/'.$recording->Sid.'.mp3" controls preload="auto" autobuffer></audio></td>';
        echo "</tr>";
    }
    echo "</table>";
}

?>