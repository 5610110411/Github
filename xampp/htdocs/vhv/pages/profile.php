<?php

  session_start();

  $search_result = "";

  if(isset($_GET['regName']))
  {
    $search_result = showProfile();
  }else if(isset($_GET['deleteProfile']))
  {
    deleteProfile();
  }else if(isset($_GET['editProfile']))
  {
    editProfile();
  }
  else{
  }
  /*
  $action = isset($_GET['action']) ? $_GET['action'] : '';

  switch ($action) {
	
    case 'regName' :
      showProfile();
      break;
      
    
      
    case 'deleteProfile' :
      deleteProfile();
      
      break;
    
      
  
    default :
        // if action is not defined or unknown
      // move to main product page
      echo "default";
      //header('Location: home.php');
  }
  */

  function editProfile()
  {
    $editProfile = $_GET['editProfile'];
    header('Location: editProfile.php?editProfile='.$editProfile);
  }

  function deleteProfile()
  {
    $deleteProfile = $_GET['deleteProfile'];
    $sql = createQueryForDeleteProfile($deleteProfile);
    $search_result = filterTable($sql);
    header('Location: home.php');
  }
  
  function showProfile()
  {
    $regValue = $_GET['regName'];
    $sql = createQueryForShowProFile($regValue);
    $search_result = filterTable($sql);
    return $search_result;
  }
  
  function createQueryForDeleteProfile($key)
	{
		$sql = "DELETE FROM people WHERE VHV_No LIKE '$key'";
		return $sql;
  }
  
  function createQueryForShowProFile($key)
	{
		$sql = "SELECT * FROM people WHERE VHV_No LIKE '$key'";
		return $sql;
	}

  function filterTable($sql)
	{
		//$link = mysqli_connect("localhost", "root", "", "vhv") or die(mysqli_connect_error() . "</body></html>");
    include "../dblink.php";
    mysqli_query($link, "SET CHARACTER SET UTF8");
    $filter_Result = mysqli_query($link, $sql);
    mysqli_close($link);
		return $filter_Result;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/bootstrapPaper.css">
  <title>My Google Map</title>
  <style>
    #map{
      height:450px;
      width:100%;
    }
    
    .user-row {
        margin-bottom: 14px;
    }

    .user-row:last-child {
        margin-bottom: 0;
    }

    .dropdown-user {
        margin: 13px 0;
        padding: 5px;
        height: 100%;
    }

    .dropdown-user:hover {
        cursor: pointer;
    }

    .table-user-information > tbody > tr {
        border-top: 1px solid rgb(221, 221, 221);
    }

    .table-user-information > tbody > tr:first-child {
        border-top: 0;
    }
    .table-user-information > tbody > tr > td {
        border-top: 0;
    }
    .toppad
    {margin-top:20px;
    }

  </style>
</head>
<body>
<!--  =================== Top bar============================================   -->
  <?php include('topbar.php'); ?>
