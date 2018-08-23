<?php
  session_start();
  $TumbonArray      = array("บ่อผุด", "อ่างทอง", "หน้าเมือง", "ลิปะน้อย", "ตลิ่งงาม", "มะเร็ต", "แม่น้ำ");
  $InputByFormArray = array("Name", "Address", "IdCard", 
                            "Latitude", "Longitude"); //There is no Latitude and longtitude.
  $monthArray       = array("เดือน", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", 
                            "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", 
                            "พฤศจิกายน", "ธันวาคม");
                     
  $minYear          = (date("Y") + 543) - 150;
  $maxYear          = (date("Y") + 543) + 150;

  $isInputErr = 0; //Mark Error for server checking input.

  $search_result = "";
  if(isset($_GET['editProfile']))
  {
    $search_result = showProfile();
  }else{
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
      foreach ($InputByFormArray as $value)
      {
        
        if(empty($_POST[$value]))
        {
          //echo $value.'/';
          $isInputErr = 1;
          //echo "1";
        }
      }
    }

    //Get action from user.
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    switch ($action) {
    
    case 'editProfile' :
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
      header('Location: editProfile.php?action=form');
    }
  }

  function showProfile()
  {
    $editProfile = $_GET['editProfile'];
    $sql = createQueryForShowProFile($editProfile);
    $search_result = filterTable($sql);
    return $search_result;
  }

  function createQueryForShowProFile($key)
	{
		$sql = "SELECT * FROM patient WHERE IdCard LIKE '$key'";
		return $sql;
  }
  
  function filterTable($sql)
	{
		//$link = mysqli_connect("localhost", "root", "", "vhv") or die(mysqli_connect_error() . "</body></html>");
    include "../../dblink_ttb.php";
    mysqli_query($link, "SET CHARACTER SET UTF8");
    $filter_Result = mysqli_query($link, $sql);
    mysqli_close($link);
		return $filter_Result;
	}

  ///////////////////////////////////////////
  function editProfile()
  {
    $editProfile = $_GET['editProfile'];
    $sql = createQueryForShowProFile($editProfile);
    $search_result = filterTable($sql);
    return $search_result;
  }

  function addProfile()
  {
    $Name       = test_input($_POST['Name']);
    $Address    = test_input($_POST['Address']);
    $Age        = test_input($_POST['Age']);
    $IdCard     = test_input($_POST['IdCard']);
    $Telephone  = test_input($_POST['Telephone']);
    $Disease    = test_input($_POST['Disease']);
    $Equipment  = test_input($_POST['Equipment']);
    $Picture    = test_input($_POST['Picture']);
    $Latitude   = test_input($_POST['Latitude']);
    $Longitude  = test_input($_POST['Longitude']);
    
    $sql   = "UPDATE `patient` 
              SET `Name`      = '$Name',      `Age`       = '$Age',       `Address`   = '$Address',
                  `Equipment` = '$Equipment', `Telephone` = '$Telephone', `Picture`   = '$Picture',    
                  `IdCard`    = '$IdCard',    `Disease`   = '$Disease',   `Latitude`  = '$Latitude',  `Longitude` = '$Longitude'
              WHERE  `IdCard` = $IdCard"; 
          
    //echo $sql;
  
    $result = databaseQuery($sql);
    echo "<script type='text/javascript'>
            alert('บันทึกข้อมูลเสร็จสิ้น');
            window.location='home.php';
          </script>";
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

  function test_input($data)
  {
    $data = trim($data);
    $data = htmlspecialchars($data);//Convert special characters to HTML entities
    return $data;
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
  <title>แก้ไขข้อมูล</title>
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
    .buttonConfirm {
     width: 45%;
     height: 20%;
     margin: 10px 2px;
    }

  </style>
  <script type="text/javascript">
  </script>

</head>
<body>
<!--  =================== Top bar============================================   -->
  <?php include('topbar.php'); ?>

  <div  class="container">
    <div class='panel panel-primary dialog-panel'>
      <div class='panel-heading'>
        <h1 class='panel-title'>แก้ไขข้อมูล</h1>
      </div>
      <div class='panel-body'>
        <!--form class='form-horizontal' role='form' action="process.php?action=addProfile" method="POST"-->
        <?php $row = mysqli_fetch_array($search_result)?>
        <form class='form-horizontal' role='form' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?action=editProfile";?>" method="POST">
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>เลขบัตรประชาชน</label>
            <div class='col-md-6'>
              <div class='form-group'>
                <div class='col-md-11'>
                  <input class='form-control' name='IdCard' placeholder='เลขประจำตัวประชาชน (13หลัก)' type='number' min="0000000000001" max="9999999999999" value="<?php echo $row['IdCard'];?>" required>
                </div>
              </div>
            </div>
          </div>

          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>ชื่อ-นามสกุล</label>
            <div class='col-md-6'>
              <div class='form-group'>
                <div class='col-md-11'>
                  <input class='form-control' name='Name' placeholder='ชื่อ-นามสกุล' type='text' value="<?php echo $row['Name'];?>" required>
                </div>
              </div>
            </div>
          </div>

          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>อายุ(ปี)</label>
            <div class='col-md-6'>
              <div class='form-group'>
                <div class='col-md-11'>
                  <input class='form-control' name='Age' placeholder='อายุ' type='text' value="<?php echo $row['Age'];?>" required>
                </div>
              </div>
            </div>
          </div>

          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>ที่อยู่</label>
            <div class='col-md-6'>
              <div class='form-group'>
                <div class='col-md-11'>
                  <input class='form-control' name='Address' placeholder='ที่อยู่' type='text' value="<?php echo $row['Address'];?>" required>
                </div>
              </div>
            </div>
          </div>

          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>ติดต่อ</label>
            <div class='col-md-6'>
              <div class='form-group internal'>
                <div class='col-md-11'>
                  <input class='form-control' name='Telephone' placeholder='เบอร์โทรศัพท์ เช่น 0979999999' type='number' value="<?php echo $row['Telephone'];?>" min="0" max="9999999999">
                </div>
              </div>
            </div>
          </div>

          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>โรค</label>
            <div class='col-md-6'>
              <div class='form-group'>
                <div class='col-md-11'>
                  <input class='form-control' name='Disease' placeholder='โรค' value="<?php echo $row['Disease'];?>">
                </div>
              </div>
            </div>
          </div>

          <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2'>อุปกรณ์ที่ยืม</label>
            <div class='col-md-6'>
              <div class='form-group'>
                <div class='col-md-11'>
                  <input class='form-control' name='Equipment' placeholder='เช่น รถเข็น 28355' value="<?php echo $row['Equipment'];?>">
                </div>
              </div>
            </div>
          </div>

          <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2'>URL รูปภาพประจำตัว</label>
            <div class='col-md-6'>
              <div class='form-group'>
                <div class='col-md-11'>
                  <input class='form-control' name='Picture' placeholder='เช่น https://drive.google.com/open?id=1uX9L4EHV994GXhX' value="<?php echo $row['Picture'];?>">
                </div>
              </div>
            </div>
          </div>

          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>ละติจูด</label>
            <div class='col-md-8'>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <input class='form-control' name='Latitude' placeholder='เช่น 9.5000' value="<?php echo $row['Latitude'];?>">
                </div>
              </div>
              <label class='control-label col-md-2'>ลองจิจูด</label>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <input class='form-control' name='Longitude' placeholder='เช่น 99.9500' value="<?php echo $row['Longitude'];?>">
                </div>
              </div>
            </div>
          </div>

          <div class='form-group'>
            <div class='col-xs-12 col-sm-6 col-md-6'>
              <button class="btn btn-lg btn-success pull-right buttonConfirm" type="submit"><span class='glyphicon glyphicon-floppy-saved'></span> บันทึกข้อมูล</button>
              <!--input class="btn btn-lg btn-success pull-right" type="submit" value="บันทึกข้อมูล"></input-->
    
            </div>
            <div class='col-xs-12 col-sm-6 col-md-6 pull-left'>
              <a href="home.php" class="btn btn-lg btn-danger pull-right buttonConfirm"><span class='glyphicon glyphicon-floppy-remove'></span> ยกเลิก</a>
            </div>
          </div>
        </form>
      </div>
    </div>
   
  </div>
  <?php include('footer.php');?>
</body>
</html>
