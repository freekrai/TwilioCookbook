<h3>Find a number to buy</h3>
<?php if(!empty($_GET['msg'])): ?>
	<p class="msg"><?php echo htmlspecialchars($_GET['msg']); ?></p>
<?php endif;?>
<form method="POST" action="<?=$uri?>/search">
<label>near US postal code (e.g. 94117): </label><input type="text" size="4" name="postal_code"/><br/>
<label>near this other number (e.g. +14156562345): </label><input type="text" size="7" name="near_number"/><br/>
<label>matching this pattern (e.g. 415***EPIC): </label><input type="text" size="7" name="contains"/><br/>
<input type="hidden" name="action" value="search" />
<input type="submit" name="submit" value="SEARCH"/>
</form>
