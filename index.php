<!DOCTYPE html>
<html>
<head>
<title>Monstruos's Bizarre Adventure</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<style type="text/css">
	body {
		text-align: center;
		font-size: 20px;
		background: url(image/background1.jpg);
		color: #dedede;
	}
	div[role="footer"] {
		color: white;
		font-size: 0.9em;
		padding: 0.5%;
		text-align: center;
		mix-blend-mode: exclusion;
	}
	.login input {
		display: inline;
		width: auto;
		padding: 
	}
	.container {
		margin-top: 1%;
	}
	#fb {
		margin:0% 0%;
		background: url('image/ss3.gif') no-repeat 0 0;
		width: 44px;
		height: 44px;
		border-radius: 10px 10px 10px 10px;
	}
	#fb:hover {
		background: url('image/ss3.gif') no-repeat 0 98.889%;
	}
	#tw {
		background: url('image/ss3.gif') no-repeat 16.993% 0;
		width: 44px;
		height: 44px;
		border-radius: 10px 10px 10px 10px;
	}
	#tw:hover {
		background: url('image/ss3.gif') no-repeat 16.993% 98.889%;
	}
	#in {
		background: url('image/ss3.gif') no-repeat 51.316% 0;
		width: 46px;
		height: 43px;
		border-radius: 10px 10px 10px 10px;
	}
	#in:hover {
		background: url('image/ss3.gif') no-repeat 51.316% 98.889%;
	}
	#tu {
		background: url('image/ss3.gif') no-repeat 84.262% 0;
		width: 45px;
		height: 44px;
		border-radius: 10px 10px 10px 10px;
	}
	#tu:hover {
		background: url('image/ss3.gif') no-repeat 84.262% 98.889%;
	}
	.row {
		margin-bottom: 1%;
	}
	.rrss {
		padding:1%;
	}
	.btn-login {
		color:black;
		background: lightgray;
	}
	.btn-login:hover {
		box-shadow: 1px 1px 10px 1px white;
	}
	@media  (max-width: 600px) {
		body{
			font-size: 1.4em;
		}
		.rrss img {

			width: 20px;
			height: 20px;
		}
	}
</style>
</head>
<body>
<?php echo 'erare';?>
<div class="container">
	<div class="row">
		<div class="col-xs-12" role="main">
			<div class="row">
			<img src="image/login_image1.png" class="col-xs-8 col-xs-offset-2 img-responsive loginImage"/>
			</div>
			<div class="row">
				<form>
					<div class="col-xs-12 login">
						<h2> Monstruos's Bizarre Adventure</h2><br/>
						<div class="form-group">
							<label for="usr">Username:</label>
							<input type="text" class="form-control" id="usr">
						</div>
						<div class="form-group">
  							<label for="pwd">Password:</label>
  							<input type="password" class="form-control" id="pwd">
						</div>
						<button type="submit" class="btn btn-login">Login</button>
					</div>					
				</form>
			</div>
			<div class="row">
				<div class="col-xs-12 rrss">
					<a href="#"><img id="fb" src="image/img_trans.gif"></a>
					<a href="#"><img id="tw" src="image/img_trans.gif"></a>
					<a href="#"><img id="in" src="image/img_trans.gif"></a>
					<a href="#"><img id="tu" src="image/img_trans.gif"></a>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12" role="footer">
			<p>@2017 | Designed by GrupoSinNombre</p>
		</div>
	</div>
</div>
</body>
</html>