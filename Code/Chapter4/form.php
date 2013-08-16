<h2>Prepare your conference</h2>
<form method="POST" action="schedule.php?action=save">
<table>
<tr>
	<td>Name</td>
	<td><input type="text" name="name" /></td>
</tr>
<tr>
	<td>Date & Time</td>
	<td><input type="text" name="timestamp" placeholder="DD/MM/YY HH:MM"/></td>
</tr>
</table>
<h2>Add Participants</h2>
<table>
<?php
	$limit = 6;
	for($i = 0;$i < $limit;$++){
?>
	<tr>
		<td>Name</td>
		<td><input type="text" name="call_name[]" /></td>
		<td>Phone Number</td>
		<td><input type="text" name="call_phone[]" /></td>
		<td>Moderator?</td>
		<td>
			<select name="call_status[]">
				<option value="0">No</option>
				<option value="1">Yes</option>
			</select>
		</td> 
	</tr>
<?php
	}
?>
</table>
<button type="submit">Save</button>
</form>