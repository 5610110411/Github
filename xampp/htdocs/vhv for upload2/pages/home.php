<?php
	session_start();

	include("pagination.php");
	if(isset($_POST['search'])) //in case press search button
	{
		$sql = createQuery();
		$search_result = filterTable($sql);
		$search_resultForMap = filterTableForMap($sql);
		$_SESSION['firstSearch'] = 1;
	}
	else
	{
		if(!isset($_SESSION['firstSearch']))
		{ //in case 
			$_SESSION['firstSearch'] = 0;
			$sql = "SELECT * FROM people WHERE 1 AND VHV_No LIKE '%00000000000000%'";
			//echo "case 1";
		}
		else if(isset($_SESSION['lastSQL']))
		{
			$sql = $_SESSION['lastSQL'];
			//echo "case 2";
		}
		else
		{
			$sql = "SELECT * FROM people";
			//echo "case 3";
		}
		//echo "sql in else = ";
		//echo "$sql";
		$search_result = filterTable($sql);
		$search_resultForMap = filterTableForMap($sql);
	}

	// function to connect and execute the query
	function filterTable($sql)
	{
		include "../dblink.php";
		//$link = mysqli_connect("localhost", "root", "", "vhv") or die(mysqli_connect_error() . "</body></html>");
		mysqli_query($link, "SET CHARACTER SET UTF8");
		//$filter_Result = mysqli_query($link, $sql);
		$filter_Result = page_query($link, $sql, 10);
		mysqli_close($link);
		return $filter_Result;
	}

	// function to connect and execute the query
	function filterTableForMap($sql)
	{
		include "../dblink.php";
		//$link = mysqli_connect("localhost", "root", "", "vhv") or die(mysqli_connect_error() . "</body></html>");
		mysqli_query($link, "SET CHARACTER SET UTF8");
		$filter_Result = mysqli_query($link, $sql);
		//$filter_Result = page_query($link, $sql, 10);
		mysqli_close($link);
		return $filter_Result;
	}


	// fuction to create query
	function createQuery()
	{
		$IdCard = $_POST['IdCard'];
		$FirstName = $_POST['FirstName'];
		$LastName = $_POST['LastName'];
		$Tumbon = $_POST['Tumbon'];
		$IdCard = $_POST['IdCard'];
		$VHV_No = $_POST['VHV_No'];
		$Moo = $_POST['Moo'];

		if(empty($IdCard) && empty($FirstName) && empty($LastName) && empty($Tumbon) && empty($IdCard) && empty($VHV_No) && empty($Moo)){
			return "SELECT * FROM people WHERE 1 AND VHV_No LIKE '%00000000000000%'";
		}else{
			$sql = "SELECT * FROM people WHERE 1";
			
			if($IdCard && !empty($IdCard))
			{
				$sql .= " AND IdCard LIKE '%".$IdCard."%'";
			}
			if($FirstName && !empty($FirstName))
			{
				$sql .= " AND FirstName LIKE '%".$FirstName."%'";
			}
			if($LastName && !empty($LastName))
			{
				$sql .= " AND LastName LIKE '%".$LastName."%'";
			}
			if($Tumbon && !empty($Tumbon))
			{
				$sql .= " AND Tumbon LIKE '%".$Tumbon."%'";
			}
			if($VHV_No && !empty($VHV_No))
			{
				$sql .= " AND VHV_No LIKE '%".$VHV_No."%'";
			}
			if($Moo && !empty($Moo))
			{
				$sql .= " AND Moo LIKE '%".$Moo."%'";
			}
		}
		$_SESSION['lastSQL'] = $sql;
		//echo "$sql";
		return $sql;
	}
?>

<?php
//session_start();
if(!isset($_SESSION['ses_id'])){
        echo "<meta http-equiv='refresh' content='1;URL=../index.php'>";
    }else if($_SESSION['status'] != 1){
		echo "<meta http-equiv='refresh' content='1;URL=logout.php'>";
	}else{
?>

<!doctype html>
<html>
<head>
<title>ระบบ GIS อสม. สมุย</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<style>
	
	#map{
      height:450px;
      width:100%;
    }

	h1
	{
	color: #99CC00;
	margin: 0px 0px 20px;
	padding: 20px 0px 10px;
	font: bold 30px Verdana, Arial, Helvetica, sans-serif;
	border-bottom: 1px dashed #E6E8ED;
	}

	.centered-form .panel
	{
    	background: rgba(255, 255, 255, 0.8);
    	box-shadow: rgba(0, 0, 0, 0.3) 1px 4px 9px;
	}
</style>

<script>
</script>
</head>
<body>
<script>
					var person = {};
					var firstname = {};
					var lastname = {};
					var lat = {};
					var long = {};
					var number = 0;
