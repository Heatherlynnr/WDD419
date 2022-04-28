<?php

session_id('cart');
session_start();

?>

<?php
    if(isset($_SESSION['adminID']) || isset($_SESSION['cID'])) {
        echo '<a href="logout.php"><input type="button" value ="Log out"/></a>';
    } ?> 



<div><?php
        echo "cID:" . $_SESSION['cID'] . "<br/>";
        echo "cName: " . $_SESSION['cfName'] . "<br/>";
        echo "Admin ID: " . $_SESSION['adminID'] . "<br/>";
        echo "Admin Name: " . $_SESSION['firstName'] . "<br/>";
       ?>
</div>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $page_title; ?></title>
    <link href="includes/cupcakeStyles.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="cupcakeList.php">Cupcakes</a></li>
            <li><a href="viewCart.php">Order</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="admin_login.php">Admin</a></li>
        </ul>
    </nav>
    <?php

    //If adminID is set, show log out button
    if(isset($_SESSION['adminID'])) {
        echo '<aside><a href="logout.php"><input type="button" value="Log Out"/></a></aside>';
    }

    ?>
</header>
<main>