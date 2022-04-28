<?php
$pageTitle="Customer Login";
include('includes/header.php');

if(isset($errors) && !empty($errors)) {
    echo "<h1>Error!</h1>";
    echo "<p>The following error(s) occurred:</p><ul>";
    foreach($errors as $msg) {
        echo "<li>" . $msg . "</li>";
    }
    echo "</ul><p>Please try again.</p>";
}

?>

<form action="cust_loginCk.php" method="POST">
    <label for="cLogin">Login:</label>
    <input type="text" name="cLogin" id="cLogin"/><br/>
    <label for="cPass">Password:</label>
    <input type="password" name="cPass" id="cPass"/><br/>
    <input type="submit" value="Login" name="Login"/>
</form>






<?php
include('includes/footer.html');
?>