<!--  =================== Top bar============================================   -->
  <div class="container"> 
    <div class="row">
        <div class="col-md-5  toppad  pull-right col-md-offset-3 ">
            <!--p class=" text-info">May 05,2014,03:00 pm </p-->
        </div>
    </div>
    <div>
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">ข้อมูลประจำตัวอาสาสมัครสาธารณสุขประจำหมู่บ้าน(อสม.)</h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="pictures/male.png" class="img-circle img-responsive"> </div>
            
            <!--<div class="col-xs-10 col-sm-10 hidden-md hidden-lg"> <br>
              <dl>
                <dt>DEPARTMENT:</dt>
                <dd>Administrator</dd>
                <dt>HIRE DATE</dt>
                <dd>11/12/2013</dd>
                <dt>DATE OF BIRTH</dt>
                    <dd>11/12/2013</dd>
                <dt>GENDER</dt>
                <dd>Male</dd>
              </dl>
            </div>-->

            <?php $row = mysqli_fetch_array($search_result)?>



            <div class=" col-md-9 col-lg-9 "> 
              <table class="table table-user-information">
                <tbody>
                  <tr>
                    <td>ชื่อ-นามสกุล</td>
                    <td><?php echo $row['Title'];?><?php echo $row['FirstName'];?> <?php echo $row['LastName'];?></td>
                  </tr>
                  <tr>
                    <td>ที่อยู่:</td>
                    <td><?php echo $row['Address'];?> หมู่ <?php echo $row['Moo'];?> ตำบล<?php echo $row['Tumbon'];?> </td>
                  </tr>
                  <tr>
                    <td>เลขประจำตัวประชาชน:</td>
                    <td><?php echo $row['IdCard'];?></td>
                  </tr>
                  <tr>
                    <td>เลขที่บัตร อสม.</td>
                    <td><?php echo $row['VHV_No'];?></td>
                  </tr>
                  <tr>
                    <td>ได้รับการแต่งตั้งเป็น อสม. ปี:</td>
                    <td><?php echo $row['StartYear'];?></td>
                  </tr>
                  <tr>
                    <td>หมู่โลหิต:</td>
                    <td><?php echo $row['BloodType'];?></td>
                  </tr>
                  <tr>
                    <td>วันเกิด:</td>
                    <td><?php echo $row['Birthday'];?></td>
                  </tr>
                  <tr>
                    <td>วุฒิการศึกษา</td>
                    <td><?php echo $row['Education'];?></td>
                  </tr>
                  <tr>
                    <td>อาชีพ</td>
                    <td><?php echo $row['Job'];?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="panel-footer">
          <button onclick="location.href='home.php'" type="button" class="btn btn-primary glyphicon glyphicon-menu-left">ย้อนกลับ</button>    
          <!--a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
              <!--span class="pull-right">
                  <a href="edit.html" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                  <a data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
              </span-->
        </div>
      </div>
    </div>


    <div class='panel'>
      <div id="map"></div>
      <script>
        function initMap(){
          // Map options
          var options = {
            zoom:11,
            center:{lat:9.5159098,lng:100.0016761}
          }

          // New map
          var map = new google.maps.Map(document.getElementById('map'), options);

          // Listen for click on map
          /*
          google.maps.event.addListener(map, 'click', function(event){
            // Add marker
            addMarker({coords:event.latLng});
          });
          */

          /*
          // Add marker
          var marker = new google.maps.Marker({
            position:{lat:42.4668,lng:-70.9495},
            map:map,
            icon:'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'
          });

          var infoWindow = new google.maps.InfoWindow({
            content:'<h1>Lynn MA</h1>'
          });

          marker.addListener('click', function(){
            infoWindow.open(map, marker);
          });
          */

          // Array of markers
          var markers = [
            /*{
              coords:{lat:42.4668,lng:-70.9495},
              iconImage:'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
              content:'<h1>Lynn MA</h1>'
            },*/
            {
              coords:{lat:<?php echo $row['Latitude']; ?>,lng:<?php echo $row['Longitude']; ?>},
              content:'<h1><?php echo $row['Title'];?><?php echo $row['FirstName'];?> <?php echo $row['LastName'];?><br> (<?php echo $row['Latitude'];?>, <?php echo $row['Longitude'];?>)</h1>'
            
            },
            {
              //coords:{lat:42.7762,lng:-71.0773}
            }
          ];

          // Loop through markers
          for(var i = 0;i < markers.length;i++){
            // Add marker
            addMarker(markers[i]);
          }

          // Add Marker Function
          function addMarker(props){
            var marker = new google.maps.Marker({
              position:props.coords,
              map:map,
              //icon:props.iconImage
            });

            // Check for customicon
            if(props.iconImage){
              // Set icon image
              marker.setIcon(props.iconImage);
            }

            // Check content
            if(props.content){
              var infoWindow = new google.maps.InfoWindow({
                content:props.content
              });

              marker.addListener('click', function(){
                infoWindow.open(map, marker);
              });
            }
          }
        }
      </script>
      <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4A_oI1Apm1v0b2jKI4T3RBLqHU0q3Xk4&callback=initMap">
      </script>
    </div>
  </div>
    

  <?php include('footer.php');?>
</body>
</html>
