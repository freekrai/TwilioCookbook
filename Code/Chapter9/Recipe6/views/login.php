<div class="container-fluid m-login-container">
	<div class="page-header">
		<h2>Login</h2>
	</div>
	<form class="form-horizontal" action="<?=$uri?>/login" method="POST">
		<input type="text" name="user" placeholder="Enter email" class="span12" id="input01">
		<label></label>
		<input type="password" name="pass" placeholder="Enter password" class="span12" id="input01">
		<button type="submit" style="margin-top: 15px" class="btn btn-primary">	Login</button>
		<a href="<?=$uri?>/signup">Register</a>
	</form>
</div>			
