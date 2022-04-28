<?php

if($_SERVER['REQUEST_METHOD'] =='POST') {
    require('includes/loginFns.inc.php');
    require('db_connect.php');

    list($check2, $data2) = custLogin($dbc, $_POST['cLogin'], $_POST['cPass']);

    if($check2) {
        session_start();
        $_SESSION['cID'] = $data2['user_id'];
        $_SESSION['cfName'] = $data2['first_name'];
        // echo $_SESSION['cID'];
        // echo $_SESSION['cfName'];

       redirectUser('cust_loggedin.php');
    } else {
        $errors=$data;

    }

    mysqli_close($dbc);
}

include('cust_login.php');

?>
