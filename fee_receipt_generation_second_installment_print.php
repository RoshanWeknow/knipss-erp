<?php
//set_time_limit(0);
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$response=1;
$msg='';
$i=0;
$_POST['dfc_date']=$_SESSION['comp_date3'];
$_POST['type']=$_SESSION['type3'];
$_POST['class_type']=$_SESSION['class_type3'];
?>
<style>
#wrapper{width:400mm; border:1px solid; margin:5mm;}
td{font-size:15px;}
</style> 
<table width="100%" border="1" id="feesreport">
    <tr style="background:#CCC; color:#FFF; text-align:center; font-size:13px;">
        <td>S.No.</td>
        <td>Receipt Number</td>
        <td>Date</td>
        <td>Name Of Student</td>
        <td>Father's Name</td>
        <td>Class/Course Name/Year</td>
        <td>Session(Old)</td>
        <td>Session(Current)</td>
        <td>Gender</td>
        <td>Category</td>
        <td>Fee Amount</td>
        <td>Mode Of Receipt</td>
    </tr>
<?php 
$tot_stu_count=0;
$grand_fees=0;
$n=1;
switch($_SESSION['re_class_type']){
            case 'ballb': {
                $sql = 'select fee_invoice3.sno from fee_invoice3 left join class_detail on class_detail.sno = fee_invoice3.class_id where  `approval_date` >= "'.$_SESSION['re_from_date'].'" AND `approval_date` <= "'.$_SESSION['re_to_date'].'" and class_detail.sort_no="BA_LLB" order by fee_invoice3.sno';
                
                break;
            }
            case 'AIDED' : {
                $sql = 'select fee_invoice3.sno from fee_invoice3 left join class_detail on class_detail.sno = fee_invoice3.class_id where  `approval_date` >= "'.$_SESSION['re_from_date'].'" AND `approval_date` <= "'.$_SESSION['re_to_date'].'" and class_detail.type!="SELF" and class_detail.sort_no!="BA_LLB" order by fee_invoice3.sno';
                break;
            }
            case 'SELF' : {
                $sql = 'select fee_invoice3.sno from fee_invoice3 left join class_detail on class_detail.sno = fee_invoice3.class_id where  `approval_date` >= "'.$_SESSION['re_from_date'].'" AND `approval_date` <= "'.$_SESSION['re_to_date'].'" AND class_detail.type="SELF" and class_detail.sort_no!="BA_LLB" order by fee_invoice3.sno';
                break;
            }
        }
        //echo $sql.'</br>' ;
        $result_data = execute_query(connect(), $sql);
        while($row_data = mysqli_fetch_assoc($result_data)){
            $sql = 'select * from `fee_invoice3` where `sno`="'.$row_data['sno'].'"';
            $row = mysqli_fetch_assoc(execute_query(connect(), $sql));
        $sql_student = 'select * from student_info where sno="'.$row['student_id'].'"';
        $student = mysqli_fetch_array(execute_query(connect(), $sql_student));
        $sql_class = 'select * from class_detail where sno="'.$row['class_id'].'"';
        $class = mysqli_fetch_array(execute_query(connect(), $sql_class));

            echo '<tr><td>'.$n++.'</td><td>';
            if($_SESSION['re_class_type']=="ballb"){
                echo 'knss';
            }
            else{
                echo 'knipss';
            }
            echo '/'.$_SESSION['re_class_type'].'/2019/'.$row['receipt_number'].'</td><td>'.$row['approval_date'].'</td><td>'.$student['stu_name'].'</td><td>'.$student['father_name'].'</td><td>'.$class['class_description'].'</td><td></td><td></td><td>'.$student['gender'].'</td><td>'.$student['category'].'</td><td>'.$row['amount_paid'].'</td><td>'.$row['type'].'</td></tr>';
            $grand_fees += $row['amount_paid'];

    }
    echo '<tr><td colspan="10" style="text-align:right;">GRAND TOTAL</td><td>'.$grand_fees.'</td><td></td></tr></table>';
?>
<table width="100%" border="1" style="background-color: white;">
    <tr style="background-color: white;">
        <td colspan="11">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
        <td colspan="2">Date Of Deposit</td>
        <td>Slip No.</td>
        <td colspan="2">Amount</td>
        <td>&nbsp;</td>
    </tr>
    <tr style="background-color: white;">
        <td colspan="3">&nbsp;</td>
        <td colspan="2"><b>Deposite In Bank</b></td>
        <td colspan="2">&nbsp;</td>
        <td colspan="1">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="1">&nbsp;</td>
    </tr>
    <tr style="background-color: white;">
        <td colspan="3">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="1">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="1">&nbsp;</td>
    </tr>
    <tr style="background-color: white;">
        <td colspan="3">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="1">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="1">&nbsp;</td>
    </tr>
    <tr style="background-color: white;">
        <td colspan="3">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="1">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="1">&nbsp;</td>
    </tr>
    <tr style="background-color: white;">
        <td colspan="3">&nbsp;</td>
        <td colspan="2"><b>CASH IN HAND OPENING</b></td>
        <td colspan="2">&nbsp;</td>
        <td colspan="1">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="1">&nbsp;</td>
    </tr>
    <tr style="background-color: white;">
        <td colspan="3">&nbsp;</td>
        <td colspan="2"><b>CASH IN HAND CLOSING</b></td>
        <td colspan="2">&nbsp;</td>
        <td colspan="1">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="1">&nbsp;</td>
    </tr>
    <tr style="background-color: white;">
        <td colspan="11">&nbsp;</td>
    </tr>
    <tr style="background-color: white;">
        <td colspan="11">&nbsp;</td>
    </tr>
    <tr style="background-color: white;">
        <td colspan="11">&nbsp;</td>
    </tr>
    <tr style="background-color: white;">
        <td colspan="3">&nbsp;</td>
        <td>(PREPARED BY)</td>
        <td>(IN CHARGE FEE)</td>
        <td>&nbsp;</td>
        <td>(ACCOUNTANT)</td>
        <td colspan="4">(BURSUR)</td>
    </tr>
    <tr style="background-color: white;">
        <td colspan="11">&nbsp;</td>
    </tr>
    <tr style="background-color: white;">
        <td colspan="11">&nbsp;</td>
    </tr>
    <tr style="background-color: white;">
        <td colspan="11">&nbsp;</td>
    </tr>
    <tr style="background-color: white;">
        <td colspan="11">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
        <td>(PRINCIPAL)</td>
        <td colspan="5">&nbsp;</td>
    </tr>
</table>
