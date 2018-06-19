<?php
if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $sql = "SELECT * FROM people WHERE FirstName LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($sql);
}
 else {
    $sql = "SELECT * FROM people";
    $search_result = filterTable($sql);
}

// function to connect and execute the query
function filterTable($sql)
{
	$link = mysqli_connect("localhost", "root", "", "vhv") or die(mysqli_connect_error() . "</body></html>");
	mysqli_query($link, "SET CHARACTER SET UTF8");
    $filter_Result = mysqli_query($link, $sql);
    return $filter_Result;
}
?>

<!doctype html>
<html>
<head>
<title>ระบบ GIS อสม. สมุย</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<style>
	body {
		background: url(bg.jpg);
	}
	table {
		border-collapse: collapse;
		min-width: 600px;
		margin: auto;
	}
	td {
		padding: 5px;
		border-right: solid 1px white;
		font: 14px tahoma;
		word-wrap:break-word;
	}
	td:last-child {
		border-right: solid 0px !important;
	}
	tr:nth-of-type(odd) {
		background: #dfd;
	}
	tr:nth-of-type(even) {
		background: #ddf;
	}
</style>
</head>
<body>
	<form action="index.php" method="post">
            <input type="text" name="valueToSearch" placeholder="ชื่อ"><br><br>
            <input type="submit" name="search" value="ค้นหา"><br>
            <table>
                <tr>
					<th>เลขประจำตัวประชาชน</th>
					<th>คำนำหน้า</th>
					<th>ชื่อ</th>
					<th>นามสกุล</th>
					<th>ละติจูด</th>
					<th>ลองจิจูด</th>
					<th>บ้านเลขที่</th>
					<th>หมู่</th>
					<th>ตำบล</th>
					<th>วันเกิด</th>
					<th>ปีที่เป็น อสม.</th>
					<th>การศึกษา</th>
					<th>อาชีพ</th>
					<th>หมู่เลือด</th>
					<th>เลขที่บัตร อสม.</th>
					<th>Line ID</th>
					<th>รูปประจำตัว</th>
                </tr>

                <?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                    <td><?php echo $row['IdCard'];?></td>
                    <td><?php echo $row['Title'];?></td>
                    <td><?php echo $row['FirstName'];?></td>
                    <td><?php echo $row['LastName'];?></td>
					<td><?php echo $row['Latitude'];?></td>
					<td><?php echo $row['Longitude'];?></td>
					<td><?php echo $row['Address'];?></td>
					<td><?php echo $row['Moo'];?></td>
					<td><?php echo $row['Tumbon'];?></td>
					<td><?php echo $row['Birthday'];?></td>
					<td><?php echo $row['StartYear'];?></td>
					<td><?php echo $row['Education'];?></td>
					<td><?php echo $row['Job'];?></td>
					<td><?php echo $row['BloodType'];?></td>
					<td><?php echo $row['VHV_No'];?></td>
					<td><?php echo $row['Line_ID'];?></td>
					<td><?php echo $row['Picture'];?></td>
                </tr>
                <?php endwhile;?>
            </table>
        </form>
</body>
</html>