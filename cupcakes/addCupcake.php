<?php

$page_title="Add Cupcake";
include("includes/header.php");

if(!isset($_SESSION['adminID'])) {
    require('includes/loginFns.inc.php');
    redirectUser('cupcakeList.php');
}

if($_SERVER['REQUEST_METHOD']=='POST') {

    //Check for cupcake name
    if(!empty($_POST['cupName'])) {
        $cupName=$_POST['cupName'];
    } else {
        $msg.= "You must give your cupcake a name.<br/>";
    }

    //Check for cupcake description
    if(!empty($_POST['cupDesc'])) {
        $cupDesc=$_POST['cupDesc'];
    } else {
        $msg.="You must give your cupcake a description.<br/>";
    }

    //Get the size of our cupcake
    $GFOption=$_POST['GF'];

    require("db_connect.php");

    //Check to see if the cupcake is GF
    if($GFOption=="yes") {
        //Query the database to get to the sizes
        $q="SELECT size_id FROM size WHERE size_id LIKE '%GF%'";

        $r=mysqli_query($dbc, $q);

        //Check to see if records were returned
        if($r) {
            while($row=mysqli_fetch_all($r, MYSQLI_NUM)) {
                //Set each row value to variable
                $regSize=$row[0][0];
                $miniSize=$row[1][0];
            } //Closes while statement
        } //Closes if $r has value
    } // Closes if GF=yes
    elseif($GFOption=="no") {
        //Query the database to get the sizes
        $q2="SELECT size_id FROM size WHERE size_id NOT LIKE '%GF%'";

        $r2=mysqli_query($dbc, $q2);

        //Check to see if records were returned
        if($r2) {
            while($row2=mysqli_fetch_all($r2, MYSQLI_NUM)) {
                //Set each row value to variable
                $regSize=$row2[0][0];
                $miniSize=$row2[1][0];
            } // Closes while statement
        } // Closes if $r has value
    } // Closes our elseif

    //check and load image
    if(!empty($_FILES['upload'])) {
        //hold the file name
        $target_name=$_FILES['upload']['name']; //ex funCupcake.jpg
        //point to directory where we want to place the image
        $traget_dir="images/";
        $target_file=$target_dir . $target_name; // ex. images/funCupcake.jpg
        //get the file extension to make sure it is proper file type
        $target_fileType=strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        //flag for appropriate file upload
        $uploadOK = 1;

        echo "File: " . $target_file;
        echo "Extension: " . $target_fileType;

        //check to make sure its the right file type
        if($target_fileType!='jpeg' && $target_fileType!="gif" && $target_fileType!="png" && $target_fileType!='jpg') {
            echo 'Sorry - only JPEG, JPG, GIF, or PNG files are allowed.';
            $uploadOK=0;
        }
    }

    //check the uploadOK status
    if($uploadOK==0) {
        echo 'Sorry, your file could not be uploaded due to the following error:';

        //cycle through multiple eorror messages
        switch($_FILES['upload']['error']) {
            case 1:
                echo 'The file exceeds the maximum file size.';
                break;
            case 3:
                echo 'The file was only partially uploaded.';
                break;
            case 4:
                echo 'No file was uploaded.';
                break;
            case 7:
                echo 'Unable to write to disk.';
                break;
            default:
                echo 'A system error occurred.';
                break;
        } // closes switch statement
        //helps for transaction
        $readytocommit=FALSE;
    } // closes if uploadOK=0
    else { //if uploadOK = 1
        //check if name and description are set
        if($cupName && $cupDesc) {
            //upload the file to temp
            if(move_uploaded_file($_FILES['upload']['tmp_name'])) {
                echo "The file " . basename($_FILES['upload']['name']) . " was uploaded.";
            }
            $readytocommit=TRUE;
            //get rid of temp link
            if(file_exists($_FILES['upload']['tmp-name']) && is_file($_FILES['upload']['tmp-name'])) {
                unlink($_FILES['upload']['tmp-name']);
            }
        }//end of name, desc, and file
    }//end of else
} //Closes server method
    //TRANSACTION
    if($readytocommit) {
        //turn off autocommit of queries
        mysqli_autocommit($dbc, FALSE);
        $flag=TRUE;

        //add img, desc, and name to the cupcake table

        $q="INSERT INTO cupcakes (cupcake_name, cupcake_desc, cupcake_img) VALUES ('$cupName', '$cupDesc,' '$target_name')";

        $r=mysqli_query($dbc, $q);

        if(!$r) {
            $flag=FALSE;
            echo "First query error: " . mysqli_error($dbc);
        }

        //query database to get new cupcake ID
        $q1="SELECT cupcake_id FROM cupcakes WHERE cupcake_name='$cupName'";

        $r2=mysqli_query($dbc, $q2);

        if(!r2) {
            $flag=FALSE;
            echo "Second query error: " . mysqli_error($dbc);
        } else {
            //query worked; set ID = variable
            $row2=mysqli_fetch_array($r2, MYSQLI_NUM);
            $newccID=$row2[0][0];
        }

        //insert size information
        $q3="INSERT INTO size (cupcake_id, size) VALUES ('$newccID', '$miniSize'), ('$newccID', '$regSize')";

        $r3=mysqli_query($dbc, $q3);

        if(!$r3) {
            $flag=false;
            echo 'Failed to insert size' . $mysqli_error($dbc);
        }

        //see if flag = true
        if($flag) {
            mysqli_commit($dbc);
            echo "Your cupcake was added to the database.";
        } else {
            mysqli_rollback($dbc);
            echo "Cupcake was not added.";
        }

        mysqli_close($dbc);

    }
echo $msg;

?>

<form action="addCupcake.php" method="post" enctype="multipart/form-data">
    <label for="cupName">Cupcake Name: </label>
    <input type="text" name="cupName" id="cupName" /><br/>
    <label for="cupDesc">Cupcake Description: </label>
    <textarea name="cupDesc" id="cupDesc" placeholder="Please describe product here."></textarea><br/>
    <label for="glutenFree">Is this cupcake gluten free?</label>
    <input type="radio" name="GF" value="yes" id="yes"/>
    <label for="yes">Yes</label><br/>
    <input type="radio" name="GF" value="no" id="no" checked/>
    <label for="no">No</label><br/>
    <input type="hidden" name="MAX_FILE_SIZE" value="500000"/>
    <label for="cupImg">Cupcake Image: </label>
    <input type="file" name="upload" id="cupImg"/><br/>
    <input type="submit" name="submit" value="Add Cupcake"/>
</form>