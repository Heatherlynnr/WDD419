<?php 

//Create constant variables for database info so it cannot be changed.
//Local database
//DEFINE('DB_USER', 'root');
//DEFINE('DB_PASSWORD', 'root');
//DEFINE('DB_HOST', 'localhost');
//DEFINE('DB_DATABASE', 'Cupcakes');

//Trevor database
DEFINE('DB_USER', 'hlcurtis');
DEFINE('DB_PASSWORD', 'dHLw973qQ8jem7Uz');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_DATABASE', 'hlcurtis');

//Variable that will hold the connection.

$dbc=@mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE)
OR DIE('Could not connect to the database.'.mysqli_connect_error() );

?>