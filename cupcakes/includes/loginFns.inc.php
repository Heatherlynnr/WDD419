<?php

//Function will take user to another page
function redirectUser($page='loggedin.php') {
    //Get the host of our page
    $url="http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    //Trims off / or \
    $url=rtrim($url,"/\\");
    //Adds / to get inside a folder and addds the php page
    $url.="/".$page;
    //Redirect the user to that page
    header("Location: $url");
    exit();
}

//Check login information
function checkLogin($dbc, $login='', $pass='') {
    //Create an error array to hold error list
    $errors=array();
    //Check to see if login info value exists
    if(!empty($login)) {
        $al=$login;
    } else {
        $errors[]="You forgot to enter your username.";
    }

    if(!empty($pass)) {
        $ap=$pass;
    } else {
        $errors[]="You forgot to enter your password.";
    }

    //If there are no errors, query database
    if(empty($errors)) {
        $q="SELECT admin_id, ad_fName FROM admin WHERE ad_login='$al' && ad_pass='$ap'";

        $r=mysqli_query($dbc, $q);

        if(mysqli_num_rows($r)==1) {
            $row=mysqli_fetch_array($r, MYSQLI_ASSOC);
            return array(TRUE, $row);
        } else {
            $errors[]="The login information does not match those on file.";
        }
    }

    return array(FALSE, $errors);
    
}

//Check login information
function custLogin($dbc, $login='', $pass='') {
    //Create an error array to hold error list
    $errors=array();
    //Check to see if login info value exists
    if(!empty($login)) {
        $cl=$login;
    } else {
        $errors[]="You forgot to enter your username.";
    }

    if(!empty($pass)) {
        $cp=$pass;
    } else {
        $errors[]="You forgot to enter your password.";
    }

    //If there are no errors, query database
    if(empty($errors)) {
        $q="SELECT user_id, first_name FROM registration WHERE user_login='$cl' && user_pass='$cp'";

        $r=mysqli_query($dbc, $q);

        if(mysqli_num_rows($r)==1) {
            $row=mysqli_fetch_array($r, MYSQLI_ASSOC);
            return array(TRUE, $row);
        } else {
            $errors[]="The login information does not match those on file.";
        }
    }

    return array(FALSE, $errors);
    
}

?>