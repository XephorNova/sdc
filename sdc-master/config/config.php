<?php 
    $DB_HOST = 'localhost';
    $DB_USERNAME = 'root';
    $DB_PASS = 'root';
    
    //Create a connection
    $connec = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASS);
    //Check the connection
  if(!$connec) {
    echo mysqli_connect_error();
  }
  //Check if database exist
  if(!mysqli_select_db($connec, 'instances')) {
    echo 'database not found';
  }
?>
