<?php

if(count($_POST)){
	foreach($_POST['keys'] as $k=>$v){
		if( empty($v) ){
			unset( $_POST['keys'][$k] );
			unset( $_POST['status'][$k] );
		}
	}
	PluginData::set('orders', array(
		'keys' => $_POST['keys'],
		'status' => $_POST['status'],
	));
}
$settings = PluginData::get('orders', array(
	'keys' => array(),
	'status' => array(),
));

#	print_r( $settings );

$statusArray = array(
	'shipped'=>'Shipped',
	'fullfillment'=>'Sent to Fullfillment',
	'processing'=>'Processing'
);
OpenVBX::addJS('script.js');
?>
<div class="vbx-plugin orders-applet">
<form method="post">
	<h2>Order Tracker</h2>
	<p>Enter an order ID, without spaces.  For example, <code>1234</code> instead of <code>123 4</code>.</p>
	<table class="vbx-orders-grid options-table">
	<thead>
		<tr>
			<td>Order ID</td>
			<td>Status</td>
			<td>Actions</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach($settings->keys as $i=>$key){ ?>
		<tr>
			<td>
				<fieldset class="vbx-input-container">
					<input class="keypress" type="text" name="keys[]" value="<?php echo $key ?>" autocomplete="off" />
				</fieldset>
			</td>
			<td>
				<select name="status[]">
<?php
				foreach($statusArray as $k=>$v){
					$sel = '';
					if( $settings->status[ $i ] == $k )	$sel = 'SELECTED';
?>
					<option value="<?=$k?>" <?=$sel?>><?=$v?></option>
<?php
				}
?>
				</select>
			</td>
			<td>
				<a href="" class="add action"><span class="replace">Update</span></a> <a href="" class="remove action"><span class="replace">Remove</span></a>
			</td>
		</tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td>
				<fieldset class="vbx-input-container">
					<input class="keypress" type="text" name="keys[]" value="" autocomplete="off" />
				</fieldset>
			</td>
			<td>
				<select name="status[]">
<?php
				foreach($statusArray as $k=>$v){
					$sel = '';
					
?>
					<option value="<?=$k?>" <?=$sel?>><?=$v?></option>
<?php
				}
?>
				</select>
			</td>
			<td>
				<a href="" class="add action"><span class="replace">Update</span></a> <a href="" class="remove action"><span class="replace">Remove</span></a>
			</td>
		</tr>
	</tfoot>
	</table><!-- .vbx-orders-grid -->
<button type="submit">Save Orders</button>
</form>
</div><!-- .vbx-applet -->