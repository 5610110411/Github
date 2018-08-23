<?php
	session_start();
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
			$sql = "SELECT * FROM patient WHERE 1 AND IdCard LIKE '%00000000000000%'";
			//echo $sql;
		}
		else if(isset($_SESSION['lastSQL']))
		{
			$sql = $_SESSION['lastSQL'];
			//echo $sql;
		}
		else
		{
			$sql = "SELECT * FROM patient";
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
		include "../../dblink_ttb.php";
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
		include "../../dblink_ttb.php";
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
		
		//Prevent error from dropdown list while searching
		if(isset($_POST['Tumbon']))
		{
			$Tumbon = $_POST['Tumbon'];
		}else
		{
			$Tumbon = "";
		}
		if(isset($_POST['Moo']))
		{
			$Moo = $_POST['Moo'];
		}else
		{
			$Moo = "";
		}

		if(empty($IdCard) && empty($FirstName) && empty($LastName) && empty($Tumbon) && empty($Moo)){
			return "SELECT * FROM patient WHERE 1 AND IdCard LIKE '00000000000000'";
		}else{
			$sql = "SELECT * FROM patient WHERE 1";
			
			if($IdCard && !empty($IdCard))
			{
				$sql .= " AND IdCard LIKE '$IdCard'";
			}
			if($FirstName && !empty($FirstName))
			{
				$sql .= " AND Name LIKE '%$FirstName%'";
			}
			if($LastName && !empty($LastName))
			{
				$sql .= " AND Name LIKE '%$LastName'";
			}
			
			if($Moo && !empty($Moo) && $Moo != 'all')
			{
				$MooString = "หมู่%";
				$MooString .= $Moo;
				$sql .= " AND Address LIKE '%$MooString%'";
			}

			if($Tumbon && !empty($Tumbon) && $Tumbon != 'all')
			{
				$TumbonString = "ตำบล%";
				$TumbonString .= $Tumbon;
				$sql .= " AND Address LIKE '%$TumbonString%'";
			}
			
		}
		$_SESSION['lastSQL'] = $sql;
		return $sql;
	}
?>

