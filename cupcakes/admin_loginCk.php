<?php

if($_SERVER['REQUEST_METHOD'] =='POST') {
    require('includes/loginFns.inc.php');
    require('db_connect.php');

    list($check, $data) = checkLogin($dbc, $_POST['adminLogin'], $_POST['adminPass']);

    if($check) {
        echo "got inside list function";
        session_start();
        $_SESSION['adminID'] = $data['admin_id'];
        $_SESSION['firstName'] = $data['ad_fName'];

        redirectUser('loggedin.php');
    } else {
        $errors=$data;
    }

    mysqli_close($dbc);
}

include('admin_login.php');

?>