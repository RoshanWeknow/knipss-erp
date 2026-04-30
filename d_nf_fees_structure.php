<?php
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$msg='';
$tab=1;
$response=1;

function get_head_name($id){
	global $db;
	$sql = execute_query($db, 'select * from d_fees_head_master where sno='.$id);
	if($sql){
		$row = mysqli_fetch_assoc($sql);
	}	
	return $row['head_name'];
}
if(isset($_GET['vfs'])){
	$response=2;
}
if(isset($_POST['submit'])){
	$_POST['head_name'] = trim($_POST['head_name']);
	if($_POST['class_name']==''){
		$msg .='<li>Please Select Class Name</li>';
	}
	if($_POST['head_name']==''){
		$msg .='<li>Please Select Head Name</li>';
	}
	if($_POST['amount']==''){
		$msg .='<li>Please Enter Amount</li>';
	}
	
	if($msg==''){
		if($_POST['edit_id']!=''){
			$sql = 'delete from d_fees_structure where class_id='.$_POST['class_name'].' and head_id='.$_POST['head_name'];
			execute_query($db, $sql);
			if(mysqli_error($db)){
				$msg .= '<li>Error # 1 : '.mysqli_error($db).' >> '.$sql.' </li>';
			}
		}		
		$sql = 'select * from d_fees_structure where head_id="'.$_POST['head_name'].'" and class_id="'.$_POST['class_name'].'" and student_type="'.$_POST['student_type'].'"';
		//echo $sql;
		$result = execute_query($db, $sql);
		if(mysqli_num_rows($result)!=0){
			$msg .= '<li>Duplicate.</li>';
		}
		if($msg==''){
			if($_POST['recurring_duration']=='month'){
				foreach($_POST['specific_month'] as $k=>$v){
					$sql = 'insert into d_fees_structure (class_id, head_id, student_type, recurring_duration, amount, status) 
					value ("'.$_POST['class_name'].'", "'.$_POST['head_name'].'", "'.$_POST['student_type'].'", "'.$v.'", "'.$_POST['amount'].'", "0")';
					execute_query($db, $sql);
					if(mysqli_error($db)){
						$msg .= '<li>Error # 1 : '.mysqli_error($db).' >> '.$sql.' </li>';
					}
				}
				if($msg==''){
					$msg .= '<li>Data Saved</li>';
				}

			}
			else{
				$sql = 'insert into d_fees_structure (class_id, head_id, student_type, recurring_duration, amount, status) 
				value ("'.$_POST['class_name'].'", "'.$_POST['head_name'].'", "'.$_POST['student_type'].'", "'.$_POST['recurring_duration'].'", "'.$_POST['amount'].'", "0")';
				execute_query($db, $sql);
				if(mysqli_error($db)){
					$msg .= '<li>Error # 1 : '.mysqli_error($db).' >> '.$sql.' </li>';
				}
				else{
					$msg = '<li>Data Saved</li>'; 
					$_POST['recurring_duration']='';
					$_POST['head_name']='';
					$_POST['student_type']='';
					$_POST['class_name']='';
					$_POST['amount']='';
					$_POST['edit_id']='';

				}
			}
		}
	}
}
elseif(isset($_GET['ed'])){
	$sql = 'SELECT d_fees_structure.sno as sno, d_fees_structure.class_id, d_fees_head_master.sort_no as sort_no, d_fees_structure.head_id, d_fees_structure.recurring_duration, d_fees_structure.amount, d_fees_structure.status, class_desc, student_type, head_name FROM `d_fees_structure` left join d_class on d_class.sno = class_id left join d_fees_head_master on d_fees_head_master.sno = head_id where class_id='.$_GET['cl'].' and head_id='.$_GET['ed'];
	//echo $sql;
	$result_head_val = execute_query($db, $sql);
	$_POST['month'] = array();
	while($details=mysqli_fetch_assoc($result_head_val)){
		$_POST['head_name'] = $details['head_id'];
		$_POST['class_name'] = $details['class_id'];
		$_POST['amount'] = $details['amount'];
		$_POST['student_type'] = $details['student_type'];
		$_POST['sort_no'] = $details['sort_no'];
		if(is_numeric($details['recurring_duration'])){
			$_POST['recurring_duration'] = $details['recurring_duration'];
		}
		else{
			$_POST['recurring_duration'] = 'month';
			$_POST['month'][] = $details['recurring_duration'];
		}
		$_POST['status'] = $details['status'];
		$_POST['edit_id'] = $details['sno'];
	}
	
}
else{
	$_POST['recurring_duration']='';
	$_POST['head_name']='';
	$_POST['class_name']='';
	$_POST['amount']='';
	$_POST['student_type']='';
	$_POST['edit_id']='';
}
if(isset($_GET['del'])){
	$sql = 'delete from d_fees_head_master where sno='.$_GET['del'];
	$delete=execute_query($db, $sql);
	$msg = '<li>Fee Type Deleted.</li>';
	
}

