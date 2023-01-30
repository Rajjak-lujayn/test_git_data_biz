
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>CSV</title>
    <style>
  .import-data-section button.button.button1 {cursor: pointer;display: inline-block;font-size: 19px;background-color: rgb(83 164 243);color: rgb(255 255 255)!important;transition: all .5s ease 0s;border-radius: 7px;padding: 10px 25px;border-width: 0!important;}

.import-data-section .form-group:last-child {margin: 0; }

.import-data-section {max-width: 700px;
    margin: auto; border: 1px solid #fff;border-radius: 10px;box-shadow: 0 0 21px rgb(0 0 0 / 9%);padding: 20px;}

.import-data-section h3.panel-title {font-size: 25px;font-weight: bold;margin-bottom: 20px;text-align: center;}

.import-data-section .panel-heading {padding: 0; }

.import-data-section .panel-body {padding: 0; }
    </style>
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
   <h1 align="center">Import Data</h1>
   <br />
   <div class="import-data-section">
    <div class="panel-heading">
     <h3 class="panel-title">Import</h3>
    </div>
      <div class="panel-body">
      
            <div class="form-group" align="center">
            <a href="https://data.bizprospex.com/csvupload/companymaster/">
            <button class="button button1">Import Master Data</button></a>
            </div>
            <div class="form-group" align="center">
            <a href="https://data.bizprospex.com/csvupload/listingmaster/">
            <button class="button button1">Import Listing Data</button></a>
            </div>
            <div class="form-group" align="center">
            <a href="https://data.bizprospex.com/csvupload/Export/Export.php">
            <button class="button button1">Download</button></a>
            </div>
     
      </div>
     </div>
  </div>
</body>
</html>