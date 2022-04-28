<?php
// session_start();

$page_title="Logged In";
include('includes/header.php');

//Check to see if session variables are set 
if(!isset($_SESSION['cID'])) {
    require('includes/loginFns.inc.php');
    redirectUser('cust_login.php');
}

echo '<h1>Welcome back, ' . $_SESSION['cfName'] . '!</h1>';
echo '<p>You can now place a <a href="viewcart.php">cupcake order</a>!</p>';

// echo '<p><a href="viewcart.php">Add Cupcake</a></p>';





include('includes/footer.html');
?>
