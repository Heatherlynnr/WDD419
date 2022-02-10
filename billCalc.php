<?php

include('includes/header.html');

$tipVal=array(.10, .20, .30, .40);
$taxRate=0.08;

$restaurant=$_POST["restaurant"];
$mealprice=$_POST["mealprice"];

if(!empty($_POST["restaurant"])){
    $restaurant=$_POST["restaurant"];
} else {
    $restaurant=NULL;
}

if(!empty($_POST["tip"])){
    $tipAmt=$_POST["tip"];
} else {
    $tipAmt=NULL;
}

if(!empty($_POST["mealprice"])){
    $mealprice=$_POST["mealprice"];
} else {
    $mealprice=NULL;
}

?>

<form method="post" action="billCalc.php">
    <p><input type="text" name="restaurant" value="<?php echo $restaurant; ?>">Restaurant: </input></p>
    <p><input type="text" name="mealprice" value="<?php echo $mealprice; ?>">Meal Cost: </input></p>

    <p><select id="tip" name="tip">Tip:</p>
        <option name="tip2" value="<?php echo $tipVal[0]; ?>">10%</option>
        <option name="tip2" value="<?php echo $tipVal[1]; ?>">20%</option>
        <option name="tip2" value="<?php echo $tipVal[2]; ?>">25%</option>
        <option name="tip2" value="<?php echo $tipval[3]; ?>">30%</option>
        
    <input type="submit" value="Calculate Total" id="submit" name="submit"/>
</form>

<?php

$tip = $mealprice * $tipAmt; 
$total = $mealprice + ($mealprice * $taxRate) + $tip;

if ($_SERVER['REQUEST_METHOD']=="POST") {
    if(isset($restaurant) && isset($mealprice)) {
        echo "<p>Your meal at $restaurant cost you $" . number_format($total,2) . " which included a $" . number_format($tip,2) . " tip.</p>";
    } else {
        echo "<p>Please supply the missing values:</p><ul>";

        if (empty($restaurant)) {
            echo "<li>Restaurant</li>";
        }
        if (empty($mealprice)) {
            echo "<li>Meal Cost</li>";
        }
        echo "</ul>";
    }
} else {
    echo "I got here";
}

include('includes/footer.html');

?>