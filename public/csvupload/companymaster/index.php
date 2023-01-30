<!DOCTYPE html>
<html>
 <head>
  <title>Import Data</title>  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
 <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
    <a href="https://data.bizprospex.com/csvupload/">
    <img src="https://data.bizprospex.com/storage/app/logo/thumb-816x460-logo-61cd4610acfe4.png" alt="bizb2b" class="tooltipHere main-logo" title="" data-placement="bottom" data-toggle="tooltip" data-original-title="" style="width:110px;height:40px;">
</a>
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
   <h1 align="center">Import Master Data</h1>
   <br />
   <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title">Import</h3>
    </div>
      <div class="panel-body">
       <span id="message"></span>
       <form id="sample_form" action="import.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
        <div class="form-group">
         <label class="col-md-4 control-label">Select CSV File</label>
         <input type="file" name="file" id="file" accept=".csv" />
        </div>
        <div class="form-group" align="center">
         <input type="hidden" name="hidden_field" value="1" />
         <input type="submit" name="import" id="import" class="btn btn-info" value="Import" />
        </div>
       </form>
       <!-- progess Bar  -->
       <div class="form-group" id="process" style="display:none;">
          <div class="progress">
            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="">
            </div>
          </div>
       </div>
       <!-- progress Bar -->
      </div>
     </div>
  </div>
 </body>
</html>

<script>
 
//  $(document).ready(function(){

//   $('#sample_form').on('submit', function(event){
//    $('#message').html('');
//    event.preventDefault();
//       $.ajax({
//         url:"import.php",
//         method:"POST",
//         data: new FormData(this),
//         dataType:"json",
//         contentType:false,
//         cache:false,
//         processData:false,
//         success:function(response)
//         {
//         $('#message').html('<div class="alert alert-success">'+response.success+'</div>');
//         $('#sample_form')[0].reset();
//         }
//       })
   
//   });

//  });
</script>
