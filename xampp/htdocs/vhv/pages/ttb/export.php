<?php  
      $sqlForExport = "";

      if(isset($_GET['export']))
      {
            $sqlForExport = $_GET['export'];;
      }
 if(isset($_POST["export"]))  
 {  
      include "../../dblink_ttb.php";
      //$connect = mysqli_connect("localhost", "root", "", "vhv"); 
      
      header('Content-Encoding: UTF-8'); 
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=Data_'. date('Ymd') .'.csv');  
      
      /*
      header("Content-Type: application/x-msexcel; name=\"report.xls\"");
	header("Content-Disposition: inline; filename=\"report.xls\"");
      header("Pragma: no-cache");
      */
      $output = fopen("php://output", "w"); 
      fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
      fputcsv($output, array('Name', 'Age', 'Address', 'Equipment', 'Telephone', 'Picture', 'IdCard', 'Disease', 'Latitude', 'Longitude', 'Type', 'Status', 'Created', 'Modified', 'Accessed', 'Birthday'));  
      $query = $sqlForExport;
      
      //fputcsv($output, array('เลขประจำ', echo $query, 'FirstName', 'LastName', 'Latitude', 'Longitude', 'Address', 'Moo', 'Tumbon', 'Birthday', 'StartYear', 'Education', 'Job', 'BloodType', 'VHV_No', 'Line_ID', 'Picture'));  
      
      //$query = $sqlForExport;
      //echo $query;
      $query = "SELECT * from patient ORDER BY IdCard DESC"; 

      mysqli_query($link, "SET CHARACTER SET UTF8");
      $result = mysqli_query($link, $query);
      while($row = mysqli_fetch_array($result))
      //while($row = mysqli_fetch_assoc($result))  
      {  
           //fputcsv($output, $row);
           fputcsv($output, array($row['Name'], $row['Age'], $row['Address'], 
                                  $row['Equipment'], $row['Telephone']."\r",
                                  $row['Picture'], $row['IdCard'], 
                                  $row['Disease'], $row['Latitude'],
                                  $row['Longitude'], $row['Type'], 
                                  $row['Status'], $row['Created'], 
                                  $row['Modified'], $row['Accessed'], $row['Birthday']));
      }  
      fclose($output);
      
 }  
 ?>  

 




 