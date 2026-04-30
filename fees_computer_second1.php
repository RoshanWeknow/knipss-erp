<?php
set_time_limit(0);
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_store();
$response=1;
$msg='';
$i=0;
?>
<script type="text/javascript" language="javascript">
function class_report() {
	window.open("fees_computer_second_print.php");
}
</script>
<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
    	<h2>Fees <span class="orange">Computer & Self (Day Wise)(Second Installment)</span></h2>
		<li class="notranslate"><label  class="desc" for="name">Enter Bank User Id<span class="name">*</span></label>
         	<div><input type="text" name="user_id" id="user_id" ></div></li>
         <li class="notranslate"><label  class="desc" for="name">Select Date<span class="name">*</span></label>
			<script type="text/javascript" language="javascript">
            DateInput('dfc_date', false, 'YYYY-MM-DD', '<?php if(isset($_POST['dfc_date'])){echo $_POST['dfc_date'];}else{echo date("Y-m-d"); $_POST['dfc_date']=date("Y-m-d");} ?>')
            </script></li>
             <li class="notranslate"><label  class="desc" for="opt_cat">Fees Type<span class="alert">*</span></label>
                 <div><select class="listMenu" name="type" id="type">
                    <option value="all"></option>
                    <option value="computer">Computer Fees</option>
                    <option value="self">Self Fees</option>
              	 </select></div></li>
             <li class="notranslate"><label  class="desc" for="opt_cat">Type<span class="alert">*</span></label>
                 <div><select class="listMenu" name="class_type" id="class_type">
                    <option value="all">ALL</option>
                    <option value="self">SELF FINANCE</option>
                    <option value="aided">AIDED</option>
              	 </select></div></li>    
       <div><input type="submit" class="submit" name="save" value="Submit" style="margin-top:0px; margin-left:0px;"/></div>
       <input type="button" name="student_ledger" onClick="return class_report()" style="float: right;" value="Print">
    </form>
    
<table width="100%" border="1" id="feesreport">
	<tr style="background:#CCC; color:#FFF; text-align:center; font-size:13px;">
    	<td>S.No.</td>
        <td>CLASS</td>
        <td>DATE</td>
        <td>STUDENT COUNT</td>
        <td>COMPUTER/SELF FEES</td>
    </tr>
<?php 
$tot_stu_count=0;
$i=1;
$sql='select * from class_detail order by sort_no, class_description';
$res=execute_query(connect(), $sql);
while($class=mysqli_fetch_array($res)){
	$sql = "select *, student_info.sno as student_serial from fee_invoice3 join student_info on student_info.sno = fee_invoice3.student_id join class_detail on student_info.class = class_detail.sno where class_detail.sno=".$class['sno'];
	if(isset($_POST['dfc_date'])){
		$sql .= " and fee_invoice3.approval_date='".$_POST['dfc_date']."'";
	}
	if($_POST['type']=='computer'){
		$sql .= ' and fee_invoice3.type="computer"';
	}
	if($_POST['type']=='self'){
		$sql.=' and fee_invoice3.type="self"';
	}
	if($_POST['class_type']=='self'){
			$sql .= ' and class_detail.type="SELF"';
	}
	if($_POST['class_type']=='aided'){
			$sql.=' and class_detail.type!="SELF"';
	}
	if($class['sno']>=60 && $class['sno']<=75){
		$class['sno']=$class['sno']+1;
	}
	//echo $sql1.'</br>';
	$_SESSION['class_type3']=$_POST['class_type'];
	$_SESSION['comp_date3']=$_POST['dfc_date'];
	$_SESSION['type3']=$_POST['type'];
	$result = execute_query(connect(), $sql);
	$count = mysqli_num_rows($result);
	$tot_stu_count += $count;
	
	if($count!=0){
		echo '<tr>
		<td>'.$i++.'</td>
		<td>'.get_class_detail($class['sno'])['class_description'].'</td>
		<td>'.date("d-m-Y", strtotime($_POST['dfc_date'])).'</td>
		<td>'.$count.'</td>';
		$tot_fees=0;
		while($row = mysqli_fetch_array($result)){
			$tot_fees+=$row['tot_amount'];
		}
		$grand_fees+=$tot_fees;
		echo '<td>'.$tot_fees.'</td></tr>';
	}
}
echo '<tr><td colspan="3">GRAND TOTAL</td><td>'.$tot_stu_count.'</td><td>'.$grand_fees.'</td></tr></table>';
?>
<?php 
page_footer_store(); 
function editable($field){
	if($field!=''){
		echo 'readonly= "readonly"';
	}
}
?>
