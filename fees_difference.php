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
page_header_end();
page_sidebar();
?>
<script type="text/javascript" language="javascript">
function fees_report() {
	window.open("fees_differ_print.php");
}
</script>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<form action="fees_difference.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" >
					<h2>Fees <span class="orange">Bifurcation (Subject Change)</span></h2>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label>Enter Bank User Id<span class="name">*</span></label>
								<input type="text" name="user_id" class="form-control" id="user_id" >
							</div>
							<div class="col-md-4">							
								<label>Select Date<span class="name">*</span></label>
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('dfc_date', 'dfc_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['dfc_date'])){echo $_POST['dfc_date'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
								
							</div>
							<div class="col-md-4">							
								<label>Select class <span class="alert">*</span></label>
								<select name="s_class" class="form-control" id="s_class" >
									<option value="">ALL</option>
										<?php
										$sql = 'select * from class_detail order by sort_no, class_description';
										$res = execute_query(connect(), $sql);
										while($row = mysqli_fetch_array($res)) {
											echo '<option value="'.$row['sno'].'" ';
											if(isset($_POST['s_class'])){
												if($_POST['s_class']==$row['sno']){
													echo " selected";
												}
											}
											echo '>'.$row['class_description'].'</option> ';
										}
										?>
									 </select>
							</div>
						</div>
						
						
					</div> 
						<input type="submit" class="submit btn btn-primary" name="save" value="Submit" style="margin-top:0px; margin-left:0px;"/>
						<input type="button" name="student_ledger" class="btn btn-danger" onClick="return fees_report()" style="float: right;" value="Print">					
				 </form>
			</div>
		</div> 

<?php
$sql= "select * from head_type";
$result_head = execute_query(connect(), $sql);
$count = mysqli_num_rows($result_head);              
?>
		<div class="card card-body">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="table-primary ">
					<td rowspan="3">S.No.</td>
					<td rowspan="3">STUDENT NAME</td>
					<td rowspan="3">CLASS</td>
					<td rowspan="3">ROLL NO</td>
					<td rowspan="3">CATEGORY</td>
					<td rowspan="3">GENDER</td>
					<td rowspan="3">DATE/TIME</td>
					<td colspan="<?php echo $count-2; ?>">FEES HEADS</td>
					<td colspan="4">&nbsp;</td>
					<td rowspan="3">TOTAL2(12 to 37)
					<td rowspan="3">TOTAL(Total1+Total2)</td>
					<td rowspan="3">TOTAL DEPOSITED</td>
				</tr>
				<tr class="table-primary ">
					<td colspan="4">MAINTENANCE</td>
					<td colspan="14">&nbsp;</td>
					<td colspan="12">UNIVERSITY FEES ACCOUNT</td>
				<!--    <td colspan="5"></td>
					<td colspan="12">PRACTICAL FEES ACCOUNT</td> -->
				</tr>
				<tr style="background:#CCC; color:#FFF; text-align:center; font-size:13px;">
			<?php
			while($row_head = mysqli_fetch_array($result_head)){
				if($row_head['sno']==4){
					echo '<td >Total1</td>';
				}
				if($row_head['sno']==23){
					echo '<td >Lab Fee Half Yearly</td>';
				}
				echo '<td>'.strtoupper($row_head['fee_type']).'</td>';
				$fees_division[$row_head['sno']]=0;
			}
			?>
			<!--	<td>TOTAL FEES</td>
				<td>ZOOLOGY PRACTICAL FEES</td>
				<td>BOTANY PRACTICAL FEES</td>
				<td>CHEMISTRY PRACTICAL FEES</td>
				<td>PHYSICS PRACTICAL FEES</td>
				<td>MILITARY SCIENCE PRACTICAL FEES</td>
				<td>GEOGRAPHY PRACTICAL FEES</td>
				<td>HOME SCIENCE PRACTICAL FEES</td>
				<td>PHYSICAL EDUCATION PRACTICAL FEES</td>
				<td>TOTAL PRACTICAL FEES (36 to 50)</td> -->
				</tr>
				 <?php
				$tot[0]=0;
				for($td=1; $td<=40; $td++){
					$tot[]=0;
					if($td==11){
						echo '<td>11<br>(8+9+10)</td>';
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
			$sql = "select *, fee_invoice2.sno as fees_serial, student_info2.sno as student_serial from fee_invoice2 join student_info2 on fee_invoice2.student_id = student_info2.sno where amount_paid is not null and fee_invoice2.type='fees' and student_info2.type='subject_change'";
			if(isset($_POST['user_id'])){
				if($_POST['user_id']!=''){
					$sql .= ' and fee_invoice2.user_id="'.$_POST['user_id'].'"';
				}
			}
			if(isset($_POST['s_class'])){
				if($_POST['s_class']!=''){
				$sql .= ' and student_info2.class="'.$_POST['s_class'].'"';
				}
			}
			if(isset($_POST['dfc_date'])){
				$start = strtotime(date('Y-m-01' , strtotime($_POST['dfc_date'])));
				$end = strtotime(date('Y-m-t' , strtotime($_POST['dfc_date'])));
				//$end = $start+86400;	
				$sql .= " and fee_invoice2.timestamp>=".$start." and fee_invoice2.timestamp<".$end;
			}
			else{
				$start = strtotime(date("Y-m-d"));
				$end = $start+86400;	
				$sql .= " and timestamp>=".$start." and timestamp<".$end;
			}
			$_SESSION['sql_diff']="$sql";
			$result = execute_query(connect(), $sql);
			//echo $sql.'<br>';
			$i=1;
			while($row = mysqli_fetch_array($result)){
				$sql='select *,fee_invoice.sno as fees_serial, student_info.sno as student_serial from student_info join fee_invoice where student_info.sno='.$row['student_id'].' and fee_invoice.student_id='.$row['student_id'];
				//echo $sql.'<br>';
				$prev_details=mysqli_fetch_array(execute_query(connect(), $sql));
				$tot_fees=0;
				$fees_amount = calc_fees($row['class'],$row['sub1'],$row['sub2'],$row['sub3'],$row['gender'],$row['category']);
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
					if($row['annual_income']>1){
						$row['category']='GEN';
					}
					if($row['category']=="SC" or $row['category']=="ST"){
						
						
						for($td=8;$td<37;$td++){
							if($td==17){
								$sql='select * from fees_detail4 where class_id='.$row['class'].' and head_id=9';
								$univ_enroll_fees=mysqli_fetch_array(execute_query(connect(), $sql));
								if($row['other_univ']=='other'){
									echo '<td>'.$univ_enroll_fees['fee_amount'].'</td>';
									$tot[9]+=$univ_enroll_fees['fee_amount'];
									$total2+=$univ_enroll_fees['fee_amount'];
								}
								else{
									echo '<td>0</td>';
								}
							}
							else{
								echo '<td>0</td>';
							}
						}
						if($row['class']>59 && $row['class']<76 ){
							$sql='select * from fees_detail4 where class_id='.$row['class'].' and head_id=29';
							//echo $sql;
							$degree_fees=mysqli_fetch_array(execute_query(connect(), $sql));
							$sql='select * from fees_detail4 where class_id='.$row['class'].' and head_id=9';
							$univ_enroll_fees=mysqli_fetch_array(execute_query(connect(), $sql));
							if($row['other_univ']=='other'){
								$tot_fees=$univ_enroll_fees['fee_amount']+$degree_fees['fee_amount'];
							}
							else{
								$tot_fees=$degree_fees['fee_amount'];
							}
						}
						else{
							$sql='select * from fees_detail4 where class_id='.$row['class'].' and head_id=29';
							$degree_fees=mysqli_fetch_array(execute_query(connect(), $sql));
							$sql='select * from fees_detail4 where class_id='.$prev_details['class'].' and head_id=29';
							$prev_fee=mysqli_fetch_array(execute_query(connect(), $sql));
							$degree_fees['fee_amount']=$degree_fees['fee_amount']-$prev_fee['fee_amount'];
								if($degree_fees['fee_amount']<0){
										$degree_fees['fee_amount']=0;
								}
							$tot_fees=$degree_fees['fee_amount'];
						}
						echo '<td>'.$degree_fees['fee_amount'].'</td>';
						echo '<td>'.$degree_fees['fee_amount'].'</td>';
						$tot[29]+=$degree_fees['fee_amount'];
						$tot[30]+=$degree_fees['fee_amount'];
					}
					else{
						$total2=0;
						while($row_head = mysqli_fetch_array($result_head)){
							$sql = "select * from fees_detail where class_id=".$row['class']." and head_id=".$row_head['sno'];
							$fee = mysqli_fetch_array(execute_query(connect(), $sql));
							
							$sql='select * from fees_detail where class_id='.$prev_details['class'].' and head_id='.$row_head['sno'];
							$prev_fee=mysqli_fetch_array(execute_query(connect(), $sql));
							if($row_head['sno']==1){
								if($row['gender']=='F'){
									echo '<td>0</td>';
								}
								else {
									if($prev_details['annual_income']==1 && ($prev_details['category']=='SC' || $prev_details['category']=='ST') || $prev_details['gender']=='F'){
										$prev_fee['fee_amount']=0;
									}
									$fee['fee_amount']=$fee['fee_amount']-$prev_fee['fee_amount'];
									if($fee['fee_amount']<0){
										$fee['fee_amount']=0;
									}
									echo '<td>'.$fee['fee_amount'].'</td>';
									$tot_fees += $fee['fee_amount'];
									$tot[$row_head['sno']]+=$fee['fee_amount'];
								}
							}
							elseif($row_head['sno']>=2 and $row_head['sno']<=8){
								if($row_head['sno']==4){
									echo '<td>'.$tot_fees.'</td>';
									$tot[50]+=$tot_fees;
								}
								if($prev_details['annual_income']==1 && ($prev_details['category']=='SC' || $prev_details['category']=='ST')){
									$prev_fee['fee_amount']=0;
								}
								$fee['fee_amount']=$fee['fee_amount']-$prev_fee['fee_amount'];
								if($fee['fee_amount']<0){
									$fee['fee_amount']=0;
								}
								echo '<td>'.$fee['fee_amount'].'</td>';
								$tot_fees += $fee['fee_amount'];			
								$tot[$row_head['sno']]+=$fee['fee_amount'];
								if($row_head['sno']>=4){
									$total2+=$fee['fee_amount'];
								}
							}
							elseif($row_head['sno']==9){
								$sql="select * from class_detail where sno=".$row['class'];
								$class_id = mysqli_fetch_array(execute_query(connect(), $sql));
								if($class_id['category']=='PG' || $class_id['type']=='PG'){
									if($row['other_univ']=='awadh'){
										echo '<td>0</td>';
									}
									else{
										if($prev_details['annual_income']==1 && ($prev_details['category']=='SC' || $prev_details['category']=='ST')){
											//$prev_fee['fee_amount']=0;
										}
										if($prev_details['other_univ']=='awadh'){
											$prev_fee['fee_amount']=0;
										}
										$fee['fee_amount']=$fee['fee_amount']-$prev_fee['fee_amount'];
										if($fee['fee_amount']<0){
											$fee['fee_amount']=0;
										}
										echo '<td>'.$fee['fee_amount'].'</td>';
										$tot_fees += $fee['fee_amount'];			
										$tot[$row_head['sno']]+=$fee['fee_amount'];
										$total2+=$fee['fee_amount'];
									}
								}
								else{
									if($prev_details['annual_income']==1 && ($prev_details['category']=='SC' || $prev_details['category']=='ST')){
										$prev_fee['fee_amount']=0;
									}
									$fee['fee_amount']=$fee['fee_amount']-$prev_fee['fee_amount'];
									if($fee['fee_amount']<0){
										$fee['fee_amount']=0;
									}
									echo '<td>'.$fee['fee_amount'].'</td>';
									$tot_fees += $fee['fee_amount'];			
									$tot[$row_head['sno']]+=$fee['fee_amount'];
									$total2+=$fee['fee_amount'];
								}
							}
							elseif($row_head['sno']>=10 and $row_head['sno']<=11){
								if($prev_details['annual_income']==1 && ($prev_details['category']=='SC' || $prev_details['category']=='ST')){
									if($row['class']<=59 or $row['class']>=76){
										$prev_fee['fee_amount']=0;
									}
								}
								$fee['fee_amount']=$fee['fee_amount']-$prev_fee['fee_amount'];
								if($fee['fee_amount']<0){
										$fee['fee_amount']=0;
								}
								echo '<td>'.$fee['fee_amount'].'</td>';
								$tot_fees += $fee['fee_amount'];			
								$tot[$row_head['sno']]+=$fee['fee_amount'];
								$total2+=$fee['fee_amount'];
							}
							elseif($row_head['sno']>=12 and $row_head['sno']<=13){
								if($prev_details['annual_income']==1 && ($prev_details['category']=='SC' || $prev_details['category']=='ST')){
									$prev_fee['fee_amount']=0;
								}
								$fee['fee_amount']=$fee['fee_amount']-$prev_fee['fee_amount'];
								if($fee['fee_amount']<0){
										$fee['fee_amount']=0;
								}
								echo '<td>'.$fee['fee_amount'].'</td>';
								$tot_fees += $fee['fee_amount'];			
								$tot[$row_head['sno']]+=$fee['fee_amount'];
								$total2+=$fee['fee_amount'];
							}
							elseif($row_head['sno']==14){
								$sub_count = calc_sub_fees_new($row['class'], $row['sub1'], $row['sub2'], $row['sub3']);
								$prac_caution = $fee['fee_amount']*$sub_count['c'];
								$sub_count_prev = calc_sub_fees_new($prev_details['class'], $prev_details['sub1'], $prev_details['sub2'], $prev_details['sub3']);
								$prac_caution_prev = $prev_fee['fee_amount']*$sub_count_prev['c'];
								if($prev_details['annual_income']==1 && ($prev_details['category']=='SC' || $prev_details['category']=='ST')){
									$prac_caution_prev=0;
								}
								$prac_caution=$prac_caution-$prac_caution_prev;
								if($prac_caution<0){
										$prac_caution=0;
								}
								echo '<td>'.$prac_caution.'</td>';
								$tot_fees += $prac_caution;
								$tot[$row_head['sno']]+=$prac_caution;
								$total2+=$prac_caution;
							}
							elseif($row_head['sno']>=15 and $row_head['sno']<=16){
								if($prev_details['annual_income']==1 && ($prev_details['category']=='SC' || $prev_details['category']=='ST')){
									$prev_fee['fee_amount']=0;
								}
								$fee['fee_amount']=$fee['fee_amount']-$prev_fee['fee_amount'];
								if($fee['fee_amount']<0){
									$fee['fee_amount']=0;
								}
								echo '<td>'.$fee['fee_amount'].'</td>';
								$tot_fees += $fee['fee_amount'];			
								$tot[$row_head['sno']]+=$fee['fee_amount'];
								$total2+=$fee['fee_amount'];
							}
							elseif($row_head['sno']==17){
								if($class['category']=='PG'){
									if($prev_details['annual_income']==1 && ($prev_details['category']=='SC' || $prev_details['category']=='ST')){
										$prev_fee['fee_amount']=0;
									}
									$fee['fee_amount']=$fee['fee_amount']-$prev_fee['fee_amount'];
									if($fee['fee_amount']<0){
										$fee['fee_amount']=0;
									}
									if($fee['fee_amount']!=0 && $row['otder_univ']!='awadh'){
										$fee['fee_amount']=$fee['fee_amount']-$prev_fee['fee_amount'];
										if($fee['fee_amount']<0){
											$fee['fee_amount']=0;
										}
										echo '<td>'.$fee['fee_amount'].'</td>';
										$tot_fees += $fee['fee_amount'];
										$tot[$row_head['sno']]+=$fee['fee_amount'];
										$total2+=$fee['fee_amount'];
									}
									else{
										echo '<td>0</td>';
									}
								}
								else{
									if($prev_details['annual_income']==1 && ($prev_details['category']=='SC' || $prev_details['category']=='ST')){
									$prev_fee['fee_amount']=0;
								}
									$fee['fee_amount']=$fee['fee_amount']-$prev_fee['fee_amount'];
									if($fee['fee_amount']<0){
										$fee['fee_amount']=0;
									}
									echo '<td>'.$fee['fee_amount'].'</td>';
									$tot_fees += $fee['fee_amount'];
									$tot[$row_head['sno']]+=$fee['fee_amount'];	
									$total2+=$fee['fee_amount'];
								}
							}
							elseif($row_head['sno']>=18 and $row_head['sno']<=26){
								if($prev_details['annual_income']==1 && $prev_details['category']=='SC'){
									if($row_head['sno']!=23){
										$prev_fee['fee_amount']=0;
									}
								}
								$fee['fee_amount']=$fee['fee_amount']-$prev_fee['fee_amount'];
								if($fee['fee_amount']<0){
										$fee['fee_amount']=0;
								}
								echo '<td>'.$fee['fee_amount'].'</td>';
								$tot_fees += $fee['fee_amount'];			
								$tot[$row_head['sno']]+=$fee['fee_amount'];
								$total2+=$fee['fee_amount'];
								if($row_head['sno']==21){
									$sql = 'select * from subject_fees where class_id='.$row['class'].' and fees!="" limit 1';
									$lab_fees=mysqli_fetch_array(execute_query(connect(), $sql));
									$sub_count = calc_sub_fees_new($row['class'], $row['sub1'], $row['sub2'], $row['sub3']);
									$lab_fees['fees'] = $lab_fees['fees']*$sub_count['c'];
									$sql = 'select * from subject_fees where class_id='.$prev_details['class'].' and fees!="" limit 1';
									$lab_fees_prev=mysqli_fetch_array(execute_query(connect(), $sql));
									$sub_count_prev = calc_sub_fees_new($prev_details['class'], $prev_details['sub1'], $prev_details['sub2'],                        $prev_details['sub3']);
									$lab_fees_prev['fees'] = $lab_fees_prev['fees']*$sub_count_prev['c'];
									if($prev_details['annual_income']==1 && ($prev_details['category']=='SC' || $prev_details['category']=='ST')){
										$lab_fees_prev['fees']=0;
									}
									$lab_fees['fees']=$lab_fees['fees']-$lab_fees_prev['fees'];
									if($lab_fees['fees']<0){
										$lab_fees['fees']=0;
									}
									echo '<td>'.$lab_fees['fees'].'</td>';
									$tot_fees += $lab_fees['fees'];
									$tot[22]+=$lab_fees['fees'];
									$total2+=$lab_fees['fees'];
								}
							}
							elseif($row_head['sno']==27){
								$self=0;
								if($prev_details['annual_income']==1 && ($prev_details['category']=='SC' || $prev_details['category']=='ST')){
									//$prev_fee['fee_amount']=0;
								}
								$self = $fee['fee_amount']-$prev_fee['fee_amount'];
								if($self<0){
									$self=0;
								}
								echo '<td>'.$self.'</td>';
								$tot_fees += $self;
								$tot[$row_head['sno']]+=$self;
								$total2+=$self;
							}
							elseif($row_head['sno']>=28){
								if($prev_details['annual_income']==1 && ($prev_details['category']=='SC' || $prev_details['category']=='ST')){
									//$prev_fee['fee_amount']=0;
								}
								$fee['fee_amount']=$fee['fee_amount']-$prev_fee['fee_amount'];
								if($fee['fee_amount']<0){
									$fee['fee_amount']=0;
								}
								echo '<td>'.$fee['fee_amount'].'</td>';
								$tot_fees += $fee['fee_amount'];			
								$tot[$row_head['sno']]+=$fee['fee_amount'];
								$total2+=$fee['fee_amount'];
								if($row_head['sno']==29){
									$tot[52]+=$total2;
									echo '<td>'.$total2.'</td>';
								}
							}
						}
					}
					if($row['category']=='GEN' || $row['category']=='OBC'){
						if($prev_details['annual_income']==1 && ($prev_details['category']=='SC' || $prev_details['category']=='ST')){
							$sql='select * from fee_invoice where student_id='.$prev_details['student_serial'].' and amount_paid is not null and type="fees"';
								$amount_paid = mysqli_fetch_array(execute_query(connect(), $sql));
								//$tot_fees=$tot_fees-$amount_paid['amount_paid'];
						}
					}
					echo '<td>'.$tot_fees.'</td>';
					$sql = 'select * from fee_invoice2 where class_id="'.$row['class'].'" and student_id="'.$row['student_serial'].'" and amount_paid is not NULL and type='."'fees'";
					$amount_paid = mysqli_fetch_array(execute_query(connect(), $sql));
					$amount_paid = $amount_paid['amount_paid'];
				echo '
				<td>'.$amount_paid.'</td>';
					$tot[30]+=$tot_fees;
					$tot[31]+=$amount_paid;
				if($amount_paid!=$tot_fees){
					echo '<td>ERROR</td>';
				}
				echo '</tr>';
				}
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
				echo '<td>'.$tot[52].'</td>';
				echo '<td>'.$tot[30].'</td>';
				echo '<td>'.$tot[31].'</td>';

			?>
				</table></div>
   </form></div></div>
<?php 
page_footer_start(); 
page_footer_end(); 
function editable($field){
	if($field!=''){
		echo 'readonly= "readonly"';
	}
}
?>