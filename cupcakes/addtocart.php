<?php

$page_title="Add to Cart";
include('includes/header.php');

if($_SERVER['REQUEST_METHOD']=='POST') {
    if(isset($_POST['cc_id'])) {
        $ccID = $_POST['cc_id'];
    }
    if(isset($_POST['ccSize'])) {
        $ccSize = $_POST['ccSize'];
    }
    if(isset($_POST['ccQuantity'])) {
        $ccQuantity = $_POST['ccQuantity'];
    }

    //Variable will combine the ID with the size
    $indexKey=$ccID.$ccSize; //6mini
    $addMore=FALSE;

    //echo "ID: " . $ccID;
    //echo "<br/>Size: " . $ccSize;
    //echo "<br/>Quantity: " . $ccQuantity;
    //echo "<br/>Index Key: " . $indexKey;    
    if(isset($_POST['cc_id'])) {
        $ccID = $_POST['cc_id'];
    }

    //Require database connection file
    require('db_connect.php');

    //Get the name of the cupcake
    $q = "SELECT cupcake_name FROM cupcakes WHERE cupcake_id='$ccID'";

    $r=mysqli_query($dbc,$q);
        if($r) {
            $row=mysqli_fetch_array($r, MYSQLI_ASSOC);
            $ccName=$row['cupcake_name'];
            $ccItem=$ccSize . " " . $ccName . " cupcakes";

            echo "<br/>Item Name: " . $ccItem;
        }
    
    //Loop that will check all cart items to see if this new item added currently exists
    foreach($_SESSION['cart'] as $key => $value) {
        if($key==$indexKey) {
            $addMore=TRUE;
            break;
        }
    }

    //Check addMore status
    if($addMore) {
        //Write code to add more of existing kind
        //if only one more cupcake is added
        if($ccQuantity==1) {
            $_SESSION['cart'][$indexKey]['quantity']++;
            echo "<p>" . $ccQuantity . " more " . $ccName . " " . $ccSize . " cupcake has been added to your shopping cart.</p>";
        } elseif($ccQuantity>1) {
            echo "<p>" . $ccQuantity . " more " . $ccName . " " . $ccSize . " cupcakes has been added to your shopping cart.</p>";
        }
    } else {
        //Write code for new cupcake
        //$addMore is FALSE
        //Retrieve price from database
        $q2="SELECT price FROM price AS p INNER JOIN size AS s USING(size_id) WHERE s.cupcake_id='$ccID' && s.size_id='$ccSize'";

        $r2=mysqli_query($dbc, $q2);

        if($r2) {
            $row2=mysqli_fetch_array($r2, MYSQLI_ASSOC);
            $ccPrice = $row2['price'];

            $_SESSION['cart'][$indexKey] = array (
                'id' => $ccID,
                'quantity' => $ccQuantity,
                'price' => $ccPrice,
                'size' => $ccSize
            );

            if($ccQuantity==1) {
                echo '<p>' . $ccQuantity . " " . $ccName . " " . $ccSize . 'cupcake was added to your shopping cart.</p>';
            } elseif($ccQuantity>1) {
                echo '<p>' . $ccQuantity . " " . $ccName . " " . $ccSize . 'cupcakes was added to your shopping cart.</p>';
            }
        } else { //if $r2 is not successful
            echo "<p>We were unable to add the cupcake to your order.</p>";
        }
    }
}
     else {
        echo "<p>$r was not successful.</p>";
    }

?>