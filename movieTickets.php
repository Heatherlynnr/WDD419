<?php

$pageTitle = "Movie Tickets Calculator";
include("includes/header.html");

$tAdult=$_POST["tAdult"];
$tChild=$_POST["tChild"];
$tSenior=$_POST["tSenior"];

if(!empty($_POST['tAdult'])){
    $tAdult=$_POST['tAdult'];
} else {
    $tAdult=NULL;
}

if(!empty($_POST['tChild'])){
    $tChild=$_POST['tChild'];
} else {
    $tChild=NULL;
}

if(!empty($_POST['tSenior'])){
    $tSenior=$_POST['tSenior'];
} else {
    $tSenior=NULL;
}

function calcCost($price, $quantity) {
    $cost = $price * $quantity;
    return $cost;
}

?>

<form method="post" action="movieTickets.php">
    <table>
        <tr>
            <td>Tickets</td>
            <td>Price</td>
            <td>Quantity</td>
        </tr>
        <tr>
            <td>Adults 7.00</td>
            <td><input name="tAdult" value="<?php
                echo $tAdult; 
                $costAdult = calcCost(7,$tAdult);
                ?>"/></td>
            <td><?php echo "$" . number_format($costAdult,2); ?></td>
        </tr>
        <tr>
            <td>Child 5.00</td>
            <td><input name="tChild" value="<?php
                echo $tChild; 
                $costChild = calcCost(5,$tChild);
                ?>"/></td>
            <td><?php echo "$" . number_format($costChild,2); ?></td>
        </tr>
        <tr>
            <td>Senior 6.00</td>
            <td><input name="tSenior" value="<?php
                echo $tSenior; 
                $costSenior = calcCost(6,$tSenior);
                ?>"/></td>
            <td><?php echo "$" . number_format($costSenior,2); ?></td>
        </tr>
    </table>

    <input type="submit" value="Submit Query" id="submit" name="submit"/>
</form>

<?php

$total = $costAdult + $costChild + $costSenior;

echo "<p>Your total ticket cost is $" . number_format($total,2);

include("includes/footer.html");

?>
