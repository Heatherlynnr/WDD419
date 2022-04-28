<?php
$pageTitle="Administrative Login";
// include('includes/header.php');

if(isset($errors) && !empty($errors)) {
    echo "<h1>Error!</h1>";
    echo "<p>The following error(s) occurred:</p><ul>";
    foreach($errors as $msg) {
        echo "<li>" . $msg . "</li>";
    }
    echo "</ul><p>Please try again.</p>";
}

?>

<form action="admin_loginCk.php" method="POST">
    <label for="adminLogin">Login:</label>
    <input type="text" name="adminLogin" id="adminLogin"/><br/>
    <label for="adminPass">Password:</label>
    <input type="password" name="adminPass" id="adminPass"/><br/>
    <input type="submit" value="Login" name="Login"/>
</form>






<?php
include('includes/footer.html');
?>
