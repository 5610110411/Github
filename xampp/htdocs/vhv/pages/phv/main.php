<?php
	
	$sqlForExport = "";


	include("pagination.php");
	if(isset($_POST['search'])) //in case press search button
	{
		$sql = createQuery();
		$sqlForExport = $sql;
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
			//echo $sql;
		}
		else if(isset($_SESSION['lastSQL']))
		{
			$sql = $_SESSION['lastSQL'];
			//echo $sql;
		}
		else
		{
			$sql = "SELECT * FROM people WHERE 1 AND VHV_No LIKE '%00000000000000%'";
			//echo $sql;
		}
		//echo "sql in else = ";
		//echo "$sql";
		$search_result = filterTable($sql);
		$search_resultForMap = filterTableForMap($sql);
	}

	// function to connect and execute the query
	function filterTable($sql)
	{
		include "../../dblink.php";
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
		include "../../dblink.php";
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
		$IdCard = $_POST['IdCard'];
		$VHV_No = $_POST['VHV_No'];
		

		if(empty($IdCard) && empty($FirstName) && empty($LastName) && empty($Tumbon) && empty($IdCard) && empty($VHV_No) && empty($Moo)){
			return "SELECT * FROM people WHERE 1 AND VHV_No LIKE '00000000000000'";
		}else{
			$sql = "SELECT * FROM people WHERE 1";
			
			if($IdCard && !empty($IdCard))
			{
				$sql .= " AND IdCard LIKE '$IdCard'";
			}
			if($FirstName && !empty($FirstName))
			{
				$sql .= " AND FirstName LIKE '$FirstName'";
			}
			if($LastName && !empty($LastName))
			{
				$sql .= " AND LastName LIKE '$LastName'";
			}
			
			if($VHV_No && !empty($VHV_No))
			{
				$sql .= " AND VHV_No LIKE '$VHV_No'";
			}
			
		}
		$_SESSION['lastSQL'] = $sql;
		//echo "$sql";
		return $sql;
	}
?>

<!doctype html>
<html>
<head>
<title>ระบบ GIS อสม. สมุย</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="../../css/bootstrapPaper.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
	
	#map
	{
      height:450px;
      width:100%;
	}
	
	.panel-footer {
		padding: 10px 15px;
		background-color: #f5f5f5;
		border-top: 1px solid #dddddd;
		border-bottom-right-radius: 2px;
		border-bottom-left-radius: 2px;
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

	th{
		text-align: center;
	}

	.centered-form .panel
	{
    	background: rgba(255, 255, 255, 0.8);
    	box-shadow: rgba(0, 0, 0, 0.3) 1px 4px 9px;
	}

	/*color in dropdown list Moo and Tumbon*/
	.form-control-option 
	{
		color: #808B96;
	}

	body{
		font-size:18px;
	}
	/*
	.navbar-inverse{
		color: #99CC00;
	}
	*/

	.navbar-inverse {
    	background-color: #2196f3;
    	border-color: #2196f3;
	}

	.navbar-inverse .navbar-nav>li>a {
    	color: #fff;
	}

	.navbar-inverse .navbar-brand {
    	color: #fff;
	}
	table { 
    	table-layout:fixed;
	}
	td { 
		overflow: hidden; 
		text-overflow: ellipsis; 
		word-wrap: break-word;
	}
	
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

<!--  =================== Top bar============================================   -->
<?php include('topbarNormalUser.php'); ?>

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
							<form action="main.php" method="post">
								<div class="form-group">
									<input type="text" name="IdCard" class="form-control input-sm" placeholder="เลขประจำตัวประชาชน">
								</div>
								<div class="row">
									<div class="col-xs-6 col-sm-6 col-md-6">
										<div class="form-group">
											<input type="text" name="FirstName" class="form-control input-sm" placeholder="ชื่อ" required>
										</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
										<div class="form-group">
											<input type="text" name="LastName" class="form-control input-sm" placeholder="นามสกุล"  required>
										</div>
									</div>
								</div>
								<div class="form-group">
										<input type="text" name="VHV_No" class="form-control input-sm" placeholder="เลขที่บัตร อสม.">
								</div>
								<button type="submit" name="search" class="btn btn-primary btn-block">
									<span class="glyphicon glyphicon-search"></span>  ค้นหา
								</button>			
							</form>
						</div>
						</div>
					</div>
				</div>
			</div>
			<form method="get" action="profileNormalUser.php">
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
						<table class="table table-striped table-responsive-md btn-table" style="word-wrap:break-word; overflow:hidden;">
							<?php echo "ข้อมูลลำดับที่: " . page_start_row() . " - " . page_stop_row() . " จากทั้งหมด: " . page_total_rows(); ?>
							<tr>
								<th style="width: 20%"><?php echo 'เลขที่บัตร อสม.';?></th>
								<th><?php echo 'คำนำหน้า';?></th>
								<th style="text-align: left"><?php echo 'ชื่อ';?></th>
								<th style="text-align: left"><?php echo 'นามสกุล';?></th>
								<th><?php echo 'ข้อมูลเพิ่มเติม';?></th-->
								<!--th><?php //echo 'ตำบล';?></th>
								<th><?php //echo 'หมู่';?></th-->
								<!--th><?php //echo 'พิกัด';?></th-->
								<!--th><?php //echo 'ลองจิจูด';?></th-->
							</tr>
							<?php while($row = mysqli_fetch_array($search_result)):?>			
								<tr>
									<td align="center" style="width: 20%"><?php echo $row['VHV_No'];?></td>
									<td align="center" style="width: 10%"><?php echo $row['Title'];?></td>
									<td style="width: 20%"><?php echo $row['FirstName'];?></td>
									<td style="width: 20%"><?php echo $row['LastName'];?></td>
									<td align="center">
										<button class="btn btn-primary" type="submit" name="regName" value="<?php echo $row['VHV_No'];?>" data-toggle="tooltip" data-placement="top" title="รายละเอียด"><span class="glyphicon glyphicon-zoom-in"></button>
									</td>
									<!--td align="center" style="width: 20%"><?php //echo $row['Tumbon'];?></td>
									<td align="center" style="width: 10%"><?php //echo $row['Moo'];?></td-->
									<!--td align="center" style="width: 20%"><?php //echo $row['Latitude'];?></td-->
									<!--td align="center"><?php //echo $row['Longitude'];?></td-->
									
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
			</form>
			<div>
				<div class="pagination col-xs-6 col-sm-6 col-md-6">
					<?php
						page_echo_pagenums(6, true);
					?>
				</div>
				

				
			</div>

			

			<div>
				<div id="map"></div>
			</div>

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
						content: '<h1><a href="profile.php?regName=' + person[count] + '">' + firstname[count] + ' ' + lastname[count] + '</a></h1>'
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
		</div>
		<br>
		<?php include('footer.php');?>
	</div>
	<script>
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();   
		});
	</script>
</body>
</html>


