<?php

?> 
<p>&nbsp;</p>
<form action="/add/pages/process.php?action=addProduct" method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct">
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr><td colspan="2" id="entryTableHeader">แบบฟอร์มลงทะเบียนการใช้งานอินเทอร์เน็ต เทศบาลนครเกาะสมุย</td></tr>
  
  
  
  <tr>
    <td width="150" class="label">คำนำหน้า:</td>
    <td class="content">
      <select name="Title">
        <option value="นาย">นาย</option>
        <option value="นาย">นาง</option>
        <option value="นาย">นางสาว</option>
      </select>
    </td>
  
  </tr>

  <tr> 
   <td width="150" class="label">ชื่อ:</td>
   <td class="content"> <input name="FirstName" type="text" class="box" id="FirstName" size="50" maxlength="100"></td>
  </tr>
  <tr> 
   <td width="150" class="label">นามสกุล:</td>
   <td class="content"> <input name="LastName" type="text" class="box" id="LastName" size="50" maxlength="100"></td>
  </tr>
  <tr> 
   <td width="150" class="label">บ้านเลขที่:</td>
   <td class="content"> <input name="Address" type="text" class="box" id="Address" size="50" maxlength="100"></td>
  </tr>
  <tr> 
    <td width="150" class="label">หมู่ที่:</td>
    <td class="content">
      <select name="Moo">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
      </select>
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">ตำบล:</td>
   <td class="content"> <input name="Tumbon" type="text" class="box" id="Moo" size="50" maxlength="100"></td>
  </tr>
  <tr> 
   <td width="150" class="label">เลขประจำตัวประชาชน:</td>
   <td class="content"> <input name="IdCard" type="text" class="box" id="IdCard" size="50" maxlength="100"></td>
  </tr>
  <tr> 
    <td width="150" class="label">เลขที่บัตร อสม.:</td>
    <td class="content"> <input name="VHV_No" type="text" class="box" id="VHV_No" size="50" maxlength="100"></td>
  </tr>
  <tr> 
   <td width="150" class="label">ได้รับการแต่งตั้งเป็น อสม. ปี:</td>
   <td class="content"> <input name="StartYear" type="text" class="box" id="StartYear" size="50" maxlength="100"></td>
  </tr>
  <tr> 
    <td width="150" class="label">หมู่โลหิต:</td>
    <td class="content">
      <select name="BloodType">
        <option value="เอ">เอ</option>
        <option value="บี">บี</option>
        <option value="โอ">โอ</option>
        <option value="เอบี">เอบี</option>
      </select>
    </td>
  </tr>
  <tr> 
   <td width="150" class="label">วันเกิด:</td>
   <td class="content"> <input name="Birthday" type="text" class="box" id="Birthday" size="50" maxlength="100"></td>
  </tr>
  <tr> 
   <td width="150" class="label">วุฒิการศึกษา:</td>
   <td class="content">
      <select name="Education">
        <option value="ประถมศึกษา">ประถมศึกษา</option>
        <option value="มัธยมศึกษา">มัธยมศึกษา</option>
        <option value="ปริญญาตรี">ปริญญาตรี</option>
        <option value="สูงกว่าปริญญาตรี">สูงกว่าปริญญาตรี</option>
      </select>
    </td> 
  </tr>
  <tr> 
   <td width="150" class="label">อาชีพ:</td>
   <td class="content"> <input name="Job" type="text" class="box" id="Job" size="50" maxlength="100"></td>
  </tr>
  <tr> 
   <td width="150" class="label">ละติจูด:</td>
   <td class="content"> <input name="Latitude" type="text" class="box" id="Latitude" size="50" maxlength="100"></td>
  </tr>
  <tr> 
   <td width="150" class="label">ลองจิจูด:</td>
   <td class="content"> <input name="Longitude" type="text" class="box" id="Longitude" size="50" maxlength="100"></td>
  </tr>
 </table>
 <p align="center"> 
  <input name="btnAddProduct" type="submit" id="btnAddProduct" value="บันทึกข้อมูล" onClick="checkAddProductForm();" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="ยกเลิก" onClick="window.location.href='index.php';" class="box">  
 </p>
</form>
