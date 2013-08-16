<?php

class call_log{
	private $limit;
	private $account;
	public function __construct($limit = 20){
		$this->limit = $limit;
		$this->account = OpenVBX::getAccount();
	}
	public function list_calls(){
		$calls = $this->account->calls->getPage(0, $this->limit, array())->getItems();
?>
		<div class="vbx-plugin">
			<h3>Call Log</h3>
			<p>Showing the last <?= $this->limit; ?> calls.</p>
			<table>
			<thead>
			<tr>
				<th>Number</th>
				<th>Start Time</th>
				<th>End Time</th>
				<th>Duration</th>
				<th>Called</th>
				<th>Status</th>
			</tr>
			</thead>
			<tbody>
		<?php 	foreach($calls as $i => $call){ ?>
			<tr>
				<td><?= $this->who_called($call->from); ?></td>
				<td><?= $this->nice_date($call->start_time); ?></td>
				<td><?= $this->nice_date($call->end_time); ?></td>
				<td><?= gmdate("H:i:s",$call->duration); ?></td>
				<td><?= $this->who_called($call->to); ?></td>
				<td><?= $this->be_nice($call->status); ?></td>
			</tr>
		<?php 	} ?>
			</tbody>
			</table>
		</div>
<?php
	}
	public function be_nice($status, $sep = '-') {
		return ucwords(str_replace($sep, ' ', $status));
	}
	public function who_called($number) {
		if (preg_match('|^client:|', $number)){
			$user_id = str_replace('client:', '', $number);
			$user = VBX_User::get(array('id' => $user_id));
			$ret = $user->first_name.' '.$user->last_name.' (client)';
		}else{
			$ret = format_phone($number);
		}
		return $ret;
	}
	public function nice_date($date){
		$timestamp = strtotime($date);
		return date('M j, Y', $timestamp).'<br />'.date('H:i:s T', $timestamp );
	}
}

$log = new call_log(50);
$log->list_calls();