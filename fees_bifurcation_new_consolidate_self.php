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
if(isset($_POST['total_student'])){
	$sql = 'select * from fees_transfer where month="'.$_POST['dfc_date'].'" and type="self"';
	$res = execute_query(connect(), $sql);
	if(mysqli_num_rows($res)==0){
		$sql = 'insert into fees_transfer (head_id, amount, timestamp, type, month) values ';
		$comma=0;
		foreach($_POST as $k => $v){
			if($comma==0){
				$sql .= '("'.$k.'", "'.$v.'", "'.time().'", "self", "'.$_POST['dfc_date'].'")';
				$comma=1;
			}
			else{
				$sql .= ', ("'.$k.'", "'.$v.'", "'.time().'", "self", "'.$_POST['dfc_date'].'")';
			}
		}
		//echo $sql;
		execute_query(connect(), $sql);
	}
	else{
		$msg .= '<h2>Transfer Already Generated.</h2>';
	}
	
}
?>
<script language="javascript" type="text/javascript">
function print_chart(){
	var dfc_date = document.getElementById('dfc_date').value;
	window.open("fees_bifurcation_new_transfer_sheet.php?type=self&dfc_date="+dfc_date);
}

</script>
<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
    	<h2>Fees <span class="orange">Bifurcation (Self Finance Subjects)</span></h2>
         <li class="notranslate"><label  class="desc" for="name">Enter Bank User Id<span class="name">*</span></label>
         <div><input type="text" name="user_id" id="user_id" ></div></li>
         
         <li class="notranslate"><label  class="desc" for="name">Select Date<span class="name">*</span></label>
			<script type="text/javascript" language="javascript">
            DateInput('dfc_date', false, 'YYYY-MM-DD', '<?php if(isset($_POST['dfc_date'])){echo $_POST['dfc_date'];}else{echo date("Y-m-d");} ?>')
            </script></li>
            
	<div><input type="submit" class="submit" name="save" value="Submit" style="margin-top:0px; margin-left:0px;"/></div>
    </form></div></div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
<?php
$sql= "select * from head_type";
$result_head = execute_query(connect(), $sql);
$count = mysqli_num_rows($result_head);
?>
<table width="100%" border="1" id="feesreport">
	<tr>
    	<th rowspan="3">S.No.</th>
        <th rowspan="3">DATE/TIME</th>
        <th rowspan="3">STUDENT COUNT</th>
        <th colspan="<?php echo $count-2; ?>">FEES HEADS</th>
        <th colspan="12">&nbsp;</th>
        <th rowspan="3">TOTAL (12 to 51)</th>
        <th rowspan="3">TOTAL DEPOSITED</th>
	</tr>
    <tr>
    	<th colspan="4">MAINTENANCE</th>
    	<th colspan="14">&nbsp;</th>
    	<th colspan="5">UNIVERSITY FEES ACCOUNT</th>
        <th colspan="5"></th>
    	<th colspan="12">PRACTICAL FEES ACCOUNT</th>
    </tr>
    <tr>
<?php
while($row_head = mysqli_fetch_array($result_head)){
	echo '<td>'.strtoupper($row_head['fee_type']).'</td>';
	$fees_division[$row_head['sno']]=0;
}
?>
	<td>TOTAL FEES</td>
    <td>ZOOLOGY PRACTICAL FEES</td>
    <td>BOTANY PRACTICAL FEES</td>
    <td>CHEMISTRY PRACTICAL FEES</td>
    <td>PHYSICS PRACTICAL FEES</td>
    <td>MILITARY SCIENCE PRACTICAL FEES</td>
    <td>GEOGRAPHY PRACTICAL FEES</td>
    <td>HOME SCIENCE PRACTICAL FEES</td>
    <td>PHYSICAL EDUCATION PRACTICAL FEES</td>
    <th>TOTAL PRACTICAL FEES (36 to 50)</th>
    </tr>
     <?php
	$grand_tot[0]=0;
	for($td=1; $td<=51; $td++){
		$grand_tot[]=0;
		if($td==11){
			//echo '<td>11<br>(8+9+10)</td>';
		}
		elseif($td==17){
			//echo '<td>17<br>(15+16)</td>';
		}
		elseif($td==30) {
			//echo '<td>30<br>(26+27+28+29)</td>';
		}
		else{
			echo '<td>'.$td.'</td>';
		}
	}
	?>
    </tr>
