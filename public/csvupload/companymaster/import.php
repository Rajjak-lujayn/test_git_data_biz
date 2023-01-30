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
// exit;
$file_name = $_FILES['file']['name'];
$file = fopen($_FILES['file']['tmp_name'], "r");
$rows = array_map('str_getcsv', file($_FILES['file']['tmp_name']));
    $header = array_shift($rows);
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
    if ($ext == 'csv') {
if(!empty($_FILES['file']['name']))
{
  $mysqli = mysqli_init(); 
  $cons= mysqli_connect("localhost", "bizb2b","BiZB2B@123!","bizb2b") or die(mysqli_error());
 
  mysqli_options($mysqli, MYSQLI_OPT_LOCAL_INFILE, true);
   
$total_row = count(file($_FILES['file']['tmp_name']));  

 $file_location = str_replace("\\", "/", $_FILES['file']['tmp_name']);

 mysqli_select_db($cons,"csv");

$sql = "SELECT priority_flag FROM Company_Master ORDER BY company_id DESC LIMIT 1";
$result = mysqli_query($cons,$sql);
$row_cnt = $result->num_rows;
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

if($row_cnt <= 0){ $priority_flag = 1; } else{ $priority_flag = $row['priority_flag']+1; }
$query_1 = "LOAD DATA LOCAL INFILE '".$file_location."' IGNORE INTO TABLE Company_Master FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 LINES set priority_flag='". $priority_flag."'";

 if (mysqli_connect_errno($cons)){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }
  mysqli_select_db($cons,"bizb2b");
$final = mysqli_query($cons,$query_1);
if($final){
  echo "<script type=\"text/javascript\">
              alert(\"Total $total_row Data imported.\");
              window.location = 'https://data.bizprospex.com/csvupload/companymaster';
              </script>";    
} else {
  echo "<script type=\"text/javascript\">
  alert(\"Data is not imported.\");
  window.location = 'https://data.bizprospex.com/csvupload/companymaster';
  </script>";
}
  // or die(mysqli_error($cons));
 
//  $output = array(
//   'success' => 'Total <b>'.$total_row.'</b> Data imported'
//  );
 //echo "works11";
 //return json_encode($output);
//  echo json_encode($output);
// die();
}
}else{
  echo "<script type=\"text/javascript\">
alert(\"Please Upload CSV file\");
window.location = 'https://data.bizprospex.com/csvupload/companymaster';
</script>";
}
}
?>