</script>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="http://www.kohsamuicity.go.th/frontpage">เทศบาลนครเกาะสมุย</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="http://www.kohsamuicity.go.th/frontpage">หน้าหลัก</a></li>
      <li><a href="#">ระบบ GIS อสม.</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <!--li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li-->
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> ออกจากระบบ</a></li>
    </ul>
  </div>
</nav>
<div class="container">
<h1 align="center">ระบบสารสนเทศภูมิศาสตร์ อสม. อำเภอเกาะสมุย</h1>
	<div class="container">
        <div class="row centered-form">
            <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
                <div class="panel panel-default">
					<div class="panel-heading">
                        <h3 class="panel-title text-center">ค้นหาข้อมูล อสม.</h3>
                    </div>
                    <div class="panel-body">
                        <form action="home.php" method="post">
							<div class="form-group">
                                <input type="text" name="IdCard" class="form-control input-sm" placeholder="เลขประจำตัวประชาชน">
                            </div>
							<div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="FirstName" class="form-control input-sm" placeholder="ชื่อ">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="LastName" class="form-control input-sm" placeholder="นามสกุล">
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="Tumbon" class="form-control input-sm" placeholder="ตำบล">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="Moo" class="form-control input-sm" placeholder="หมู่ที่">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" name="VHV_No" class="form-control input-sm" placeholder="เลขที่บัตร อสม.">
                            </div>
						
							<button type="submit" name="search" class="btn btn-info btn-block">
        						<span class="glyphicon glyphicon-search"></span>  ค้นหา
      						</button>
                    
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<form method="get" action="../pages/profile.php">
			
				<?php 
					if(mysqli_num_rows($search_result) == 0 && mysqli_num_rows($search_resultForMap) == 0 && $_SESSION['firstSearch'] == 0)
					{
						echo '<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-5">- กรุณากรอกข้อมูลเพื่อค้นหา -</div>';
					}
					else if(mysqli_num_rows($search_result) == 0 && mysqli_num_rows($search_resultForMap) == 0)
					{
						echo '<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-5">- ไม่พบข้อมูลที่ค้นหา -</div>';
					}
					else
					{?>
					<table class="table table-striped table-responsive-md btn-table">
						<?php echo "ข้อมูลลำดับที่: " . page_start_row() . " - " . page_stop_row() . " จากทั้งหมด: " . page_total_rows(); ?>
						<tr>
							<th><?php echo 'เลขที่บัตร อสม.';?></th>
							<th><?php echo 'คำนำหน้า';?></th>
							<th><?php echo 'ชื่อ';?></th>
							<th><?php echo 'นามสกุล';?></th>
							<th><?php echo 'ตำบล';?></th>
							<th><?php echo 'หมู่';?></th>
							<th><?php echo 'ข้อมูลเพิ่มเติม';?></th>
						</tr>
            <?php while($row = mysqli_fetch_array($search_result)):?>			
							<tr>
								<td><?php echo $row['VHV_No'];?></td>
								<td><?php echo $row['Title'];?></td>
								<td><?php echo $row['FirstName'];?></td>
								<td><?php echo $row['LastName'];?></td>
								<td><?php echo $row['Tumbon'];?></td>
								<td><?php echo $row['Moo'];?></td>
								<td>
									<button data-id="p<?php echo $row['VHV_No'];?>" class="btn btn-default" type="text" name="regName" value="<?php echo $row['VHV_No'];?>">รายละเอียด</button>
								</td>
							</tr>
            <?php endwhile;?>
					<?php } //end of else?>
          </table>
						
					<?php while($row = mysqli_fetch_array($search_resultForMap)):?>			
						<script>
							person[number] = <?php echo $row['VHV_No'];?>;
							firstname[number] = "<?php echo $row['FirstName'];?>";
							lastname[number] = "<?php echo $row['LastName'];?>";
							lat[number] = <?php echo $row['Latitude'];?>;
							long[number] = <?php echo $row['Longitude'];?>;
							number++;
						</script>
					<?php endwhile;?>

			<div align="center">
				<?php
					page_echo_pagenums(6, true);
				?>
			</div>
			
				<div>
					<div id="map"></div>
				</div>
			
			
		</form>
  <script>
		/*
		for(count = 0 ; count <= i; count++){
			console.log(count)
			console.log(person[count]);
			console.log(firstname[count]);
			console.log(lat[count]);
			console.log(long[count]);
			console.log("------------");
		}
		*/

		// Array of markers
		var markers = [];
		var coords = [];
		for (var count = 0; count < number; count++) {
			markers[count] = {
				coords: {
					lat: lat[count],
					lng: long[count]
				},
				content: '<h1>' + firstname[count] + ' ' + lastname[count] + '</h1>'
			};
		}
		//console.log(markers);

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

        // Check for customer icon
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
</body>
</html>
<?php
	}
?>
