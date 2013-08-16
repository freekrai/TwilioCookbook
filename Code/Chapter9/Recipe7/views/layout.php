<html>
<head>
	<title><?=$pageTitle?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome-ie7.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/css/bootstrap-responsive.min.css" rel="stylesheet">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="masthead">
			<h3 class="muted">My PBX</h3>
			<div class="navbar">
				<div class="navbar-inner">
					<div class="container">
						<ul class="nav">
							<li class="active"><a href="<?=$uri?>/">Home</a></li>
							<li><a href="<?=$uri?>/login">Login</a></li>
							<li><a href="<?=$uri?>/signup">Signup</a></li>
						</ul>
					</div>
				</div>
			</div><!-- /.navbar -->
		</div>
		<?=$pageContent?>
		<hr />
		<div class="footer">
			<p>&copy; MY PBX <?=date("Y")?></p>
		</div>
	</div> <!-- /container -->
</body>
</html>