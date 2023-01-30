<?php

$servername = "localhost";
$username = "bizb2b";
$password = "BiZB2B@123!";
$db = "bizb2b";
$con=new mysqli($servername, $username, $password, $db);

if(isset($_GET["id"]) && isset($_GET['filename'])){
 $file = $_GET['filename'];
 $id_=$_GET['id'];
  $query="DELETE FROM `File_master` WHERE `filename` ='$file'";

  $result = $con->query($query);
  if($result){
   
    $dir = "/upload";
    $dirHandle = opendir($dir);
    while ($file1 = readdir($dirHandle)) {
        if($file1==$file) {
            unlink($file);
            echo "<script type=\"text/javascript\">
              alert(\" CSV file delted.\");
              window.location = 'https://data.bizprospex.com/csvupload/Export/Export.php';
              </script>";
        }
    }

    closedir($dirHandle);
  }
  
  
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
     <a href="https://data.bizprospex.com/csvupload/">
      <img src="https://data.bizprospex.com/storage/app/logo/thumb-816x460-logo-61cd4610acfe4.png" alt="bizb2b" class="tooltipHere main-logo" title="" data-placement="bottom" data-toggle="tooltip" data-original-title="" style="width:110px;height:40px;"></a> 
    </div>
    <ul class="nav navbar-nav">
      <li><a href="https://data.bizprospex.com/csvupload/companymaster/">Import Master Data </a></li>
      <li><a href="https://data.bizprospex.com/csvupload/listingmaster/">Import Listing Data</a></li>
      <li><a href="https://data.bizprospex.com/csvupload/Export/update_cron.php">Update Data</a></li>
       <li><a href="https://data.bizprospex.com/csvupload/Export/Export.php">Download</a></li>
    </ul>
  </div>
</nav>
<br />
  <br />
  <div class="container">
   <h1 align="center">Download CSV</h1>
   <br />
   
   <form id="sample_form" method="POST" enctype="multipart/form-data" class="form-horizontal">
                <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">No.</th>
                    <th scope="col">FileName</th>
                    <th scope="col">Date</th>
                    <th scope="col">Download</th>
                    <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['pageno'])) {
                      $pageno = $_GET['pageno'];
                   } else {
                      $pageno = 1;
                    }

                    $no_of_records_per_page = 10;
                    $offset = ($pageno-1) * $no_of_records_per_page;
                    $total_pages_sql = "SELECT COUNT(*) FROM File_master";
                    $result1 = $con->query($total_pages_sql);
                    $total_rows = mysqli_fetch_array($result1)[0];
                    
                    $total_pages = ceil($total_rows / $no_of_records_per_page);
                  $query2 ="SELECT COUNT(id) as Count FROM `File_master` WHERE `cron_flag` = '1'";
                  $result2 = $con->query($query2);
                  $row3 = $result2->fetch_assoc();
                  // ORDER BY `id` DESC LIMIT $offset, $no_of_records_per_page
                  $query = "SELECT * FROM `File_master` WHERE `cron_flag` = '1'  ORDER BY `id` DESC";
                    $result = $con->query($query);
                    $i=1;
                    while($row2 = $result->fetch_assoc()) {
                        $filename=$row2['filename'];
                        $date=$row2['created'];
                    ?>
                    <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $filename; ?></td>
                    <td><?php echo $date; ?></td>
                    <td><a href="https://data.bizprospex.com//csvupload/Export/upload/<?php echo $filename; ?>">
                 Download</a></td>
                 <td><a href="Export.php?id=<?php echo $row2['id']; ?>&filename=<?php echo $filename;?>" class="del_btn">Delete</a></td>
                    </tr>
                <?php 
                  $i++;  
                } ?>
                </tbody>
                </table>
          
</form>

</div>
</body>
</html>