<?php
$test='';
$tot_stu_count=0;
if(isset($_POST['dfc_date'])){
	$start = strtotime($_POST['dfc_date']);
	$start = date("01-m-Y",$start);
	$start = strtotime($start);
	$end = strtotime(date("Y-m-d",$start) . " +1 month");
	
	//$start = strtotime("2013-07-16");
	//$end = strtotime("2013-07-17");
}
else{
	$start = strtotime(date("Y-m-d"));
	$end = $start+86400;	
}
echo '<input type="hidden" value="'.date("Y-m-01",$start).'" name="month">';
$i=1;
while($start<$end){
	unset($tot);
	$tot[0]=0;
	for($td=1; $td<=51; $td++){
		$tot[]=0;
	}
	$sub_end = strtotime(date("Y-m-d",$start)."+1 day");
	$sql = "select *, student_info.sno as student_serial, student_info.category as student_category from fee_invoice join student_info on student_info.sno = student_id join class_detail on student_info.class = class_detail.sno where amount_paid is not null and class_detail.type='self'";
	$sql .= " and timestamp>=".$start." and timestamp<".$sub_end." order by fee_invoice.sno";
	
	//echo $sql.' - '.date("d-m-Y", $start).' - '.date("d-m-Y", $sub_end).'<br>';
	$result = execute_query(connect(), $sql);
	$count = mysqli_num_rows($result);
	echo '<tr>
	<td>'.$i++.'</td>
	<td>'.date("d-m-Y",$start).'</td>
	<td>'.$count.'</td>';

	while($row = mysqli_fetch_array($result)){
		$tot_fees=0;
		$fees_amount = calc_fees($row['class'],$row['sub1'],$row['sub2'],$row['sub3'],$row['gender'], $row['student_category']);
		$class = mysqli_fetch_array(execute_query(connect(), "select * from class_detail where sno=".$row['class']));
		
		$sql= "select * from head_type";
		$result_head = execute_query(connect(), $sql);
		//echo $row['student_category'].'<br>';	
		if($row['annual_income']>200000){
			$row['student_category']='GEN';
		}	
		if($class['type']!='aided'){
			while($row_head = mysqli_fetch_array($result_head)){
				$sql = "select * from fees_detail where class_id=".$row['class']." and head_id=".$row_head['sno'];
				$fee = mysqli_fetch_array(execute_query(connect(), $sql));
				if(1==2){
					if($row_head['sno']<=11){
						//echo '<td>-</td>';
					}
					elseif($row_head['sno']==12){
						//echo '<td>'.$fee['fee_amount'].'</td>';
						$tot_fees += $fee['fee_amount'];
						$tot[$row_head['sno']]+=$fee['fee_amount'];
					}
					elseif($row_head['sno']==13){
						$sub1 = calc_sub_fees($row['class'],$row['sub1']);
						$sub2 = calc_sub_fees($row['class'],$row['sub2']);
						$sub3 = calc_sub_fees($row['class'],$row['sub3']);
						$prac_caution=0;
						if($sub1['fees']>0){
							$prac_caution += $fee['fee_amount'];
						}
						if($sub2['fees']>0){
							$prac_caution += $fee['fee_amount'];
						}
						if($sub3['fees']>0){
							$prac_caution += $fee['fee_amount'];
						}
						//echo '<td>'.$prac_caution.'</td>';
						$tot_fees += $prac_caution;
						$tot[$row_head['sno']]+=$prac_caution;
					}
					elseif($row_head['sno']>=14 && $row_head['sno']<=16){
						//echo '<td>-</td>';
					}
					elseif($row_head['sno']=17){
						if($fee['fee_amount']!=0 && $row['other_univ']!='awadh'){
							//echo '<td>'.$fee['fee_amount'].'</td>';
							$tot_fees += $fee['fee_amount'];
							$tot[$row_head['sno']]+=$fee['fee_amount'];						
						}
						else{
							//echo '<td>0</td>';
						}
					}
					elseif($row_head['sno']>=18 && $row_head['sno']<=20){
						//echo '<td>'.$fee['fee_amount'].'</td>';
						$tot_fees += $fee['fee_amount'];
						$tot[$row_head['sno']]+=$fee['fee_amount'];
					}
					elseif($row_head['sno']==21){
						//echo '<td>'.$fee['fee_amount'].'</td>';
						$tot_fees += $fee['fee_amount'];
						$tot[$row_head['sno']]+=$fee['fee_amount'];
					}
					elseif($row_head['sno']==22){
						//echo '<td>-</td>';
					}
					elseif($row_head['sno']>=23 && $row_head['sno']<=24){
						if($row['class']!=1 && $row['class']!=4){	
							//echo '<td>'.$fee['fee_amount'].'</td>';
							$tot_fees += $fee['fee_amount'];
							$tot[$row_head['sno']]+=$fee['fee_amount'];
						}
						else{
							//echo '<td>-</td>';
						}
					}
					elseif($row_head['sno']>=25 && $row_head['sno']<=26){
						//echo '<td>-</td>';
					}
					elseif($row_head['sno']==27){
						$self=0;
						$sub1 = calc_sub_fees($row['class'],$row['sub1']);
						$sub2 = calc_sub_fees($row['class'],$row['sub2']);
						$sub3 = calc_sub_fees($row['class'],$row['sub3']);
						if($sub1['type']=='self'){
							$self += $fee['fee_amount'];
						}
						if($sub2['type']=='self'){
							$self += $fee['fee_amount'];
						}
						if($sub3['type']=='self'){
							$self += $fee['fee_amount'];
						}
						//echo '<td>'.$self.'</td>';
						$tot_fees += $self;
						$tot[$row_head['sno']]+=$self;
					}
					elseif($row_head['sno']>=28 && $row_head['sno']<=30){
						//echo '<td>'.$fee['fee_amount'].'</td>';
						$tot_fees += $fee['fee_amount'];
						$tot[$row_head['sno']]+=$fee['fee_amount'];
					}
					elseif($row_head['sno']=31){
						//echo '<td>'.$fee['fee_amount'].'</td>';
						$tot_fees += $fee['fee_amount'];
						$tot[$row_head['sno']]+=$fee['fee_amount'];
					}
					elseif($row_head['sno']=32){
						//echo '<td>'.$fee['fee_amount'].'</td>';
						$tot_fees += $fee['fee_amount'];
						$tot[$row_head['sno']]+=$fee['fee_amount'];
					}
					elseif($row_head['sno']>32){
						//echo '<td>-</td>';
					}
				}
				else{
					if($row_head['sno']==1){
						if($row['gender']=='F'){
							//echo '<td>-</td>';
						}
						else {
							//echo '<td>'.$fee['fee_amount'].'</td>';
							$tot_fees += $fee['fee_amount'];
							$tot[$row_head['sno']]+=$fee['fee_amount'];
						}
						
					}
					elseif($row_head['sno']>=2 and $row_head['sno']<=12){
						//echo '<td>'.$fee['fee_amount'].'</td>';
						$tot_fees += $fee['fee_amount'];			
						$tot[$row_head['sno']]+=$fee['fee_amount'];
					}
					elseif($row_head['sno']==13){
						$sub1 = calc_sub_fees($row['class'],$row['sub1']);
						$sub2 = calc_sub_fees($row['class'],$row['sub2']);
						$sub3 = calc_sub_fees($row['class'],$row['sub3']);
						$prac_caution=0;
						if($sub1['fees']>0){
							$prac_caution += $fee['fee_amount'];
						}
						if($sub2['fees']>0){
							$prac_caution += $fee['fee_amount'];
						}
						if($sub3['fees']>0){
							$prac_caution += $fee['fee_amount'];
						}
						//echo '<td>'.$prac_caution.'</td>';
						$tot_fees += $prac_caution;
						$tot[$row_head['sno']]+=$prac_caution;
					}
					elseif($row_head['sno']>=14 and $row_head['sno']<=26){
						//echo '<td>'.$fee['fee_amount'].'</td>';
						$tot_fees += $fee['fee_amount'];			
						$tot[$row_head['sno']]+=$fee['fee_amount'];
					}
					elseif($row_head['sno']==27){
						$self=0;
						$sub1 = calc_sub_fees($row['class'],$row['sub1']);
						$sub2 = calc_sub_fees($row['class'],$row['sub2']);
						$sub3 = calc_sub_fees($row['class'],$row['sub3']);
						if($sub1['type']=='self'){
							$self += $fee['fee_amount'];
						}
						if($sub2['type']=='self'){
							$self += $fee['fee_amount'];
						}
						if($sub3['type']=='self'){
							$self += $fee['fee_amount'];
						}
						//echo '<td>'.$self.'</td>';
						$tot_fees += $self;
						$tot[$row_head['sno']]+=$self;
					}
					elseif($row_head['sno']>=28 and $row_head['sno']<=29){
						//echo '<td>'.$fee['fee_amount'].'</td>';
						$tot_fees += $fee['fee_amount'];			
						$tot[$row_head['sno']]+=$fee['fee_amount'];
					}
					elseif($row_head['sno']==30){
						//echo '<td>-</td>';
					}
					elseif($row_head['sno']==31){
						//echo '<td>'.$fee['fee_amount'].'</td>';
						$tot_fees += $fee['fee_amount'];
						$tot[$row_head['sno']]+=$fee['fee_amount'];			
					}
					elseif($row_head['sno']==32){
						//echo '<td>'.$fee['fee_amount'].'</td>';
						$tot_fees += $fee['fee_amount'];
						$tot[$row_head['sno']]+=$fee['fee_amount'];			
					}
					elseif($row_head['sno']>32){
						//echo '<td>@</td>';
						//echo '<td>'.$fee['fee_amount'].'</td>';
						$tot_fees += $fee['fee_amount'];
						$tot[$row_head['sno']]+=$fee['fee_amount'];			
					}
				}
			}
			$prac=0;
			//echo '<td>-</td>';
			if($row['category']=='SC' or $row['category']=='ST'){
				/*echo '<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>';*/
			}
			else{
				if($row['sub1']=='20' or $row['sub2']=='20' or $row['sub3']=='20'){
					$sub1 = calc_sub_fees($row['class'],'20');
					//echo '<td>'.$sub1['fees'].'</td>';
					$prac += $sub1['fees'];
					$tot_fees += $sub1['fees'];
					$tot[41]+=$sub1['fees'];
				}
				else{
					//echo '<td>-</td>';
				}
				if($row['sub1']=='19' or $row['sub2']=='19' or $row['sub3']=='19'){
					$sub1 = calc_sub_fees($row['class'],'19');
					//echo '<td>'.$sub1['fees'].'</td>';
					$prac += $sub1['fees'];
					$tot_fees += $sub1['fees'];
					$tot[42]+=$sub1['fees'];
				}
				else{
					//echo '<td>-</td>';
				}
				if($row['sub1']=='17' or $row['sub2']=='17' or $row['sub3']=='17'){
					$sub1 = calc_sub_fees($row['class'],'17');
					//echo '<td>'.$sub1['fees'].'</td>';
					$prac += $sub1['fees'];
					$tot_fees += $sub1['fees'];
					$tot[43]+=$sub1['fees'];
				}
				else{
					//echo '<td>-</td>';
				}
				if($row['sub1']=='16' or $row['sub2']=='16' or $row['sub3']=='16'){
					$sub1 = calc_sub_fees($row['class'],'16');
					//echo '<td>'.$sub1['fees'].'</td>';
					$prac += $sub1['fees'];
					$tot_fees += $sub1['fees'];
					$tot[44]+=$sub1['fees'];
				}
				else{
					//echo '<td>-</td>';
				}
				if($row['sub1']=='22' or $row['sub2']=='22' or $row['sub3']=='22' or $row['class']=='24' or $row['class']=='25'){
					$sub1 = calc_sub_fees($row['class'],'22');
					//echo '<td>'.$sub1['fees'].'</td>';
					$prac += $sub1['fees'];
					$tot_fees += $sub1['fees'];
					$tot[45]+=$sub1['fees'];
				}
				else{
					//echo '<td>-</td>';
				}
				if($row['sub1']=='10' or $row['sub2']=='10' or $row['sub3']=='10' or $row['class']=='16' or $row['class']=='17'){
					$sub1 = calc_sub_fees($row['class'],'10');
					//echo '<td>'.$sub1['fees'].'</td>';
					$prac += $sub1['fees'];
					$tot_fees += $sub1['fees'];
					$tot[46]+=$sub1['fees'];
				}
				else{
					//echo '<td>-</td>';
				}
				if($row['sub1']=='36' or $row['sub2']=='36' or $row['sub3']=='36'){
					$sub1 = calc_sub_fees($row['class'],'36');
					//echo '<td>'.$sub1['fees'].'</td>';
					$prac += $sub1['fees'];
					$tot_fees += $sub1['fees'];
					$tot[47]+=$sub1['fees'];
				}
				else{
					//echo '<td>-</td>';
				}
				if($row['sub1']=='24' or $row['sub2']=='24' or $row['sub3']=='24'){
					$sub1 = calc_sub_fees($row['class'],'24');
					//echo '<td>'.$sub1['fees'].'</td>';
					$prac += $sub1['fees'];
					$tot_fees += $sub1['fees'];
					$tot[48]+=$sub1['fees'];
				}
				else{
					//echo '<td>-</td>';
				}
			}
			/*echo '<th>'.$prac.'</th>
			<th>'.$tot_fees.'</th>';*/
			$sql = 'select * from fee_invoice where class_id="'.$row['class'].'" and student_id="'.$row['student_serial'].'" and amount_paid is not NULL';
			$amount_paid = mysqli_fetch_array(execute_query(connect(), $sql));
			$amount_paid = $amount_paid['amount_paid'];
		/*echo '
		<th>'.$amount_paid.'</th>';*/
			$tot[49]+=$prac;
			$tot[50]+=$tot_fees;
			$tot[51]+=$amount_paid;
		if($amount_paid!=$tot_fees){
			//echo '<th>ERROR</th>';
		}
		//echo '</tr>';
		}
	}
	$start = $sub_end;
	//echo '<tr><th colspan="2">GRAND TOTAL :</th>';
	$sql = 'select * from head_type';
	$re = execute_query(connect(), $sql);
	while($a = mysqli_fetch_array($re)){
		echo '<th>'.$tot[$a['sno']].'</th>';
	}
	echo '<th>-</th>';
	for($a=41;$a<=51;$a++){
		echo '<th>'.$tot[$a].'</th>';
	}
	for($td=1; $td<=51; $td++){
		$grand_tot[$td]+=$tot[$td];
	}
}
echo '<tr><th colspan="2">GRAND TOTAL :</th>
<th>'.$tot_stu_count.'
<input type="hidden" name="total_student" value="'.$tot_stu_count.'"></th>';
	$sql = 'select * from head_type';
	$re = execute_query(connect(), $sql);
	while($a = mysqli_fetch_array($re)){
		echo '<th>'.$grand_tot[$a['sno']].'<input type="hidden" name="fees_total_'.$a['sno'].'" value="'.$grand_tot[$a['sno']].'"></th>';
	}
	echo '<th>-</th>';
	for($a=41;$a<=51;$a++){
		echo '<th>'.$grand_tot[$a].'<input type="hidden" name="fees_total_'.$a.'" value="'.$grand_tot[$a].'"></th>';
	}
	$date= date("Y-m", strtotime($_POST['dfc_date']));
	echo '
	<input type="hidden" name="dfc_date" value="'.$date.'" id="dfc_date" >
	<input type="Submit" name="submit" value="Generate Fees Transfer" class="submit">
	<input type="button" name="print_sheet" value="Print Fees Transfer Chart" onClick="print_chart()" class="submit">
	</form>';
?>
<?php 
page_footer_store(); 
function editable($field){
	if($field!=''){
		echo 'readonly= "readonly"';
	}
}
?>