?>
<link rel="stylesheet" type="text/css" href="css/jquery.multiselect.css" />
<script src="js/jquery.multiselect.js"></script>
<script>
function change_duration(){	
	var val = $("#recurring_duration").val();
	if(val=='month'){
		var txt = '<select name="specific_month[]" id="specific_month" class="form-control" multiple><option value="jan">January</option><option value="feb">February</option><option value="mar">March</option><option value="apr">April</option><option value="may">May</option><option value="jun">June</option><option value="jul">July</option><option value="aug">August</option><option value="sep">September</option><option value="oct">October</option><option value="nov">November</option><option value="dec">December</option></select>';
		
		<?php
			if($_POST['recurring_duration']=='month'){
				echo "var txt='<select name=\"specific_month[]\" id=\"specific_month\" class=\"form-control\" multiple>";
				for($i=1;$i<=12;$i++){
					$dateObj   = DateTime::createFromFormat('!m', $i);
					$monthName = strtolower($dateObj->format('M')); // mar
					$monthName_full = $dateObj->format('F'); // March
					echo '<option value="'.$monthName.'" ';
					foreach($_POST['month'] as $x){
						if($monthName==$x){
							echo ' selected="selected" ';
						}
					}
					echo '>'.$monthName_full.'</option>';
				}
				echo "</select>';";
			}
		?>
		
		$("#specific_month_box").html(txt);
		$('select[multiple]').multiselect({
			columns: 1,
			placeholder: 'Select options',
			search: true});
		$('select[multiple]').multiselect({
			<?php
			if($_POST['recurring_duration']=='month'){
				//echo ', '."\n";
				echo 'loadOption: [{value : "'.implode('", checked: true}, {value : "', $_POST['month']).'", checked: true}]'."\n";
			}
			?>
		});	
	}
	else{
		$("#specific_month_box").html('');
	}
	
}
</script>
<?php
page_header_end();
page_sidebar();
?>

