<!DOCTYPE html>
<html>
<body>

<table width="600">
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">

<tr>
<td width="20%">Select file</td>
<td width="80%"><input type="file" name="file" id="file" /></td>
</tr>

<tr>
<td>Submit</td>
<td><input type="submit" name="submit" /></td>
</tr>

</form>
</table>

</body>
</html>
<?php 
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
if ( isset($_POST["submit"]) ) {

   if ( isset($_FILES["file"])) {

            //if there was an error uploading the file
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";

        }
        else {
                 //Print file details
             echo "Upload: " . $_FILES["file"]["name"] . "<br />";
             echo "Type: " . $_FILES["file"]["type"] . "<br />";
             echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
             echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

                 //if file already exists
         /*    */
                    //Store file in directory "upload" with the name of "uploaded_file.txt"
            $storagename = $_FILES["file"]["name"];
            move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $storagename);
            echo "Stored in: " . "uploads/" . $_FILES["file"]["name"] . "<br />";
            //}
        }
     } else {
             echo "No file selected <br />";
     }
}
?>