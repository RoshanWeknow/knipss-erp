<?php
set_time_limit(0);
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
logvalidate('admin');
page_header_store();
$response=1;
$msg='';

$i=0;
?>
<h2>Fees <span class="orange">Bifurcation (Aided Subjects)</span></h2>
<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
         <li class="notranslate"><label  class="desc" for="name">Enter Bank User Id<span class="name">*</span></label>
        <div><input type="text" name="user_id" id="user_id" >
     </div>
         <li class="notranslate"><label  class="desc" for="name">Select Date<span class="name">*</span></label>
		<script type="text/javascript" language="javascript">
        DateInput('dfc_date', false, 'YYYY-MM-DD', '<?php if(isset($_POST['dfc_date'])){echo $_POST['dfc_date'];}else{echo date("Y-m-d");} ?>')
        </script>
	<div><input type="submit" class="submit" name="save" value="Submit" style="margin-top:0px; margin-left:0px;"/></div>
<?php
$sql= "select * from head_type";
$result_head = execute_query(connect(), $sql);
$count = mysqli_num_rows($result_head);
?>
<table width="100%" border="1" id="feesreport">
	<tr>
    	<th rowspan="3">S.No.</th>
        <th rowspan="3">STUDENT NAME</th>
        <th rowspan="3">CLASS</th>
        <th rowspan="3">ROLL NO</th>
        <th rowspan="3">CATEGORY</th>
        <th rowspan="3">GENDER</th>
        <th rowspan="3">DATE/TIME</th>
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
	for($td=1; $td<=51; $td++){
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
$sql = "select *, fee_invoice.sno as fees_serial, student_info.sno as student_serial from fee_invoice join student_info on fee_invoice.student_id = student_info.sno where amount_paid is not null ";
if(isset($_POST['user_id'])){
	if($_POST['user_id']!=''){
		$sql .= ' and user_id="'.$_POST['user_id'].'"';
	}
}
if(isset($_POST['dfc_date'])){
	$start = strtotime($_POST['dfc_date']);
	$end = $start+86400;	
	$sql .= " and timestamp>=".$start." and timestamp<".$end." order by fee_invoice.user_id, fee_invoice.timestamp";
}
else{
	$start = strtotime(date("Y-m-d"));
	$end = $start+86400;	
	$sql .= " and timestamp>=".$start." and timestamp<".$end." order by fee_invoice.user_id, fee_invoice.timestamp";
}
$result = execute_query(connect(), $sql);
$i=1;
while($row = mysqli_fetch_array($result)){
	$tot_fees=0;
	$fees_amount = calc_fees($row['class'],$row['sub1'],$row['sub2'],$row['sub3'],$row['gender']);
	$class = mysqli_fetch_array(execute_query(connect(), "select * from class_detail where sno=".$row['class']));
	
	$sql= "select * from head_type";
	$result_head = execute_query(connect(), $sql);
		
	if($class['type']!='self'){
		echo '<tr>
		<td>'.$i++.'</td>
		<td>'.$row['stu_name'].'</td>
		<td>'.$class['class_description'].'</td>
		<td>'.$row['roll_no'].'</td>
		<td>'.$row['category'].'</td>
		<td>'.$row['gender'].'</td>
		<td>'.date("d-m-Y",$row['timestamp']).'</td>';
	
		while($row_head = mysqli_fetch_array($result_head)){
			$sql = "select * from fees_detail where class_id=".$row['class']." and head_id=".$row_head['sno'];
			$fee = mysqli_fetch_array(execute_query(connect(), $sql));
			if($row['category']=='SC' or $row['category']=='ST'){
				if($row_head['sno']<=11){
					echo '<td>-</td>';
				}
				elseif($row_head['sno']==12){
					echo '<td>'.$fee['fee_amount'].'</td>';
					$tot_fees += $fee['fee_amount'];
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
					echo '<td>'.$prac_caution.'</td>';
					$tot_fees += $prac_caution;
				}
				elseif($row_head['sno']>=14 && $row_head['sno']<=16){
					echo '<td>-</td>';
				}
				elseif($row_head['sno']>=17 && $row_head['sno']<=19){
					echo '<td>'.$fee['fee_amount'].'</td>';
					$tot_fees += $fee['fee_amount'];
				}
				elseif($row_head['sno']==20){
					echo '<td>-</td>';
				}
				elseif($row_head['sno']==21){
					echo '<td>'.$fee['fee_amount'].'</td>';
					$tot_fees += $fee['fee_amount'];
				}
				elseif($row_head['sno']>=22 && $row_head['sno']<=26){
					echo '<td>-</td>';
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
					echo '<td>'.$self.'</td>';
					$tot_fees += $self;
				}
				elseif($row_head['sno']>=28 && $row_head['sno']<=30){
					echo '<td>'.$fee['fee_amount'].'</td>';
					$tot_fees += $fee['fee_amount'];
				}
				elseif($row_head['sno']>30){
					echo '<td>-</td>';
				}
			}
			else{
				if($row_head['sno']==1){
					if($row['gender']=='F'){
						echo '<td>-</td>';
					}
					else {
						echo '<td>'.$fee['fee_amount'].'</td>';
						$tot_fees += $fee['fee_amount'];
					}
					
				}
				elseif($row_head['sno']>=2 and $row_head['sno']<=12){
					echo '<td>'.$fee['fee_amount'].'</td>';
					$tot_fees += $fee['fee_amount'];			
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
					echo '<td>'.$prac_caution.'</td>';
					$tot_fees += $prac_caution;
				}
				elseif($row_head['sno']>=14 and $row_head['sno']<=26){
					echo '<td>'.$fee['fee_amount'].'</td>';
					$tot_fees += $fee['fee_amount'];			
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
					echo '<td>'.$self.'</td>';
					$tot_fees += $self;
				}
				elseif($row_head['sno']>=28 and $row_head['sno']<=29){
					echo '<td>'.$fee['fee_amount'].'</td>';
					$tot_fees += $fee['fee_amount'];			
				}
				elseif($row_head['sno']==30){
					echo '<td>-</td>';
				}
				elseif($row_head['sno']==31){
					echo '<td>'.$fee['fee_amount'].'</td>';
					$tot_fees += $fee['fee_amount'];			
				}
				elseif($row_head['sno']>31){
					echo '<td>-</td>';
				}
			}
		}
		$prac=0;
		echo '<td>-</td>';
		if($row['category']=='SC' or $row['category']=='ST'){
			echo '<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>';
		}
		else{
			if($row['sub1']=='20' or $row['sub2']=='20' or $row['sub3']=='20'){
				$sub1 = calc_sub_fees($row['class'],'20');
				echo '<td>'.$sub1['fees'].'</td>';
				$prac += $sub1['fees'];
				$tot_fees += $sub1['fees'];
			}
			else{
				echo '<td>-</td>';
			}
			if($row['sub1']=='19' or $row['sub2']=='19' or $row['sub3']=='19'){
				$sub1 = calc_sub_fees($row['class'],'19');
				echo '<td>'.$sub1['fees'].'</td>';
				$prac += $sub1['fees'];
				$tot_fees += $sub1['fees'];
			}
			else{
				echo '<td>-</td>';
			}
			if($row['sub1']=='17' or $row['sub2']=='17' or $row['sub3']=='17'){
				$sub1 = calc_sub_fees($row['class'],'17');
				echo '<td>'.$sub1['fees'].'</td>';
				$prac += $sub1['fees'];
				$tot_fees += $sub1['fees'];
			}
			else{
				echo '<td>-</td>';
			}
			if($row['sub1']=='16' or $row['sub2']=='16' or $row['sub3']=='16'){
				$sub1 = calc_sub_fees($row['class'],'16');
				echo '<td>'.$sub1['fees'].'</td>';
				$prac += $sub1['fees'];
				$tot_fees += $sub1['fees'];
			}
			else{
				echo '<td>-</td>';
			}
			if($row['sub1']=='22' or $row['sub2']=='22' or $row['sub3']=='22' or $row['class']=='24' or $row['class']=='25'){
				$sub1 = calc_sub_fees($row['class'],'22');
				echo '<td>'.$sub1['fees'].'</td>';
				$prac += $sub1['fees'];
				$tot_fees += $sub1['fees'];
			}
			else{
				echo '<td>-</td>';
			}
			if($row['sub1']=='10' or $row['sub2']=='10' or $row['sub3']=='10' or $row['class']=='16' or $row['class']=='17'){
				$sub1 = calc_sub_fees($row['class'],'10');
				echo '<td>'.$sub1['fees'].'</td>';
				$prac += $sub1['fees'];
				$tot_fees += $sub1['fees'];
			}
			else{
				echo '<td>-</td>';
			}
			if($row['sub1']=='36' or $row['sub2']=='36' or $row['sub3']=='36'){
				$sub1 = calc_sub_fees($row['class'],'36');
				echo '<td>'.$sub1['fees'].'</td>';
				$prac += $sub1['fees'];
				$tot_fees += $sub1['fees'];
			}
			else{
				echo '<td>-</td>';
			}
			if($row['sub1']=='24' or $row['sub2']=='24' or $row['sub3']=='24'){
				$sub1 = calc_sub_fees($row['class'],'24');
				echo '<td>'.$sub1['fees'].'</td>';
				$prac += $sub1['fees'];
				$tot_fees += $sub1['fees'];
			}
			else{
				echo '<td>-</td>';
			}
		}
		echo '<th>'.$prac.'</th>
		<th>'.$tot_fees.'</th>';
		$sql = 'select * from fee_invoice where class_id="'.$row['class'].'" and student_id="'.$row['student_serial'].'" and amount_paid is not NULL';
		$amount_paid = mysqli_fetch_array(execute_query(connect(), $sql));
		$amount_paid = $amount_paid['amount_paid'];
	echo '
	<th>'.$amount_paid.'</th>';
	if($amount_paid!=$tot_fees){
		echo '<th>ERROR</th>';
	}
	echo '
	</tr>';
	}
}
?>