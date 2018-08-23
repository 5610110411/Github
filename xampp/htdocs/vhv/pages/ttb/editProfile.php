<?php
  session_start();
  $TumbonArray      = array("บ่อผุด", "อ่างทอง", "หน้าเมือง", "ลิปะน้อย", "ตลิ่งงาม", "มะเร็ต", "แม่น้ำ");
  $InputByFormArray = array("Name", "Address", "IdCard"); //There is no Latitude and longtitude.
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
        updateProfile();
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

  function updateProfile()
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
    $Type       = test_input($_POST['Type']);
    
    //Declare for preventing the undifine error.
    $day        = "";
    $month      = "";
    $year       = "";
    $day        = test_input($_POST['Day']);
    $month      = test_input($_POST['Month']);
    $year       = test_input($_POST['Year']);
    
    $Timestamp  = date('Y-m-d G:i:s');
    
    $Birthday   = createBirthdayPattern($day, $month, $year);

    $sql   = "UPDATE `patient` 
              SET `Name`      = '$Name',      `Age`       = '$Age',       `Address`   = '$Address',
                  `Equipment` = '$Equipment', `Telephone` = '$Telephone', `Picture`   = '$Picture',  `IdCard`    = '$IdCard',
                  `Disease`   = '$Disease',   `Latitude`  = '$Latitude',  `Longitude` = '$Longitude', `Type`    = '$Type',
                  `Status`    = 'valid',      `Modified`  = '$Timestamp', `Accessed`  = '$Timestamp', `Birthday` = '$Birthday'
              WHERE  `IdCard` = '$IdCard'"; 
          
    //echo $sql;
  
    $result = databaseQuery($sql);
    
    echo "<script type='text/javascript'>
            alert('บันทึกข้อมูลเสร็จสิ้น');
            window.location='home.php';
          </script>";
          
  }

  function createBirthdayPattern($day, $month, $year)
  {
    $Birthday = "";
    $year = convertToValidYear($year);
    $Birthday = $month."/".$day."/".$year;
    return $Birthday;
  }

  function convertToValidYear($year)
  {
    $Year = abs($year - 543);
    return $Year;
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
                  <input class='form-control' name='Age' placeholder='อายุ' type='text' value="<?php echo $row['Age'];?>">
                </div>
              </div>
            </div>
          </div>

          <?php 
            //convert month number to string e.g. 01 --> Jan
            error_reporting(E_ALL ^ E_DEPRECATED);
            $splitDate = [];
            $Birthday = $row['Birthday'];

            if (!empty($Birthday) && strpos($Birthday, "//") !== false){  //in case the birthday is and //1995
              $splitDate = split("/", $Birthday);
              $splitDate[0] = 0;   //month
              $splitDate[2] = intval($splitDate[2]) + 543;  //Year ค.ศ. -> พ.ศ.
            }else if (!empty($Birthday) && strpos($Birthday, "/") !== false){  //in case the birthday is 4/18/1995 and //1995
              $splitDate = split("/", $Birthday);
              $splitDate[2] = intval($splitDate[2]) + 543;  //Year ค.ศ. -> พ.ศ.
              //echo $splitDate[2];
            }else if (!empty($Birthday) && strpos($Birthday, "/") !== false){ //in case the birthday is 4-18-1995
              $splitDate = split("-", $Birthday);
              $splitDate[2] = intval($splitDate[2]) + 543;  //Year ค.ศ. -> พ.ศ.
              //echo $splitDate[2];
            }
            else{
              $splitDate[0] = 0;   //month
              $splitDate[1] = "";    //day
              $splitDate[2] = "";    //year
            }

          ?>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'>วันเกิด</label>
            <div class='col-md-8'>
              <div class='col-md-2'>
                <div class='form-group internal'>
                  <select class='form-control' name='Day'>
                    <option value="<?php echo $splitDate[1]; ?>" selected><?php echo $splitDate[1]; ?></option>
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
                    <option value="<?php echo $splitDate[0]; ?>" selected><?php echo $monthArray[$splitDate[0]]; ?></option>
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
                  <input class='form-control' name='Year' placeholder='ปี พ.ศ.' type='number' min="<?php echo $minYear; ?>" max="<?php echo $maxYear; ?>" value="<?php echo $splitDate[2]; ?>">
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
            <label class='control-label col-md-2 col-md-offset-2'>ประเภท</label>
            <div class='col-md-6'>
              <div class='form-group'>
                <div class='col-md-11'>
                  <select class='form-control' name='Type'>
                      <option value="<?php echo $row['Type']; ?>" selected><?php echo $row['Type']; ?></option>
                      <option value="A">A</option>
                      <option value="B">B</option>
                      <option value="C">C</option>
                    </select>
                </div>
              </div>
            </div>
          </div>

          <div class='form-group'>
          <label class='control-label col-md-2 col-md-offset-2'>อุปกรณ์ทางการแพทย์ที่ยืม</label>
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
