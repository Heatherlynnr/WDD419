<?php 

//Title information
$page_title="Cupcake List";

//Puts header in file
include('includes/header.php');

//Put DB connection file in page
require('db_connect.php');

//MySQL query to return cupcake ID, name, and image for cupcakes
$q="SELECT cupcake_id, cupcake_name, cupcake_img FROM cupcakes ORDER BY cupcake_name";

//Result of query; connects to database and performs query
$r=mysqli_query($dbc, $q);

//Count number of records/rows returned
$rowNum=mysqli_num_rows($r);

//Checks to see if $r holds information/query was successful
if($r) {
    //Put title and paragraph on page
    echo "<article><h1>Cupcake List</h1><p>Browse our " . $rowNum . " cupcake varieties. Click on each cupcake for more details.</p>";
    //Cycle through the records obtained by the query
    //$row = each record in query result array
    while($row=mysqli_fetch_array($r,MYSQLI_ASSOC)){
        echo '<section class="cBox">';
        //Wrap a link around the image and name
        //<a href="viewCupcake.php?cupcake_id=1"></a>
        echo '<a href="viewCupcake.php?cupcake_id=' .
        $row['cupcake_id'].'">';

        //Place cupcake image on page
        //<img src="images/redVelvet.jpg" alt="Red Velvet"/>
        echo '<img src="images/'.$row['cupcake_img']. '" alt="' .
        $row['cupcake_name']. '"/>';
        //<h3>Red Velvet</h3>
        echo '<h3>' . $row['cupcake_name'] . '</h3>';
        //Close link and section
        echo '</a></section>';
    }
    echo "</article>";

    //Close our database connection
    mysqli_close($dbc);
} else {
    echo "Sorry, your query was not successful.";
}

?>