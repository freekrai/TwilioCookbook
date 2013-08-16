<h2>Prepare your survey</h2>
<form method="POST" action="survey-builder.php?action=save">
<table>
<tr>
	<td>Question</td>
	<td><input type="text" name="question" /></td>
</tr>
<?php
	for($i = 1;$i <= 6;$i++){
?>
		<tr>
			<td>Answer <?=$i?></td>
			<td><input type="text" name="answer<?=$i?>" /></td>
		</tr>
<?php
	}
?>
</table>
<button type="submit">Save</button>
</form>