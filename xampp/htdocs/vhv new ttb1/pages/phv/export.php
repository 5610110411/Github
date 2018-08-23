<?php  
      $sqlForExport = "";

      if(isset($_GET['export']))
      {
            $sqlForExport = $_GET['export'];;
      }
 if(isset($_POST["export"]))  
 {  
      $connect = mysqli_connect("localhost", "root", "", "vhv"); 
      
      header('Content-Encoding: UTF-8'); 
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=รายชื่ออสม_'. date('Ymd') .'.csv');  
      
      /*
      header("Content-Type: application/x-msexcel; name=\"report.xls\"");
	header("Content-Disposition: inline; filename=\"report.xls\"");
      header("Pragma: no-cache");
      */
      $output = fopen("php://output", "w"); 
      fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
      //fputcsv($output, array('IdCard', 'Title', 'FirstName', 'LastName', 'Latitude', 'Longitude', 'Address', 'Moo', 'Tumbon', 'Birthday', 'StartYear', 'Education', 'Job', 'BloodType', 'VHV_No', 'Line_ID', 'Picture'));  
      $query = $sqlForExport;
      
      fputcsv($output, array('เลขประจำ', echo $query, 'FirstName', 'LastName', 'Latitude', 'Longitude', 'Address', 'Moo', 'Tumbon', 'Birthday', 'StartYear', 'Education', 'Job', 'BloodType', 'VHV_No', 'Line_ID', 'Picture'));  
      
      $query = $sqlForExport;
      echo $query;
      //$query = "SELECT * from people ORDER BY IdCard DESC"; 

      mysqli_query($connect, "SET CHARACTER SET UTF8");
      $result = mysqli_query($connect, $query);
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);
      
 }  
 ?>  

 




 