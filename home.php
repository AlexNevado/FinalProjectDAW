<?php
session_start();
include 'functions.php';
require_once __DIR__ . '/vendor/autoload.php';

if (!isset($_SESSION["Authenticated"]) || $_SESSION["Authenticated"] == 0) {
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Monstruos's Bizarre Adventure</title>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
          integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
          crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
<script>
  $(document).ready(function () {
    $("#freqrange").on('change', function () {
      $("#frequency").text(this.value + "Ghz");
    });
  });
</script>
<div class="container">
  <div class="row">
    <div class="col-xs-12" role="main">
      <h3>Creador De Monstruo</h3>
      <table>
        <tr>
          <td>Str</td>
          <td><input type="number" value="1" name="quantity" min="1" max="5" class="col-xs-3"></td>
        </tr>
        <tr>
          <td>Def</td>
          <td><input type="number" value="1" name="quantity" min="1" max="5" class="col-xs-3"></td>
        </tr>
        <tr>
          <td>Luk</td>
          <td><input type="number" value="1" name="quantity" min="1" max="5" class="col-xs-3"></td>
        </tr>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-2 col-xs-offset-8">
      <a href="validate.php?logout" class="btn btn-login btn-sm">Logout</a>
    </div>
  </div>
  <?php footer() ?>
</div>
</body>
</html>