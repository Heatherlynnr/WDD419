<?php

$pageTitle="Order Confirmation";
include('includes/header.php');

if($_SERVER['REQUEST_METHOD']=='POST') {
    if(!isset($_SESSION['cID'])) {
        echo '<h1>Login is required</h1>';
        echo '<p>Please click the link below to login.</p>';
        echo '<p><a href="cust_login.php">Customer Login</a></p>';
    } else {
        $cID=$_SESSION['cID'];
        $total=$_POST['total'];
    }

//Connect to the database and turn off autocommit
require('db_connect.php');
mysqli_autocommit($dbc, FALSE);

//Set pickup date
$pickUpDate = date("Y-m-d H:i:s", strtotime("+1 week"));

echo $pickUpDate;

//Add information to orders table
//Order date is automatically added through the table data type
$q= "INSERT INTO orders (cust_id, total) VALUES ('$cID', '$total')";

$r = mysqli_query($dbc, $q);
//Get the orderID from the table
if(mysqli_affected_rows($dbc)==1) {
    //Brings back the AUTO_INCREMENT value IF you have (1) an A_I column and (2) last query executed an INSERT OR UPDATE statement.
    $orderID = mysqli_insert_id($dbc);

    //Set pickup date
    $pickUpDate = date("Y-m-d H:i:s", strtotime("+1 week"));


    //Insert order into order_contents table
    $q2 = "INSERT INTO order_contents (order_id, cupcake_id, size_id, quantity, price, pickup_date) VALUES (?,?,?,?,?,?)";

    //Prepares the query to be ran for each cupcake
    $stmt = mysqli_prepare($dbc, $q2); 

    //data types all the values going in: integer, integer, string, integer, decimal/double, string
    mysqli_stmt_bind_param($stmt, 'iisids', $orderID, $cup_id, $cup_size, $cup_quant, $cup_price, $pickUpDate);
    
    //Count the number of entries
    $affected=0;

    //Cycle through all the entries into the cart session array
    foreach($_SESSION['cart'] as $key => $cupID) {
        $cup_id = $cupID['id'];
        $cup_size = $cupID['size'];
        $cup_quant = $cupID['quantity'];
        $cup_price = $cupID['price'];
        mysqli_stmt_execute($stmt);
        $affected+=mysqli_stmt_affected_rows($stmt);
    }

    //Stops the statement from running
    mysqli_stmt_close($stmt);

    //echo $affected+=mysqli_stmt_affected_rows($stmt);

    //Checks to see if the number of affect rows equals the number of records in the cart session
    if($affected==count($_SESSION['cart'])) {
        //commit transaction
        mysqli_commit($dbc);

        //clear the cart
        unset($_SESSION['cart']);

        echo "<h1>Thank you for your order!</h1><p>Your items will be ready in one week. We will 
        notify you when your order is completed.</p>";
    } else {
        mysqli_rollback($dbc);
        echo "<h1>An Error Has Occurred</h1><p>Your order could not be processed. We apologize for any inconvenience.</p>";
    }
} else {

    mysqli_rollback($dbc);

}
redirectUser('cupcakeList.php');
}
mysqli_close($dbc);

include('includes/footer.html');



?>