<?php
//session_start();
if(!isset($_SESSION['ses_id'])){
        echo "<meta http-equiv='refresh' content='1;URL=../ttb/login.php'>";
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
<link rel="stylesheet" href="../../css/bootstrapPaper.css">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/i18n/defaults-*.min.js"></script>



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
		color: #dddddd;
		/*color: #808B96;*/
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
		var lat = {};
		var long = {};
		var number = 0;
	</script>

<!--  =================== Top bar============================================   -->
<?php include('topbar.php'); ?>

	<select class="selectpicker">
  <option>Mustard</option>
  <option>Ketchup</option>
  <option>Relish</option>
</select>
	<div class="container">
		<h1 align="center">โครงการ โรงพยาบาล 10,000 เตียง</h1>
		<div class="container">
			<div class="row centered-form">
					<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
						<div class="panel panel-default">
							<div class="panel-heading">
									<h3 class="panel-title text-center">ค้นหาข้อมูลสมาชิก</h3>
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
													<select name="Tumbon" class="form-control form-control-option input-sm">
														<option value="111" disabled selected hidden>ตำบล</option>
														<option value="all">ทุกตำบล</option>
														<option value="ตลิ่งงาม">ตลิ่งงาม</option>
														<option value="บ่อผุด">บ่อผุด</option>
														<option value="อ่างทอง">อ่างทอง</option>
														<option value="หน้าเมือง">หน้าเมือง</option>
														<option value="ลิปะน้อย">ลิปะน้อย</option>
														<option value="แม่น้ำ">แม่น้ำ</option>
														<option value="มะเร็ต">มะเร็ต</option>
													</select>
												</div>
										</div>

										<div class="col-xs-6 col-sm-6 col-md-6">
												<div class="form-group">
													<select name="Moo" class="form-control form-control-option input-sm">
														<option value="111" disabled selected hidden>หมู่ที่</option>
														<option value="all">ทุกหมู่</option>
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
														<option value="5">5</option>
														<option value="6">6</option>
													</select>
												</div>
										</div>
									</div>
							
									<button type="submit" name="search" class="btn btn-primary btn-block">
										<span class="glyphicon glyphicon-search"></span>  ค้นหา
									</button>
								</form>
											</div>
									</div>
								</form>
							</div>
					</div>
			</div>
			<form method="get" action="addProfile.php">
				<button class="btn btn-default" style="float:right">
					<span class="glyphicon glyphicon-plus"></span>  เพิ่มข้อมูล
				</button>
			</form>

			<form method="get" action="profile.php">
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
								<th><?php echo 'เลขบัตรประชาชน';?></th>
								<th style="text-align: left"><?php echo 'ชื่อ-นามสกุล';?></th>
								<!--th><?php //echo 'ตำบล';?></th>
								<th><?php //echo 'หมู่ที่';?></th-->
								<th><?php echo 'ข้อมูลเพิ่มเติม';?></td>
							</tr>
							<?php while($row = mysqli_fetch_array($search_result)):?>			
								<tr>
									<td align="center"><?php echo $row['IdCard'];?></td>
									<td><?php echo $row['Name'];?></td>
									<!--td align="center"><?php //echo $row['Tumbon'];?></td>
									<td align="center"><?php //echo $row['Moo'];?></td-->
									<td align="center">
										<button class="btn btn-primary" type="submit" name="regName" value="<?php echo $row['IdCard'];?>" data-toggle="tooltip" data-placement="top" title="รายละเอียด"><span class="glyphicon glyphicon-zoom-in"></button>
										<button class="btn btn-warning" type="submit" name="editProfile" value="<?php echo $row['IdCard'];?>" data-toggle="tooltip" data-placement="top" title="แก้ไข"><span class="glyphicon glyphicon glyphicon-edit"></button>
										<button class="btn btn-danger" type="submit" name="deleteProfile" value="<?php echo $row['IdCard'];?>" onclick='return window.confirm("คุณยืนยันที่จะลบข้อมูลใช่หรือไม่?");' data-toggle="tooltip" data-placement="top" title="ลบ"><span class="glyphicon glyphicon-trash"></button>
									</td>
								</tr>
							<?php endwhile;?>
							
						</table>
						<form method="post" action="../pages/export.php?sql=<?php //echo $sqlForExport; ?>" >  
							<button type="submit" name="export" class="btn btn-success" style="float:right"><span class="glyphicon glyphicon-export"></span> Export Data <?php //echo $sqlForExport; ?></button>
						</form>
						<?php } //end of else?>

						<?php while($row = mysqli_fetch_array($search_resultForMap)):?>			
							<script>
								person[number] = <?php echo $row['IdCard'];?>;
								firstname[number] = "<?php echo $row['Name'];?>";
								//alert name[number];
								lat[number] = <?php echo $row['Latitude'];?>;
								long[number] = <?php echo $row['Longitude'];?>;
								number++;
							</script>
						<?php endwhile;?>
			</form>
			<div>
				<div class="pagination col-xs-7 col-sm-7 col-md-7">
					<?php
						page_echo_pagenums(6, true);
					?>
				</div>
				
				
				
			</div>

			
			<div id="map"></div>
			<!--div class='panel'>
				<div id="map"></div>
			</div-->

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
				/*
				var markers = [];
				var coords = [];
				for (var count = 0; count < number; count++) {
					
				
					markers[count] = {
						coords: {
							lat: lat[count],
							lng: long[count]
						},
						content: '<h1><a href="profile.php?regName=' + person[count] + '">' + name[count] + '</a></h1>'
						//iconImage: 'pictures/'+ tumbonColor +'.png',
						//content: '<h1><a href="profile.php?regName=' + person[count] + '">' + name[count] + ' ' + lastname[count] + ' (' + tumbon[count] + ') '+'</a></h1><p>(' + lat[count]+ ', ' + lat[count] + ')</p>'
						
						//icon:'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'
					};
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
						content: '<h1><a href="profile.php?regName=' + person[count] + '">' + firstname[count] + '</a></h1>'
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
							//icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
							icon:props.iconImage
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
<?php
	}
?>

