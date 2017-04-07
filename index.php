<?php
    session_start();
    $_SESSION["url"]= $_SERVER['PHP_SELF'];
    include 'functions.php';
?>
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
<link rel="stylesheet" href="css/main.css">
</head>
<body>
<?php facebook(); ?>
<div class="container">
	<div class="row">
		<div class="col-xs-12" role="main">
			<div class="row">
			<img src="image/login_image1.png" class="col-xs-8 col-xs-offset-2 img-responsive loginImage"/>
			</div>
			<div class="row">
        <form action="validate.php" method="post">
					<div class="col-xs-12 login">
						<h2> Monstruos's Bizarre Adventure</h2><br/>
						<div class="form-group">
							<label for="usr">Username:</label>
							<input type="text" class="form-control" id="usr">
						</div>
						<div class="form-group">
                <label for="pwd">Password:</label><input type="password" class="form-control" id="pwd">
						</div>
              <button type="submit" class="btn btn-login btn-sm">Login</button>
              <button type="button" class="btn btn-login btn-sm">Register</button>
              <div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="false"></div>
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