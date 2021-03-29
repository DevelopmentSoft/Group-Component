<?php
require_once("dbconn.php");
$query = "Select * From `contribution_tb`";
$result = mysqli_query($conn,$query);
$error ="";
//if(extension_loaded('zip'))
//      {
          // Checking files are selected
          $zip = new ZipArchive(); // Load zip library
          $zip_name = "Download" .time().".zip"; // Zip name
     $zippath = "zipfile/";
          if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE)
          {
              // Opening zip file to load files
              $error .= "* Sorry ZIP creation failed at this time";
          }

          while($row = mysqli_fetch_array($result)) 
          { 
                $files[] = $row["File"];

                    // write the BLOB Content to the file
                 if ( file_put_contents($row["File"], $row["filedata"]) === FALSE ) {
                     echo "Could not write PDF File";
                   }
          }
          foreach($files as $file)
                {
                    $zip->addFile($file); // Adding files into zip
                }
              $zip->close(); 

          if(file_exists($zip_name))
          {
               // push to download the zip
               header('Content-type: application/zip');
               header('Content-Disposition: attachment; filename="'.$zip_name.'"');

               readfile($zip_name);
               // remove zip file is exists in temp path
               unlink($zip_name);
           }else{
               $error .= "* Fail";
           }
//      }
//      else
//      {
//           $error .= "* You dont have ZIP extension";
//      }
echo $error;
?>