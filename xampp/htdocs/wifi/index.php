<?php

?> 
<p>&nbsp;</p>
<form action="/wifi/pages/process.php?action=addProduct" method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct">
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr><td colspan="2" id="entryTableHeader">แบบฟอร์มลงทะเบียนการใช้งานอินเทอร์เน็ต เทศบาลนครเกาะสมุย</td></tr>
  
  <tr> 
    <td width="150" class="label">สำนัก/กอง</td>
    <td class="content">
      <select name="txtDivisionName">
        <option value="สำนักปลัดเทศบาล">สำนักปลัดเทศบาล</option>
        <option value="สำนักการศึกษา">สำนักการศึกษา</option>
        <option value="กองสวัสดิการสังคม">กองสวัสดิการสังคม</option>
        <option value="กองวิชาการและแผนงาน">กองวิชาการและแผนงาน</option>
        <option value="สำนักการช่าง">สำนักการช่าง</option>
        <option value="กองคลัง">กองคลัง</option>
        <option value="กองช่างสุขาภิบาล">กองช่างสุขาภิบาล</option>
        <option value="กองสาธารณสุขและสิ่งแวดล้อม">กองสาธารณสุขและสิ่งแวดล้อม</option>
        <option value="ศูนย์พัฒนาเด็กเล็กเทศบาล">ศูนย์พัฒนาเด็กเล็กเทศบาล</option>
        <option value="โรงเรียนสังกัดเทศบาล">โรงเรียนสังกัดเทศบาล</option>
        <option value="หน่วยตรวจสอบภายใน">หน่วยตรวจสอบภายใน</option>
      </select>
    </td>
  </tr>
  
  <tr>
    <td width="150" class="label">คำนำหน้า</td>
    <td class="content">
      <select name="title">
        <option value="นาย">นาย</option>
        <option value="นาย">นาง</option>
        <option value="นาย">นางสาว</option>
      </select>
    </td>
  
  </tr>

  <tr> 
   <td width="150" class="label">ชื่อ</td>
   <td class="content"> <input name="txtFirstName" type="text" class="box" id="txtFirstName" size="50" maxlength="100"></td>
  </tr>
  <tr> 
   <td width="150" class="label">นามสกุล</td>
   <td class="content"> <input name="txtLastName" type="text" class="box" id="txtLastName" size="50" maxlength="100"></td>
  </tr>
  <tr> 
   <td width="150" class="label">Email</td>
   <td class="content"> <input name="txtEmail" type="text" class="box" id="txtEmail" size="50" maxlength="100"></td>
  </tr>
  <tr> 
   <td width="150" class="label">Password</td>
   <td class="content"> <input name="txtPassword" type="password" class="box" id="txtPassword" size="50" maxlength="100"></td>
  </tr>
  <tr> 
   <td width="150" class="label">Confirm-Password</td>
   <td class="content"> <input name="txtConfirmPassword" type="password" class="box" id="ConfirmPassword" size="50" maxlength="100"></td>
  </tr>
 </table>
 <p align="center"> 
  <input name="btnAddProduct" type="submit" id="btnAddProduct" value="บันทึกข้อมูล" onClick="checkAddProductForm();" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="ยกเลิก" onClick="window.location.href='index.php';" class="box">  
 </p>
</form>
