<?php
include("scripts/settings.php");
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
    <tr>
    	<td align="center" colspan="5">Second Installment</td>
    </tr>
	<tr>
    	<td>S.No.</td>
        <td>CLASS</td>
        <td>DATE</td>
        <td>STUDENT COUNT</td>
        <td><?php echo strtoupper($_POST['type'])?>&nbsp; FEES</td>
    </tr>
<?php 
$tot_stu_count=0;
$grand_fees=0;
$i=1;
//$sql='select * from class_detail order by sort_no, class_description';
$sql = 'select count(*) c, sum(amount_paid) as amount_paid, class_id, class_detail.type as type from fee_invoice3 left join class_detail on fee_invoice3.class_id = class_detail.sno where 1=1';
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
if($_POST['type']=='breakage'){
		$sql .= ' and fee_invoice3.type="breakage"';
}
if($_POST['class_type']=='aided'){
		$sql.=' and class_detail.type!="SELF"';
}
$sql .= ' group by class_id';
//echo $sql;
if(isset($_POST['dfc_date'])){
	$res=mysqli_query($db, $sql);
	while($row=mysqli_fetch_array($res)){
		$sql = 'select * from class_detail where sno="'.$row['class_id'].'"';
		$class = mysqli_fetch_array(execute_query(connect(), $sql));
		if($class['sno']>=60 && $class['sno']<=75){
			//$class['sno']=$class['sno']+1;
		}
		//echo $sql1.'</br>';
		$_SESSION['class_type3']=$_POST['class_type'];
		$_SESSION['comp_date3']=$_POST['dfc_date'];
		$_SESSION['type3']=$_POST['type'];
		$result = execute_query(connect(), $sql);
		$count = $row['c'];
		$tot_stu_count += $count;

		if($count!=0){
			echo '<tr>
			<td>'.$i++.'</td>
			<td>'.get_class_detail($class['sno'])['class_description'].'</td>
			<td>'.date("d-m-Y", strtotime($_POST['dfc_date'])).'</td>
			<td>'.$count.'</td>';
			$grand_fees+=$row['amount_paid'];
			echo '<td>'.$row['amount_paid'].'</td></tr>';
		}
	}
	echo '<tr><td colspan="3">GRAND TOTAL</td><td>'.$tot_stu_count.'</td><td>'.$grand_fees.'</td></tr></table>';
}
?>