<?php
  $TumbonArray      = array("บ่อผุด", "อ่างทอง", "หน้าเมือง", "ลิปะน้อย", "ตลิ่งงาม", "มะเร็ต", "แม่น้ำ");
  $InputByFormArray = array("IdCard", "Title", "FirstName", "LastName", 
                            "Moo", "Tumbon");
  $minYear          = (date("Y") + 543) - 150;
  $maxYear          = (date("Y") + 543) + 150;
  
  $isInputErr = 0; //Mark Error for server checking input.

  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    foreach ($InputByFormArray as $value)
    {
      if(empty($_POST[$value]))
      {
        $isInputErr = 1;
      }
    }
  }

  //Get action from user.
  $action = isset($_GET['action']) ? $_GET['action'] : '';
  switch ($action) {
	
	case 'addProfile' :
    if($isInputErr == 0){
      addProfile();
    }
    else{
      echo"<script language=\"JavaScript\">";
      echo"alert('กรุณากรอกข้อมูลให้ครบถ้วน')";
      echo"</script>";
    }
    break;
  case 'form' :
    //move to main product page
		break;
		
	default :
	  // if action is not defined or unknown
		// move to main product page
		header('Location: addProfile.php?action=form');
  }

  function databaseQuery($sql)
  {
    include "../../dblink_ttb.php";
    //$link = mysqli_connect("localhost", "root", "", "wifi_regis") or die(mysqli_connect_error());
    mysqli_query($link, "SET CHARACTER SET UTF8");
    $result = mysqli_query($link, $sql);
    //mysqli_close($link);
    return $result;
  }



  function addProfile()
  {
    $Title   	  = test_input($_POST['Title']);
    $FirstName  = test_input($_POST['FirstName']);
    $LastName   = test_input($_POST['LastName']);
    $Address    = test_input($_POST['Address']);
    $Moo       	= test_input($_POST['Moo']);
    $Age       	= test_input($_POST['Age']);
    $Tumbon     = test_input($_POST['Tumbon']);
    $IdCard     = test_input($_POST['IdCard']);
    $Latitude   = test_input($_POST['Latitude']);
    $Longitude  = test_input($_POST['Longitude']);
    $Equipment  = test_input($_POST['Equipment']);
    $Telephone  = test_input($_POST['Telephone']);
    $Picture    = test_input($_POST['Picture']);
    $Disease    = test_input($_POST['Disease']);
    $Type       = test_input($_POST['Type']);
    
    //Declare for preventing the undifine error.
    $day        = "";
    $month      = "";
    $year       = "";
    $day        = test_input($_POST['Day']);
    $month      = test_input($_POST['Month']);
    $year       = test_input($_POST['Year']);

    //Create Birthday Pattern
    $Birthday   = createBirthdayPattern($day, $month, $year);
    
    //Create Timestamp
    $Timestamp = date('Y-m-d G:i:s');

    //Create String Name
    $Name       = "";
    $Name       .= $Title.$FirstName." ".$LastName;

    //Create String Address
    $Address    .= " หมู่ ".$Moo." ".$Tumbon;
    
    //echo $Birthday;
    //$year = intval($year); //convert String to Int
    
    /*
    //intval($year);
    $tmpYear = abs($year - 543);

    if(abs(date("Y") - $tmpYear) < 150 ){
      $year = $day."/".$month."/".$year;
      echo $year;
      echo "if case";
    }else
    {
      echo "else case";
      $year += 543;
      echo $year;
      //$year = strval($year);
      $year = $day."/".$month."/".$year;
      echo $year;
    }
    */
    
    
    //$tmpYear = abs($year - 543);
    
    //echo abs(date("Y") - $tmpYear);
  
    $sql   = "INSERT INTO `patient`(`Name`, `Age`, `Address`, `Equipment`, 
                `Telephone`, `Picture`, `IdCard`, `Disease`, 
                `Latitude`, `Longitude`, `Type`, `Status`, `Created`, `Modified`, `Accessed`, `Birthday`) 
          VALUES ('$Name','$Age','$Address','$Equipment',
                '$Telephone','$Picture','$IdCard','$Disease',
                '$Latitude','$Longitude', '$Type', 'valid', '$Timestamp', '$Timestamp', '$Timestamp', '$Birthday')";
    
    
    $result = databaseQuery($sql);
    
    
    echo "<script type='text/javascript'>
            alert('บันทึกข้อมูลเสร็จสิ้น');
            window.location='home.php';
          </script>";
    
  
  }

  function test_input($data)
  {
    $data = trim($data);
    $data = htmlspecialchars($data);//Convert special characters to HTML entities
    return $data;
  }

  function createBirthdayPattern($day, $month, $year)
  {
    $Birthday = "";
    if($day != "" && $month != "" || $year != ""){
      $year = convertToValidYear($year);
      $Birthday = $month."/".$day."/".$year;
    }
      return $Birthday;
  }

  function convertToValidYear($year)
  {
    if($year != ''){
      $Year = abs($year - 543);
    }
    return $Year;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/bootstrapPaper.css">
  <title>เพิ่มข้อมูล</title>
  <style>
    /*added by Nine 13/06/2018 for gray color in select tag*/
    select:required:invalid {
      color: #bbbbbb;
    }
    option[value=""][disabled] {
      display: none;
    }
    option {
      color: black;
    }

  </style>
  <script type="text/javascript">

  function isValidDate() {
    var day = Number(document.getElementById("day").value),
        month = Number(document.getElementById("month").value),
        year = Number(document.getElementById("year").value);

    var date = new Date();
    date.setFullYear(year, month - 1, day);
    // month - 1 since the month index is 0-based (0 = January)

    if ( (date.getFullYear() == year) && (date.getMonth() == month + 1) && (date.getDate() == day) )
      return true;

    return false;
}
  </script>

</head>
<body>
<!--  =================== Top bar============================================   -->
  <?php include('topbar.php'); ?>

  <div class='container'>
  <div class='panel panel-primary dialog-panel'>
    <div class='panel-heading'>
      <h1 class='panel-title'>เพิ่มข้อมูลประจำตัว</h1>
    </div>
    <div class='panel-body'>
      <!--form class='form-horizontal' role='form' action="process.php?action=addProfile" method="POST"-->
      <form class='form-horizontal' role='form' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?action=addProfile";?>" method="POST">
        <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2'>เลขบัตรประชาชน</label>
          <div class='col-md-6'>
            <div class='form-group'>
              <div class='col-md-11'>
                <input class='form-control' name='IdCard' placeholder='เลขประจำตัวประชาชน (13หลัก)' type='number' min="1000000000000" max="9999999999999" required>
              </div>
            </div>
          </div>
        </div>

        <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2'>ชื่อ-นามสกุล</label>
          <div class='col-md-8'>
            <div class='col-md-2'>
              <div class='form-group internal'>
                <select class='form-control' name='Title' required>
                  <option value="" disabled selected>คำนำหน้า</option>
                  <option>นาย</option>
                  <option>นาง</option>
                  <option>นางสาว</option>
                </select>
              </div>
            </div>

            <div class='col-md-3 indent-small'>
              <div class='form-group internal'>
                <input class='form-control' name='FirstName' placeholder='ชื่อ' type='text' required>
              </div>
            </div>
            <div class='col-md-3 indent-small'>
              <div class='form-group internal'>
                <input class='form-control' name='LastName' placeholder='นามสกุล' type='text' required>
              </div>
            </div>
          </div>
        </div>

        <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2'>อายุ(ปี)</label>
          <div class='col-md-6'>
            <div class='form-group internal'>
              <div class='col-md-11'>
                <input class='form-control' name='Age' placeholder='อายุ' type='number' min="0" max="160">
              </div>
            </div>
          </div>
        </div>

        <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2'>วันเกิด</label>
          <div class='col-md-8'>
            <div class='col-md-2'>
              <div class='form-group internal'>
                <select class='form-control' name='Day'>
                  <option value="" disabled selected>วันที่</option>
                  <?php 
                    for ($i = 1; $i <= 31; $i++) {
                        echo "<option value='$i'>$i</option>";
                    } 
                  ?>
                </select>
              </div>
            </div>
            <div class='col-md-3 indent-small'>
              <div class='form-group internal'>
                <select class='form-control' name='Month'>
                  <option value="" disabled selected>เดือน</option>
                  <option value="1">มกราคม</option>
                  <option value="2">กุมภาพันธ์</option>
                  <option value="3">มีนาคม</option>
                  <option value="4">เมษายน</option>
                  <option value="5">พฤษภาคม</option>
                  <option value="6">มิถุนายน</option>
                  <option value="7">กรกฎาคม</option>
                  <option value="8">สิงหาคม</option>
                  <option value="9">กันยายน</option>
                  <option value="10">ตุลาคม </option>
                  <option value="11">พฤศจิกายน</option>
                  <option value="12">ธันวาคม</option-->
                </select>
              </div>
            </div>
            <div class='col-md-3 indent-small'>
              <div class='form-group internal'>
                <input class='form-control' name='Year' placeholder='ปี พ.ศ.' type='number' min="<?php echo $minYear; ?>" max="<?php echo $maxYear; ?>">
              </div>
            </div>
          </div>
        </div>

        <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2'>ที่อยู่</label>
          <div class='col-md-8'>
            <div class='col-md-2'>
              <div class='form-group internal'>
                <input class='form-control' name='Address' placeholder='บ้านเลขที่'>
              </div>
            </div>
            <div class='col-md-3 indent-small'>
              <div class='form-group internal'>
                <select class='form-control' name='Moo' required>
                  <option value="" disabled selected>หมู่ที่</option>
                  <?php 
                    for ($i = 1; $i <= 6; $i++) {
                        echo "<option value='$i'>$i</option>";
                    } 
                  ?>
                </select>
              </div>
            </div>

            <div class='col-md-3 indent-small'>
              <div class='form-group internal'>
              <select class='form-control' name='Tumbon' required>
                  <option value="" disabled selected>ตำบล</option>
                  <?php 
                    foreach ($TumbonArray as $value) {
                      echo "<option value='$value'>$value</option>";
                    }
                  ?>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2'>ติดต่อ</label>
          <div class='col-md-6'>
            <div class='form-group internal'>
              <div class='col-md-11'>
                <input class='form-control' name='Telephone' placeholder='เบอร์โทรศัพท์ เช่น 0979999999' type='number' min="0" max="9999999999">
              </div>
            </div>
          </div>
        </div>

        <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2'>โรค</label>
          <div class='col-md-6'>
            <div class='form-group'>
              <div class='col-md-11'>
                <input class='form-control' name='Disease' placeholder='โรค'>
              </div>
            </div>
          </div>
        </div>

        <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2'>ผู้ป่วยประเภท</label>
          <div class='col-md-6'>
            <div class='form-group internal'>
              <div class='col-md-11'>
                <select class='form-control' name='Type' required>
                  <option value="" disabled selected>ประเภท</option>
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="C">C</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2'>ครุภัณฑ์ที่ยืม</label>
          <div class='col-md-6'>
            <div class='form-group'>
              <div class='col-md-11'>
                <input class='form-control' name='Equipment' placeholder='เช่น รถเข็น 28355'>
              </div>
            </div>
          </div>
        </div>

        <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2'>URL รูปภาพประจำตัว</label>
          <div class='col-md-6'>
            <div class='form-group'>
              <div class='col-md-11'>
                <input class='form-control' name='Picture' placeholder='เช่น https://drive.google.com/open?id=1uX9L4EHV994GXhX'>
              </div>
            </div>
          </div>
        </div>

        <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2'>ละติจูด</label>
          <div class='col-md-8'>
            <div class='col-md-3'>
              <div class='form-group internal input-group'>
                <input class='form-control' name='Latitude' placeholder='เช่น 9.5000'>
              </div>
            </div>
            <label class='control-label col-md-2'>ลองจิจูด</label>
            <div class='col-md-3'>
              <div class='form-group internal input-group'>
                <input class='form-control' name='Longitude' placeholder='เช่น 99.9500'>
              </div>
            </div>
          </div>
        </div>

        <div class='form-group'>
          <div class='col-xs-12 col-sm-6 col-md-6'>
            <button class="btn btn-lg btn-success pull-right" type="submit"><span class='glyphicon glyphicon-floppy-saved'></span> บันทึกข้อมูล</button-->
            <!--input class="btn btn-lg btn-success pull-right" type="submit" value="บันทึกข้อมูล"></input-->
  
          </div>
          <div class='col-xs-12 col-sm-6 col-md-6 pull-left'>
            <a href="home.php" class="btn btn-lg btn-danger pull-right"><span class='glyphicon glyphicon-floppy-remove'></span> ยกเลิก</a>
          </div>
        </div>
      </form>
    </div>
  </div>
   
  </div>
  <?php include('footer.php');?>
</body>
</html>
