<?php

$page_title="Logged In";
include('includes/header.php');

//Check to see if session variables are set
if(!isset($_SESSION['adminID'])) {
    require('includes/loginFns.inc.php');
    redirectUser('admin_login.php');
}

echo '<h1>Welcome to our site!</h1>';
echo '<p>You are now logged in, ' . $_SESSION['firstName'] . '!</p>';

echo '<p><a href="addCupcake.php">Add Cupcake</a></p>';

?>