<?php 
$time_start = microtime(true); 

ini_set('max_execution_time', 0); 
//ini_set('display_errors', 1); 
//ini_set('display_startup_errors', 1); 
define('CRON', dirname(dirname(__FILE__)));
$parts = explode("/",__FILE__);

$ThisFile = $parts[count($parts) - 1];
chdir(substr(__FILE__,0,(strlen(__FILE__) - strlen($ThisFile))));
unset($parts);
unset($ThisFile);

	$servername = "localhost";
	$username = "bizb2b";
	$password = "BiZB2B@123!";
	$db = "bizb2b";
	$con=new mysqli($servername, $username, $password, $db);
	$query ="SELECT id,company_name FROM `listing_master` WHERE `cron_flage` = '0' AND `export` = '0' ORDER BY `id` ASC LIMIT 1500";
	$CRON_OUTPUT = $query;
	$result = $con->query($query);

	while($row = $result->fetch_assoc()) {

		
		$com =addslashes($row['company_name']);
		$query_company ='SELECT website,Industry FROM `Company_Master` WHERE `company_name` = "'.$com .'" ORDER BY priority_flag ASC';
		
		$result_company = $con->query($query_company);
		$row_company = $result_company->fetch_assoc();
		$row_web =addslashes($row_company['website']);
		$row_com =addslashes($row_company['Industry']);
		$query_update="UPDATE `listing_master` SET `website` = '".$row_web."', `Industry` = '".$row_com."', `cron_flage` = '1' WHERE `listing_master`.`id` = '".$row['id']."'";
		// echo $query_update;
		// exit;
		$results_update = $con->query($query_update);
		
	// 	$query_company = "UPDATE listing_master AS l
    //    INNER JOIN Company_Master AS b ON b.company_name = l.company_name
    //     SET l.website = b.website, l.Industry = b.Industry";
    //      $results_update = $con->query($query_company);
	}



	$query_file_search="SELECT `filename` from `File_master` where `cron_flag` = 0 order by ID ASC limit 1";
	//echo $query_file_search;
	
	$result_file = $con->query($query_file_search);
	$row_filename = $result_file->fetch_assoc();
	
	$query_filercrd_cnt="SELECT count(id) as filerecords FROM `listing_master` WHERE `filename`= '".$row_filename['filename']."'";
	
	 
	$result_filercrd_cnt = $con->query($query_filercrd_cnt);
	$row_filercrd_cnt= $result_filercrd_cnt->fetch_assoc();
    $row_filercrd_cnt['filerecords'];
	 echo $row_filercrd_cnt['filerecords'];
	$query_cnt="SELECT count(id) as updatercords FROM `listing_master` WHERE `filename`= '".$row_filename['filename']."' AND `cron_flage` = '1' AND `export` = '0' ";
	$result_cnt = $con->query($query_cnt);
	$row_result_cnt= $result_cnt->fetch_assoc();
    echo $row_result_cnt['updatercords'];
  
	if($row_filercrd_cnt['filerecords']==$row_result_cnt['updatercords'])
	{
		
		$export_query ="SELECT * FROM `listing_master` WHERE `filename`= '".$row_filename['filename']."' AND `export` = '0'";
		// echo $export_query;
		// exit;
		$res_export_query= $con->query($export_query);
		if($res_export_query->num_rows > 0){ 
		
			$delimiter = ","; 
			$uploads_dir = '/upload';
			$filename_dir = 'upload/'.$row_filename['filename'];
			$f = fopen($filename_dir, 'w'); 
   			$fields= array('DATE', 'Job Title', 'Company', 'Website', 'Industry', 'Salary', 'Remote', 'AREA', 'City', 'State', 'Zip Code'); 
   			fputcsv($f, $fields, $delimiter); 
		    while($row_export = $res_export_query->fetch_assoc()){ 
				$originalDate = $row_export['date'];
				// echo '<br>';
				// echo "orignal:";
				// echo $originalDate;
                $newDate = date("Y-m-d", strtotime($originalDate));
				// echo '<br>';
				// echo "new:";
				// echo $newDate;
				// exit;
				$lineData = array($newDate,$row_export['job_title'],$row_export['company_name'],$row_export['website'],$row_export['Industry'],$row_export['salary'],$row_export['remote'],$row_export['area'],$row_export['city'],$row_export['state'],$row_export['zipcode']); 
				fputcsv($f, $lineData, $delimiter); 

				$update_listing_master="UPDATE `listing_master` SET  `export` = '1' WHERE `listing_master`.`id` = '".$row_export['id']."'";
    			$res_update_listing = $con->query($update_listing_master);
			}  

			$query_update_filemaster='UPDATE `File_master` SET  `cron_flag` = "1" WHERE `filename` = "'.$row_filename['filename'].'"';
			$results_update_filemaster= $con->query($query_update_filemaster);
			echo "File Created for Download";
			// error_reporting(E_ALL ^ E_NOTICE); 
			/* Mail Send Logic Goes Here */
		/* $to = "nitesh.pandit.lujayninfoways@gmail.com";
       		$subject = "File ".$row_filename['filename']." is Ready for download";
         
			$message = "<b>Please visit below link to download the file</b><br/>";
			$message .= "<a href='https://data.bizprospex.com/csvupload/Export/Export.php'> Click Here</a>";
			
			// $header = "From:support@bizprospex.com \r\n";
			$header = "From:panditnitesh223@gmail.com \r\n";
			$header .= "Cc:afgh@somedomain.com \r\n";
			$header .= "MIME-Version: 1.0\r\n";
			$header .= "Content-type: text/html\r\n";
			// $headers = array("From: panditnitesh223@gmail.com",
			// 		"Reply-To: panditnitesh223@gmail.com",
			// 		"Cc:afgh@somedomain.com \r\n",
			// 		"MIME-Version: 1.0\r\n",
			// 		"Content-type: text/html; charset=iso-8859-1",
			// 		"X-Mailer: PHP/" . phpversion()
			// 	);
			// 	$headers = implode("\r\n", $headers);
			$retval = mail($to,$subject,$message,$header);
			if( $retval == true ) {
				echo "Message sent successfully...";
			}else {
				echo "Message could not be sent...";
			} */
		 /* Mail Send Logic End Here */
	
		 


		}
	
		

	}
	echo "1500 record Updated";

	$time_end = microtime(true);
	$execution_time = ($time_end - $time_start)/60;
	$CRON_OUTPUT .='<b>Total Execution Time:</b> '.$execution_time.' Mins';

$CRON_OUTPUT .= "STARTING CRON @ ".date("m-d-Y H:i:s")."\r\n";
//$CRON_OUTPUT .= CleanLog() . "\r\n";
//$CRON_OUTPUT .= "\r\n";

//echo $CRON_OUTPUT;
//$fh = fopen(''.CRON.'/log/CRON_LOG.txt', 'a');
// $fh = fopen('CRON_LOG.txt', 'a');
// fwrite($fh, $CRON_OUTPUT);
// fclose($fh);
// die();

?>
