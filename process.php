<?php
include 'functions.php';
// Get user data from client via AJAX and update user data
$newUser = json_decode($_POST['user']);
$user = getUser();
$user->updateData($newUser);