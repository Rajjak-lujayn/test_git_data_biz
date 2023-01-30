<?php
if(isset($_POST['import'])){
 
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
ini_set('upload_max_filesize', '64M');
ini_set('post_max_size', '64M');
ini_set('max_execution_time', 300);
//ini_set('memory_limit', '512M');
ini_set('memory_limit', '-1');
error_reporting(E_ALL);
//print_r($_FILES);
$file_name = $_FILES['file']['name'];
$file = fopen($_FILES['file']['tmp_name'], "r");
$rows   = array_map('str_getcsv', file($_FILES['file']['tmp_name']));
    $header = array_shift($rows);
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
    if ($ext == 'csv') {
    
if(!empty($_FILES['file']['name']))
{
   
  $mysqli = mysqli_init(); 
  $cons= mysqli_connect("localhost", "bizb2b","BiZB2B@123!","bizb2b") or die(mysqli_error());
 
  mysqli_options($mysqli, MYSQLI_OPT_LOCAL_INFILE, true);
  $filequery='SELECT DISTINCT `filename` FROM listing_master WHERE `filename` = ("'.$_FILES['file']['name'].'")';
   
   $file_query= mysqli_query($cons,$filequery);
   $row = mysqli_fetch_array($file_query, MYSQLI_ASSOC);
  
   if($row['filename'] == ''){
$total_row = count(file($_FILES['file']['tmp_name'])) -1;  

 $file_location = str_replace("\\", "/", $_FILES['file']['tmp_name']);

$query_1 = "LOAD DATA LOCAL INFILE '".$file_location."' IGNORE INTO TABLE listing_master  FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 LINES set filename='". $_FILES['file']['name']."',cron_flage ='0', export ='0'";
$query_2 ='INSERT INTO `File_master`(`filename`, `cron_flag`) VALUES (("'.$_FILES['file']['name'].'"),0)';

 if (mysqli_connect_errno($cons)){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }
 mysqli_select_db($cons,"bizb2b");
$final1 = mysqli_query($cons,$query_1);
$final2 = mysqli_query($cons,$query_2);
// or die(mysqli_error($cons))
if($final1){
  
  echo "<script type=\"text/javascript\">
  alert(\"Total $total_row Data imported.\");
  window.location = 'https://data.bizprospex.com/csvupload/listingmaster';
  </script>";    
} else {

echo "<script type=\"text/javascript\">
alert(\"Data is not imported.\");
window.location = 'https://data.bizprospex.com/csvupload/listingmaster';
</script>";
}
//  $output = array(
//   'success' => 'Total <b>'.$total_row.'</b> Data imported. You Can Download CSV file By Click On Export Button In Menu.'
//  );

//  echo json_encode($output);
}else{
  echo "<script type=\"text/javascript\">
    alert(\"file name already exists.\");
    window.location = 'https://data.bizprospex.com/csvupload/listingmaster';
    </script>";
}
}
}else{
  echo "<script type=\"text/javascript\">
  alert(\"Please upload CSV file.\");
  window.location = 'https://data.bizprospex.com/csvupload/listingmaster';
  </script>";
 
// echo "please insert CSV file";
}
}
?>