<?php
	switch($response){
		case 1:{
	?>
		<div id="container">
		<div class="card card-body ">
			<div class="row d-flex my-auto">
			<?php
				if($msg!=''){
					echo '<tr><td colspan="4"><ul class="alert alert-danger">'.$msg.'</ul></td></tr>';
				}
			?>
			<div class="bg-primary text-white p-2"><h3>Fee Structure</h3></div>
			<form action="<?php echo $_SERVER['PHP_SELF'];?>" name="data_form" enctype="multipart/form-data" method="post">
				<table class="table table-responsive table-striped">
					
					<tr>
						<td>Class</td>
						<td><select name="class_name" id="class_name" class="form-control" tabindex="<?php echo $tab++; ?>"> 
							<option value=""></option>
							<?php
							$sql = 'select d_section.sno as sno, d_class.class_desc as class_desc, d_section.section as section from d_section left join d_class on d_class.sno = d_section.class_desc';
							$result = execute_query($db, $sql);
							if($result){
							while($row = mysqli_fetch_assoc($result)){
								echo '<option value="'.$row['sno'].'" ';
								if($row['sno']==$_POST['class_name']){
									echo ' selected="selected" ';
								}
								echo '>'.$row['class_desc'].' '.$row['section'].'</option>';
							}}

							?>
							</select>
						</td>
						<td>Fees Head</td>
						<td><select name="head_name" id="head_name" class="form-control" tabindex="<?php echo $tab++; ?>"> 
							<option value=""></option>
							<?php
							$sql = 'select * from d_fees_head_master';
							$result = execute_query($db, $sql);
							if($result){
							while($row = mysqli_fetch_assoc($result)){
								echo '<option value="'.$row['sno'].'" ';
								if($row['sno']==$_POST['head_name']){
									echo ' selected="selected" ';
								}
								echo '>'.$row['head_name'].'</option>';
							}
							}
							?>
							</select>
						</td>
						<td>For Student Type</td>
						<td>
							<select name="student_type" id="student_type" class="form-control" tabindex="<?php echo $tab++; ?>">
								<option value="" <?php if($_POST['student_type']==''){echo ' selected="selected" ';} ?>>All</option>
								<option value="old_admission" <?php if($_POST['student_type']=='class'){echo ' selected="selected" ';} ?>>Old Admission</option>
								<option value="new_admission" <?php if($_POST['student_type']=='student'){echo ' selected="selected" ';} ?>>New Admission</option>				
							</select>

						</td>
					</tr>
					<tr>
						<td>Amount</td>
						<td><input type="text" name="amount" id="amount" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['amount']; ?>"></td>
						<td>Recurring Duration</td>
						<td>
							<select name="recurring_duration" id="recurring_duration" class="form-control" tabindex="<?php echo $tab++; ?>" onChange="change_duration(this.value);"> 
								<option value="1" <?php if($_POST['recurring_duration']==1){echo ' selected="selected" ';} ?> >Monthly</option>
								<option value="2" <?php if($_POST['recurring_duration']==2){echo ' selected="selected" ';} ?> >Bi-Monthly</option>
								<option value="3" <?php if($_POST['recurring_duration']==3){echo ' selected="selected" ';} ?> >Quarterly</option>
								<option value="6" <?php if($_POST['recurring_duration']==6){echo ' selected="selected" ';} ?> >Half-Yearly</option>
								<option value="12" <?php if($_POST['recurring_duration']==12){echo ' selected="selected" ';} ?> >Yearly</option>
								<option value="month" <?php if($_POST['recurring_duration']=='month'){echo ' selected="selected" ';} ?> >Specific Month</option>
							</select>		
						</td>
						<td>Select Months</td>
						<td id="specific_month_box"></td>
					</tr>
				</table>
				<input type="submit" class="submit btn btn-primary" name="submit" value="Submit" onClick="return confirm('Are you sure?')"/>
			</div>
			</div>
		<div class="card card-body ">
			<div class="row d-flex my-auto">	
				<table width="100%" class="table table-responsive table-striped">
					<thead>
					<tr class="bg-primary text-white">
						<th>Sno</th>
						<th>Class Name</th>
						<th>Total Annual Fees</th>
						<th>Total Discount</th>
						<th>Net Fees</th>
						<th></th>
				   </tr>
					</thead>
				   <?php
					$sql = 'select d_section.sno as sno, d_class.class_desc as class_desc, d_section.section as section from d_section left join d_class on d_class.sno = d_section.class_desc order by sno';
					$res = execute_query($db, $sql);
					$i=1;
					$total_fees=0;
					$col='';
					if($res){
					while($fees=mysqli_fetch_array($res)){
						$sql = 'SELECT d_fees_structure.sno as sno, d_fees_structure.class_id, d_fees_structure.head_id, d_fees_structure.recurring_duration, d_fees_structure.amount, d_fees_structure.status, d_class.class_desc, head_name, student_type FROM `d_fees_structure` left join d_section on d_section.sno = d_fees_structure.class_id left join d_class on d_class.sno = d_section.class_desc left join d_fees_head_master on d_fees_head_master.sno = head_id where class_id='.$fees['sno'];
						//echo $sql;
						$result = execute_query($db, $sql);
						//echo mysqli_error($db);
						$total_fees=0;
						$total_discount=0;
						$head_array = array();
						while($row = mysqli_fetch_assoc($result)){
							$head_array[] = $row['head_id'];
							$sql = 'select * from d_discount_structure where discount_type="class" and discount_id="'.$fees['sno'].'" and head_id="'.$row['head_id'].'"';
							$discout_result = execute_query($db, $sql);
							if($discout_result && mysqli_num_rows($discout_result)!=0){
								$row_discount = mysqli_fetch_assoc($discout_result);
							}
							else{
								$row_discount['discount_value']=0;
							}
							switch($row['recurring_duration']){
								case 1:{
									$total_fees+=($row['amount']*12);
									$total_discount+=($row_discount['discount_value']*12);
									break;
								}
								case 2:{
									$total_fees+=($row['amount']*6);
									$total_discount+=($row_discount['discount_value']*6);
									break;
								}
								case 3:{
									$total_fees+=($row['amount']*4);
									$total_discount+=($row_discount['discount_value']*4);
									break;
								}
								case 6:{
									$total_fees+=($row['amount']*2);
									$total_discount+=($row_discount['discount_value']*2);
									break;
								}
								case 12:{
									$total_fees+=($row['amount']*1);
									// echo $row_discount['discount_value'];
									$total_discount+=($row_discount['discount_value']*1);
									break;
								}
								default:{
									$total_fees+=($row['amount']);
									$total_discount+=($row_discount['discount_value']);
									break;
								}
								
							}
						}
						$sql = 'select * from d_discount_structure where discount_type="class" and discount_id="'.$fees['sno'].'" and (head_id is null or head_id="")';
						$discout_result = execute_query($db, $sql);
						if($discout_result && mysqli_num_rows($discout_result)!=0){
							$row_discount = mysqli_fetch_assoc($discout_result);
							$total_discount += $row_discount['discount_value'];
						}

						$sql = 'select discount_value, recurring_duration from d_discount_structure left join d_fees_structure on d_fees_structure.head_id = discount_id where discount_type="head" '.(count($head_array)>0?(' and discount_id in ('.implode(",", $head_array).') '):'').'and class_id='.$fees['sno'];
						
						//echo $sql.'<br><hr>';
						$discout_result = execute_query($db, $sql);
						if($discout_result && mysqli_num_rows($discout_result)!=0){
							while($row_discount = mysqli_fetch_assoc($discout_result)){
								switch($row_discount['recurring_duration']){
									case 1:{
										$total_discount+=($row_discount['discount_value']*12);
										break;
									}
									case 2:{
										$total_discount+=($row_discount['discount_value']*6);
										break;
									}
									case 3:{
										$total_discount+=($row_discount['discount_value']*4);
										break;
									}
									case 6:{
										$total_discount+=($row_discount['discount_value']*2);
										break;
									}
									case 12:{
										$total_discount+=($row_discount['discount_value']*1);
										break;
									}
									default:{
										$total_discount+=($row_discount['discount_value']);
										break;
									}

								}
							}
						}					
						
						
						echo '<tr style="background:'.$col.'">
						<td>'.$i++.'</td>
						<td>'.$fees['class_desc'].' '.$fees['section'].'</td>
						<td>'.$total_fees.'</td>
						<td>'.$total_discount.'</td>
						<td>'.($total_fees-$total_discount).'</td>
						<td><a href="d_nf_fees_structure.php?vfs='.$fees['sno'].'">View Fees Structure <i class="glyphicon glyphicon-eye-open"></i></a></td>
						</tr>';
					}}

					?>
				</table>
				<input type="hidden" value="<?php echo $_POST['edit_id']; ?>" name="edit_id" >
			</form>
	<?php
			break;
		}
		case 2:{
			//To Display classwise fees structure. A makeshift program is written. Needs further optimization
		
			$sql = 'select * from general_settings where description="session_start_date"';
			$session_start = mysqli_fetch_assoc(execute_query($db, $sql))['value'];
			
			$sql = 'select * from general_settings where description="current_date"';
			$session_end = mysqli_fetch_assoc(execute_query($db, $sql))['value'];
			
			$sql = 'SELECT d_fees_structure.sno as sno, d_fees_structure.class_id, d_fees_structure.head_id, d_fees_structure.recurring_duration, d_fees_structure.amount, d_fees_structure.status, d_class.class_desc as class_desc, d_section.section as section, head_name, student_type FROM `d_fees_structure` left join d_section on d_section.sno = d_fees_structure.class_id left join d_class on d_class.sno = d_section.class_desc left join d_fees_head_master on d_fees_head_master.sno = head_id where class_id='.$_GET['vfs'];
			//echo $sql;
			$result = execute_query($db, $sql);
			$print = array();
			$head = array();
			if($result){
			while($row = mysqli_fetch_assoc($result)){
				$class_name = $row['class_desc'];
				$section = $row['section'];
				$class_id = $row['class_id'];
				if($row['student_type']==''){
					$row['student_type']=0;
				}
				$print[$row['head_id']][$row['student_type']][$row['recurring_duration']] = $row['amount'];
			}}
		
			$sql = 'select * from d_discount_structure where discount_type="class" and discount_id="'.$class_id.'" and (head_id is null or head_id="")';
			$discout_result = execute_query($db, $sql);
			$other_discount = 0;
			if($discout_result && mysqli_num_rows($discout_result)!=0){
				$row_discount = mysqli_fetch_assoc($discout_result);
				$other_discount += $row_discount['discount_value'];
			}

			
			echo '
			<div class="card card-body">
			<table class="table table-striped table-hover rounded">
			<thead>
				<tr class="">
					<th>Class </th>
					<th>'.$class_name.' '.$section.'</th>';
		
				if($other_discount!=0){
					echo '<th>Class Discount</th>
					<th>'.$other_discount.'</th>';
				}
				echo '</tr>
				<tr class="bg-primary text-white">
					<th>Month</th>';
			foreach($print as $k=>$v){
				//print_r($v);
				$head[$k] = $v;
				foreach($v as $key => $val){
					//print_r($val);
					if($key==='new_admission'){
						$student_type= ' <small>(New Admission)</small>';
					}
					elseif($key==='old_admission'){
						$student_type=' <small>(Old Admission)</small>';
					}
					else{
						$student_type = '';
					}
					echo '<th>'.get_head_name($k).' '.$student_type.' <a href="d_nf_fees_structure.php?ed='.$k.'&cl='.$_GET['vfs'].'"><i class="glyphicon glyphicon-edit"></i></a></th>';
				}
			}
			echo '<th></th></thead></tr>';
			/*$session_start_dummy = $session_start;
			while($session_end>$session_start_dummy){
				$session_start_dummy = date("Y-m-d", strtotime($session_start_dummy."+1 month"));
				
			}*/
			$recurring = 12;
			$tot = array();
			while($session_end>$session_start){
				$month = date("m", strtotime($session_start));
				$month_words = strtolower(date("M", strtotime($session_start)));
				echo '<tr>
				<td class="text-center">'.date("Y-M", strtotime($session_start)).'</td>';
				foreach($head as $k=>$v){
					foreach($v as $key=>$val){
						//echo $v.'<br>';
						//print_r($v);
						if($key==='new_admission'){
							$student_type= ' and (student_type="new_admission" or student_type is null) ';
							$k_tot = 'new';
						}
						elseif($key==='old_admission'){
							$student_type= ' and (student_type="old_admission" or student_type is null) ';
							$k_tot = 'old';
						}
						else{
							$student_type = '';
							$k_tot = '';
						}

						$discount_value = 0;
						if(!isset($tot[$k.$k_tot])){
							$tot[$k.$k_tot]=0;
							$tot[$k.$k_tot.'_discount']=0;
						}
						$sql = 'SELECT d_fees_structure.sno as sno, d_fees_structure.class_id, d_fees_structure.head_id, d_fees_structure.recurring_duration, d_fees_structure.amount, d_fees_structure.status, class_desc, head_name, student_type FROM `d_fees_structure` left join d_class on d_class.sno = class_id left join d_fees_head_master on d_fees_head_master.sno = head_id where class_id='.$_GET['vfs'].$student_type.' and head_id='.$k;
						//echo $sql.'<br>';
						$result_head_val = execute_query($db, $sql);
						if(mysqli_num_rows($result_head_val)!=0){
							$row_head_val = mysqli_fetch_assoc($result_head_val);

							if(is_numeric($row_head_val['recurring_duration'])){
								if($recurring%$row_head_val['recurring_duration']==0){
									$sql = '(select discount_value from d_discount_structure where discount_type="class" and discount_id="'.$_GET['vfs'].'" and head_id='.$k.') union all (select discount_value from d_discount_structure where discount_type="head" and discount_id='.$k.')';
									//echo $sql.'<br>';
									$result_discount = execute_query($db, $sql);
									if(mysqli_num_rows($result_discount)!=0){
										while($row_discount = mysqli_fetch_assoc($result_discount)){
											$discount_value += $row_discount['discount_value'];
											$tot[$k.$k_tot.'_discount'] += $discount_value;
										}
									}
									echo '<td>'.$row_head_val['amount'];
									if($discount_value!=0){
										echo ' <span class="text-danger small">Discount: '.$discount_value.'</span>';
									}
									echo '</td>';
									$tot[$k.$k_tot] += $row_head_val['amount'];
								}
								else{
									echo '<td>&nbsp;</td>';
								}
							}
							else{
								$sql = 'SELECT d_fees_structure.sno as sno, d_fees_structure.class_id, d_fees_structure.head_id, d_fees_structure.recurring_duration, d_fees_structure.amount, d_fees_structure.status, class_desc, head_name, student_type FROM `d_fees_structure` left join d_class on d_class.sno = class_id left join d_fees_head_master on d_fees_head_master.sno = head_id where class_id='.$_GET['vfs'].$student_type.' and head_id='.$k.' and recurring_duration="'.$month_words.'"';
								$result_month = execute_query($db, $sql);
								if(mysqli_num_rows($result_month)!=0){
									$sql = '(select discount_value from d_discount_structure where discount_type="class" and head_id='.$k.') union all (select discount_value from d_discount_structure where discount_type="head" and discount_id='.$k.')';
									$result_discount = execute_query($db, $sql);
									if(mysqli_num_rows($result_discount)!=0){
										while($row_discount = mysqli_fetch_assoc($result_discount)){
											$discount_value += $row_discount['discount_value'];
											$tot[$k.'_discount'] += $discount_value;
										}
									}
									echo '<td>'.$row_head_val['amount'];
									if($discount_value!=0){
										echo ' <span class="text-danger small">Discount: '.$discount_value.'</span>';
									}
									echo '</td>';
									$tot[$k] += $row_head_val['amount'];
								}
								else{
									echo '<td>&nbsp;</td>';
								}
							}
						}
					}
				}
				$recurring--;
				echo '<td></td></tr>';
				$session_start = date("Y-m-d", strtotime($session_start."+1 month"));
			}
			echo '<tr>
			<th class="text-center">Total</th>';
			foreach($head as $k=>$v){
				foreach($v as $key=>$val){
					if($key==='new_admission'){
						$k_tot = 'new';
					}
					elseif($key==='old_admission'){
						$k_tot = 'old';
					}
					else{
						$k_tot = '';
					}
					echo '<th>'.(isset($tot[$k.$k_tot])?$tot[$k.$k_tot]:'');
					if(isset($tot[$k.$k_tot.'_discount']) && $tot[$k.$k_tot.'_discount']!=0){
						echo ' <span class="text-danger small">Discount: '.$tot[$k.$k_tot.'_discount'].'</span>';
						$other_discount += $tot[$k.$k_tot.'_discount'];
					}
					echo '</th>';	
				}
			}
			echo '<th></th></tr>';
		if($other_discount!=0){
			echo '<tr>
			<th>Total Discount </th>
			<th>'.$other_discount.'</th></tr>';
		}
		?>
		</table></div>
		</div>
		</div></div>
		
		<?php
			break;
		}
	}
	?>
<script>
$( document ).ready(function() {
    change_duration();
});

</script>
<?php

page_footer_start();
page_footer_end();
?>
	