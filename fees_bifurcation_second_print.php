<?php
session_start();
set_time_limit(0);
include("scripts/settings.php");
$sql3=$_SESSION['second_print'];
$sql= "select * from head_type";
$result_head = execute_query(connect(), $sql);
$count = mysqli_num_rows($result_head);  
?> 
<style>
body{
	width: 400mm;
}
#wrapper{width:400mm; border:1px solid; margin:5mm;}
td{font-size:12px; word-wrap:break-word; word-break:break-all;}
td.min{width:30px;}
</style>                                  
	<div id="wrapper">	
    
<table width="100%" border="1">
	<tr style="background:#CCC; color:#FFF; text-align:center; " >
    	<td rowspan="3">S.No.</td>
        <td rowspan="3" >STUDENT NAME</td>
        <td rowspan="3">CLASS</td>
        <td rowspan="3">ROLL NO</td>
        <td rowspan="3" >CATEGORY</td>
        <td rowspan="3" >GENDER</td>
        <td rowspan="3">Date</td>
        <td colspan="<?php echo $count-2; ?>">FEES HEADS (SECOND INSTALLMENT)</td>
        <td colspan="4">&nbsp;</td>
        <td rowspan="3">TOTAL2</td>
        <td rowspan="3">EXCESS</td>
        <td rowspan="3">FINAL TOTAL</td>
	</tr>
    <tr style="background:#CCC; color:#FFF; text-align:center; ">
    	<td colspan="4">MAINTENANCE</td>
    	<td colspan="14">&nbsp;</td>
    	<td colspan="12">UNIVERSITY FEES ACCOUNT</td>
    <!--    <td colspan="5"></td>
    	<td colspan="12">PRACTICAL FEES ACCOUNT</td> -->
    </tr>
    <tr style="background:#CCC; color:#FFF; text-align:center;">
<?php
while($row_head = mysqli_fetch_array($result_head)){
	if($row_head['sno']==4){
		echo '<td>Total1</td>';
	}
	if($row_head['sno']==23){
		echo '<td class="min">Lab Fee Half Yearly</td>';
	}
	echo '<td class="min">'.strtoupper($row_head['fee_type']).'</td>';
	$fees_division[$row_head['sno']]=0;
}
?>
</tr>
     <?php
	$tot[0]=0;
	for($td=1; $td<40; $td++){
		$tot[]=0;
		if($td==11){
			echo '<td class="min">11</td>';
		}
		//elseif($td==17){
			//echo '<td>17<br>(15+16)</td>';
		//}
		//elseif($td==30) {
			//echo '<td>30<br>(26+27+28+29)</td>';
		//}
		else{
			echo '<td>'.$td.'</td>';
		}
	}
	$tot[50]=0;
	$tot[52]=0;
	?>
    </tr>
<?php
$test='';
$result = execute_query(connect(), $sql3);
$i=1;
while($row = mysqli_fetch_array($result)){
	
	$final_res = fees_bifurcation_second($row);
	$sql = 'select * from head_type';
	$re = execute_query(connect(), $sql);
	echo '<tr>
	<td>'.$i++.'</td>'.$final_res[2].'</tr>';
	while($a = mysqli_fetch_array($re)){
		$tot[$a['sno']] += $final_res[1][$a['sno']];
	}
	$tot[50] += $final_res[1][50];
	$tot[22] += $final_res[1][22];
	$tot[52] += $final_res[1][52];
	$tot[30] += $final_res[1][30];
	$tot[31] += $final_res[1][31];
	$tot[32] += $final_res[1][32];
}

echo '<tr><td colspan="7">GRAND TOTAL :</td>';
$sql = 'select * from head_type';
$re = execute_query(connect(), $sql);
while($a = mysqli_fetch_array($re)){
	echo '<td>'.$tot[$a['sno']].'</td>';
	if($a['sno']==3)
	{
		echo '<td>'.$tot[50].'</td>';}
	if($a['sno']==21)
	{
		echo '<td>'.$tot[22].'</td>'; }
}
//echo '<td>-</td>';
//for($a=41;$a<=51;$a++){
	//echo $tot[$a].'<br>';
	echo '<td>'.$tot[52].'</td>';
	echo '<td>'.$tot[30].'</td>';
	echo '<td>'.$tot[31].'</td>';
//}
?>
	</table>
   </form></div></div>
