<?php
ini_set('max_execution_time', 0); 
//ini_set('max_execution_time', -1);
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
ini_set('upload_max_filesize', '64M');
ini_set('post_max_size', '64M');
ini_set('memory_limit', '-1');
//error_reporting(E_ALL);
// ini_set('max_execution_time', '10000');
$servername = "localhost";
$username = "bizb2b";
$password = "BiZB2B@123!";
$db = "bizb2b";
$con=new mysqli($servername, $username, $password, $db);

 $query ="SELECT * FROM `listing_master` WHERE `cron_flage` = '0' AND `export` = '0' ORDER BY `id` LIMIT 1000";
 $result = $con->query($query);
 //$row2 = $result->fetch_assoc();
 
    while($row2 = $result->fetch_assoc()) {
        $date=$row2['date'];
        $JobTitle=$row2['job_title'];
        $Company=$row2['company_name'];
        $Website=$row2['website'];

        $Industry=$row2['Industry'];
        $remote=$row2['remote'];
        $salary=$row2['salary'];
        $area=$row2['area'];
        $city=$row2['city'];
        $state=$row2['state'];
        $zipcode=$row2['zipcode'];
        $id=$row2['id'];
        // echo '<pre>';
        // print_r($row2);
        //$query2 ='SELECT * FROM `Company_Master` WHERE `company_name` LIKE ('."$Company".')';
       $query2 ='SELECT * FROM `Company_Master` WHERE `company_name` = ("'.$Company.'")';
      $query2;
        // exit;
        $results2 = $con->query($query2);
         $row3 = $results2->fetch_assoc();
       
         $company_name2 = $row3['company_name'];
         $website2 = $row3['website'];
         $Industry2 = $row3['Industry'];
      if($company_name2 ==  $Company){
                 $query3="UPDATE `listing_master` SET `website` = '$website2', `Industry` = '$Industry2', `cron_flage` = '1' WHERE `listing_master`.`id` = $id";
                 $results3 = $con->query($query3);
      }else{
        $query_2="UPDATE `listing_master` SET  `cron_flage` = '1' WHERE `listing_master`.`id` = $id";
        $results_2 = $con->query($query_2);
      }
        //$i++;
}

$sql_count="SELECT COUNT(*) as counts FROM `listing_master` WHERE `cron_flage` = '0'";

$results_count = $con->query($sql_count);
$row_count = $results_count->fetch_assoc();

if($row_count['counts']==0){

$query4 ="SELECT * FROM `listing_master` WHERE `export` = '0'";
$results4 = $con->query($query4);
$row_cnt = $results4->num_rows;
while($row4 = $results4->fetch_assoc()) {
  $filename2[$row4['filename']]['file'][$row4['id']] = $row4['filename'];
  $filename2[$row4['filename']]['date'][$row4['id']] = $row4['date'];
  $filename2[$row4['filename']]['job_title'][$row4['id']] = $row4['job_title'];
  $filename2[$row4['filename']]['company_name'][$row4['id']] = $row4['company_name'];
  $filename2[$row4['filename']]['website'][$row4['id']] = $row4['website'];
  $filename2[$row4['filename']]['Industry'][$row4['id']] = $row4['Industry'];
  $filename2[$row4['filename']]['salary'][$row4['id']] = $row4['salary'];
  $filename2[$row4['filename']]['remote'][$row4['id']] = $row4['remote'];
  $filename2[$row4['filename']]['city'][$row4['id']] = $row4['city'];
  $filename2[$row4['filename']]['state'][$row4['id']] = $row4['state'];
  $filename2[$row4['filename']]['zipcode'][$row4['id']] = $row4['zipcode'];
  $filename2[$row4['filename']]['id'][$row4['id']] = $row4['id']; 
  
} 
foreach($filename2 as $keys => $val2){
//   echo '<pre>';
//  print_r($keys);
 
  $delimiter = ","; 
  $keys_name = explode('.', $keys);
  $uploads_dir = '/upload';
  $filename_dir = 'upload/'.$keys_name[0].'.csv';
  
   //$filename = $keys_name[0]."members-data_" . date('Y-m-d') . ".csv"; 
   
   $f[$keys_name[0]] = fopen($filename_dir, 'w'); 
   
   $fields[$keys_name[0]] = array('DATE', 'Job Title', 'Company', 'Website', 'Industry', 'Salary', 'Remote', 'AREA', 'City', 'State', 'Zip Code'); 
   fputcsv($f[$keys_name[0]], $fields[$keys_name[0]], $delimiter); 

 //$k = 0;
  foreach($val2['file'] as $vkeys => $vval){
      
      $date2 = $val2['date'][$vkeys];
      
      $job_title2 = $val2['job_title'][$vkeys];
      $company_name12 = $val2['company_name'][$vkeys];
      
      $website2 = $val2['website'][$vkeys];
      $Industry2 = $val2['Industry'][$vkeys];
       $area = $val2['area'][$vkeys];
     
      $salary2 = $val2['salary'][$vkeys];
      $remote2 = $val2['remote'][$vkeys];
      $city2 = $val2['city'][$vkeys];
      $state2 = $val2['state'][$vkeys];
      $zipcode2 = $val2['zipcode'][$vkeys];
      $id2 = $val2['id'][$vkeys];
      //$id2 = $val2['filename'][$vkeys];
      $lineData = array($date2, $job_title2, $company_name12, $website2, $Industry2, $salary2, $remote2, $area,$city2,$state2,$zipcode2,); 
     fputcsv($f[$keys_name[0]], $lineData, $delimiter); 
     $query_3="UPDATE `listing_master` SET  `export` = '1' WHERE `listing_master`.`id` = $id2";
     $results_3 = $con->query($query_3);
     
  //$k++;
  }
  
}

$filequery= "SELECT DISTINCT `filename` FROM `listing_master` WHERE `cron_flage` = 1 AND `export` = 1 ORDER BY `id` DESC";
$results_filequery = $con->query($filequery);
while($row_file = $results_filequery->fetch_assoc()){
// print_r($row_file);
$f_eport = $row_file['filename'];
 $query_update='UPDATE `File_master` SET  `cron_flag` = "1" WHERE `filename` = "'.$f_eport.'"';
$results_update = $con->query($query_update);
}
}
?>