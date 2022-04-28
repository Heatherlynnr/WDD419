<?php

$pageTitle = "Shopping Cart";
include('includes/header.php');

if($_SERVER['REQUEST_METHOD']=='POST') {
    foreach($_POST['qty'] as $key => $value) {
        $postedKey=$key;
        $postedQuantity=$value;
        //Update quantity or get rid of those with zero quantity
        foreach($_SESSION['cart'] as $keyValue => $valueKey) {
            //if it's zero, we need to delete item
            if($postedKey==$keyValue) {
                if($postedQuantity==0) {
                    unset($_SESSION['cart'][$postedKey]);
                } elseif($postedQuantity>0) {
                    $_SESSION['cart'][$postedKey]['quantity']=$postedQuantity;
                } //end elseif
            }//ends if postedKey=keyValue
        }//ends foreach cart session
    }//ends foreach quantity 
}// ends our server request


echo '<form action="viewcart.php" method="post">';
echo '<table><tr>
<th>Cupcake Name</th>
<th>Size</th>
<th>Price</th>
<th>Quantity</th>
<th>Total</th>
</tr>';

$total=0; //Holds grand total

require('db_connect.php');

foreach($_SESSION['cart'] as $key => $value) {
    $cup_key = $key;
    $cup_id = $value['id'];
    $cup_size = $value['size'];
    $cup_quantity = $value['quantity'];

    //Get name and price of each cupcake
    $q = "SELECT c.cupcake_id, c.cupcake_name, s.size_id, p.price FROM cupcakes AS c INNER JOIN size AS S USING (cupcake_id) INNER JOIN price AS p USING (size_id) WHERE c.cupcake_id='$cup_id' && s.size_id='$cup_size'";

    $r = mysqli_query($dbc, $q);

    if($r) {
        $row=mysqli_fetch_array($r, MYSQLI_ASSOC);
        $queryID=$row['cupcake_id']. $row['size_id']; //6mini
        $subtotal=$row['price']*$cup_quantity;
        $subtotal=number_format($subtotal, 2);
        $total+=$subtotal;
        $total=number_format($total, 2);

    //Create table row for each cupcake type bought
    echo "<tr><td>" . $row['cupcake_name'] . "</td><td>" . ucfirst($row['size_id']) .
    "</td><td>" . $row['price'] . '</td><td><input type="number" name="qty[' . $queryID . ']" 
    value ="' . $cup_quantity . '"/></td><td>$ ' . $subtotal . '</td>';
} else {
    echo "<p>You cannot view your cupcake shopping cart at this time.</p>";
}
}


echo "<tr><td colspan='4'>TOTAL</td><td>$" . $total . "</td></tr></table>";
echo '<input type="submit" name="submit" value="Update Cart" /></form>';
echo '<form action="checkout.php" method="POST">';
echo '<input type="hidden" name="cID" value="'. $_SESSION['cID'] . '"/>';
echo '<input type="hidden" name="total" value="'.$total . '"/>';
echo '<input type="submit" value="Checkout" name="Checkout"/></a>';

include ('includes/footer.html');
