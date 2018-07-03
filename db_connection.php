<?php


$host = 'localhost'; // your host
$db_user = 'root'; //database user name
$db_password = ''; //database password
$db_name = 'forexml'; //database name
$db_table = 'mysentiment'; //your table name where you want to set the order


$connection = mysqli_connect($host, $db_user, $db_password) or die('Failed'); //establish DB connection
$connect_to_db = mysqli_select_db($connection, $db_name);
echo mysqli_error($connection);


?>
