<?php

// session_start();
$pageTitle="Logging Out";
include('includes/header.php');


if(!isset($_SESSION['adminID']) && !isset($_SESSION['cID'])) {
    require('includes/loginFns.inc.php');
    redirectUser('cupcakeList.php');

} elseif(isset($_SESSION['adminID']) && isset($_SESSION['cID'])) {

    if($_SERVER['REQUEST_METHOD'] =='POST') {
        if($_POST['loAcct']=="admin") {
            unset($_SESSION['adminID']);
            echo "<h1>You have been logged out.</h1><p>Thank you, " . $_SESSION['firstName'] . ", for your time!!</p>";
            unset($_SESSION['firstName']);
     
        }elseif($_POST['loAcct']=="user") {
            unset($_SESSION['cID']);
            echo "<h1>You have been logged out.</h1><p>Thank you, " . $_SESSION['cfName'] . ", for visiting out site!!</p>";
            unset($_SESSION['cfName']);
            unset($_SESSION['cart']);

        } else {
            echo "<h1>You have been logged out.  </h1><p>You are logged out of both accounts. <br/>Please come back soon!</p>";
            session_destroy();
        }
    
    } else {
    
    echo '<form method="POST" action="logout.php">';
    echo '<h1>Logging Out</h1> <p>It looks as if you are logged in as an administrator and a customer. Which account would you like to be logged out?</p>';
    echo '<input type="radio" name="loAcct" value="admin" id="admin"/><label for="admin">Administrator</label><br/>';
    echo '<input type="radio" name="loAcct" value="user" id="user"/><label for="user">Customer</label><br/>';
    echo '<input type="radio" name="loAcct" value="both" id="both" checked="checked"/><label for="both">Both</label><br/>';
    echo '<input type="submit" value="Log Out"/></form>';  
    }
} 
 elseif(isset($_SESSION['adminID']) && !isset($_SESSION['cID'])) {
    // logMeOut($_SESSION['adminID'], $_SESSION['firstName']);
    unset($_SESSION['adminID']);
    echo "<h1>You have been logged out.</h1><p>Thank you, " . $_SESSION['firstName'] . ", making our website better.</p>";
    unset($_SESSION['firstName']);
 } elseif (isset($_SESSION['cID'])&& !isset($_SESSION['adminID'])) {
    unset($_SESSION['cID']);
    echo "<h1>You have been logged out.</h1><p>Thank you, " . $_SESSION['cfName'] . ", for visiting out site! Please come back soon!</p>";
    unset($_SESSION['cfName']);
    unset($_SESSION['cart']);

    }
    


include('includes/footer.html');