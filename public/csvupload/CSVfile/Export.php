<?php
  
     // Initialize a file URL to the variable
    // $url = 
    // 'https://www.bizprospex.com/csvupload/CSVfile/mod_niteshpandit.zip';
      
    // // Use basename() function to return the base name of file
    // $file_name = basename($url);
      
    // // Use file_get_contents() function to get the file
    // // from url and use file_put_contents() function to
    // // save the file by using base name
    // if (file_put_contents($file_name, file_get_contents($url)))
    // {
    //     echo "File downloaded successfully";
    // }
    // else
    // {
    //     echo "File downloading failed.";
    // }

    $URL = 'https://www.bizprospex.com/csvupload/CSVfile/mod_niteshpandit.zip'; 
    $FileToSave = "https://www.bizprospex.com/csvupload/";   
    $Content = file_get_contents($URL);
    file_put_contents($FileToSave, $Content);
    ?>