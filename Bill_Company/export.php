<?php
session_start();
error_reporting(0);
$user = $_SESSION['username'];
if($_SESSION['username']==""){

	echo "<br><center><h3><font color=\"#CC0099\">คุณยังไม่ได้เข้าสู่ระบบ กรุณาเข้าสู่ระบบก่อน</font></h3></center>";
	
	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"2;URL=login.php\">";
	
	exit();
	
	} 
date_default_timezone_set('Asia/Bangkok');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

if (isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
    $connect = mysqli_connect("localhost", "root", "@Newayw123", "bill_format");
    $arr_file = explode('.', $_FILES['file']['name']);
    $extension = end($arr_file);

    $strUsername =  $_SESSION["username"];
    $strPermission = $_SESSION["permis"];

    if ('csv' == $extension) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    } else {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    }
    if ('xls' == $extension) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
    } else {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    }

    $spreadsheet = $reader->load($_FILES['file']['tmp_name']);

    $sheetData = $spreadsheet->getActiveSheet()->toArray();
   
    foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
        $highestRow = $worksheet->getHighestRow();
        //                  Bussiness               //
        $name_company_bo = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, 2)->getValue());
        $adress_company_bo = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, 4)->getValue());
        $tax_company_bo = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, 3)->getValue());
        $phone_bo = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, 6)->getValue());
        $email_bo = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, 7)->getValue());
        $number_bill_bo = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, 2)->getValue());
        $start_date_bo = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, 3)->getValue());
        $end_date_bo = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, 4)->getValue());
        //                  Customers               //
        $name_company_cus = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, 10)->getValue());
        $adress_company_cus = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, 12)->getValue());
        $tax_company_cus = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, 11)->getValue());
        $phone_cus = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, 14)->getValue());
        $email_cus = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, 15)->getValue());
        $summary_cus = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, 41)->getValue());

        $status_docs = "Inprocess";
        $status_mail = "N";
        mysqli_set_charset($connect, "utf8");
        $query = "  INSERT INTO bill_invoice (name_company_bo,adress_company_bo,tax_company_bo,phone_bo,email_bo,number_bill_bo,start_date_bo,end_date_bo,name_company_cus,adress_company_cus,tax_company_cus,phone_cus,email_cus,summary_cus,status_docs,status_mail,session_user)   VALUES ('" . $name_company_bo . "', '" . $adress_company_bo . "', '" . $tax_company_bo . "','" . $phone_bo . "','" . $email_bo . "','" . $number_bill_bo . "','" . $start_date_bo . "','" . $end_date_bo . "','" . $name_company_cus . "','" . $adress_company_cus . "','" . $tax_company_cus . "','" . $phone_cus . "','" . $email_cus . "','" . $summary_cus . "', '" . $status_docs . "','".$status_mail."','".$strUsername."')  ";
        mysqli_query($connect, $query);
    }
    
    mysqli_close($connect);
    echo " <meta http-equiv='refresh' content='1; url=history.php '>";
    echo "  <div align='center'>";
    echo " <p><br> ";
    echo  "<br>";
    echo   " <font size='3' face='MS Sans Serif, Tahoma, sans-serif'><b>บันทึกข้อมูลสำเร็จ</b></font>";
    echo "</p>";
    echo "<p>";
    echo  "<font size='3' face='MS Sans Serif, Tahoma, sans-serif'>กรุณารอสักครู่ เพื่อกลับหน้าบันทึกรายการ</font><br>";
    echo  "<br>";
    echo  "</p>";
    echo "</div>";
}
