<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
if(!empty($_FILES['file']['name']))
{
  $mysqli = mysqli_init(); 
    $cons= mysqli_connect("localhost", "bizb2b","BiZB2B@123!","bizb2b") or die(mysqli_error());
 
    mysqli_options($mysqli, MYSQLI_OPT_LOCAL_INFILE, true);
   
$total_row = count(file($_FILES['file']['tmp_name']));

 $file_location = str_replace("\\", "/", $_FILES['file']['tmp_name']);

$query_1 = "LOAD DATA LOCAL INFILE '".$file_location."' IGNORE INTO TABLE lr_listing FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\r\n'  IGNORE 1 LINES";

 if (mysqli_connect_errno($cons)){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }
 mysqli_select_db($cons,"bizb2b");
 mysqli_query($cons,$query_1) or die(mysqli_error($cons));
 
 

 $output = array(
  'success' => 'Total <b>'.$total_row.'</b> Data imported'
 );

 echo json_encode($output);
}

?>