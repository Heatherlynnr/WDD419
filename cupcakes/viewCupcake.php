<?php

//Require the connection page
require('db_connect.php');

//Get the id from the url
//Filter function makes sure the value is an integer
if(isset($_GET['cupcake_id']) && filter_var($_GET['cupcake_id'], FILTER_VALIDATE_INT)) {
    $cc_id=$_GET['cupcake_id'];
}

$q="SELECT * FROM cupcakes WHERE cupcake_id= '$cc_id'";

//Connect to database and run query
$r=mysqli_query($dbc, $q);

//Counting the rows
$rowNum=mysqli_num_rows($r); //Should return 1;

if($r && $rowNum==1) {
    $row=mysqli_fetch_array($r, MYSQLI_ASSOC);
    //Use cupcake name from query for page title
    $page_title=$row['cupcake_name'];
    //Include header
    include('includes/header.php');
    //Cupcake information
    echo '<div class="iCupcake"';
    echo '<h1>' . $row['cupcake_name'] . '</h1>';
    echo '<img sec="images/' . $row['cupcake_img'] . '" alt="' . $row['cupcake_name'] . '"/><div class="cDesc"></p>' . $row['cupcake_desc'] . '</p></div>';

    //Start the form
    echo '<form action="addtocart.php" method="POST">';
    echo '<input type="hidden" name="cc_id" value="' . $cc_id . '"/>';

    //Select price and size info
    $q2="SELECT price.size_id, price FROM price INNER JOIN size USING(size_id) WHERE size.cupcake_id='$cc_id'";

    //Connect to database and run query
    $r2=mysqli_query($dbc, $q2);

    if($r2) {
        //Dropdown for different sizes
        echo '<label for="ccSize">Cupcake Sizes:</label>';
        echo '<select name="ccSize" id="ccSize">';

        //Loop through records returned
        while($row2=mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
            echo '<option value="' . $row2['size_id'] . '">' . $row2['size_id'] . ' - ' . $row2['price'] . '</option>';
        }
        echo '</select><br/>';

        //Quantity field
        echo '<label for="quantity">Quantity: </label><input type="number" min="1" name="ccQuantity" id="quantity" /><br/>';

        //Submit order button
        echo '<input type="submit" value="Add to Cart" name="submit"/></form></div>';
    } else {
        echo "This cupcake is out of stock.";
    }
} else {
    echo "Sorry - the cupcake information could not be found.";
}

?>