<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);	
page_header_start();
$msg='';
$response=1;
if(isset($_GET['det'])){
	$response=2;
}
page_header_end();
page_sidebar();
?>
<script language="javascript">
function get_subject(class_name){
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var v = xmlhttp.responseText;
			document.getElementById('sub1').innerHTML=v;
			document.getElementById('sub2').innerHTML=v;
			document.getElementById('sub3').innerHTML=v;
		}
	}
	xmlhttp.open("GET","get_subfees.php?q="+class_name,true);
	xmlhttp.send();	
}
</script>
<body id="public">
	<div id="card card-body">	
	<form action="fee_structure.php" class="wufoo leftLabel page1" name="admission" enctype="multipart/form-data" method="post">
	<h3>Fee <span class="orange">Structure</span>
    <div style="float:right"><a href="fee_structure.php?det=1">Detailed <span class="orange">Structure</span></a></div>
    </h3>
<?php
switch($response){
	case 1:{
?>
		<div class="card card-body">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="table-primary ">
					<th rowspan="2">S.No</th>
					<th rowspan="2">Class</th>
					<th rowspan="2">Class Type</th>
					<th colspan="2">Practicals(None)</th>
					<th colspan="2">Practicals(One)</th>
					<th colspan="2">Practicals(Two)</th>
					<th colspan="2">Practicals(Three)</th>    
				</tr>
				<tr class="table-primary">
					<th>Male</th>
					<th>Female</th>
					<th>Male</th>
					<th>Female</th>
					<th>Male</th>
					<th>Female</th>
					<th>Male</th>
					<th>Female</th>
				</tr>
			<?php
			$i='';
			$sql = 'select * from class_detail';
			$result_class = execute_query(connect(), $sql);
			while($row_class = mysqli_fetch_array($result_class)) {
				/*$sql_head='select * from student_info where class_id="'.$row_class['sno'].'" and gender="M" and category="GEN" limit 1';
				$stu_m=mysqli_fetch_array(execute_query(connect(), $sql_head));
				$sql_head='select * from student_info where class_id="'.$row_class['sno'].'" and gender="F" and category="GEN" limit 1';
				$stu_m=mysqli_fetch_array(execute_query(connect(), $sql_head));*/
				$sql_subject='select * from subject_fees where class_id="'.$row_class['sno'].'" and fees=0 limit 1';
				//echo $sql_subject;
				$subject_no_prac=mysqli_fetch_array(execute_query(connect(), $sql_subject));
				
				$sql_subject='select * from subject_fees where class_id="'.$row_class['sno'].'" and fees!=0 limit 1';
				$subject_prac=mysqli_fetch_array(execute_query(connect(), $sql_subject));
				
				$sql_subject='select * from subject_fees where class_id="'.$row_class['sno'].'" and fees!=0 and sno!="'.$subject_prac['sno'].'" limit 1';
				//echo $sql_subject;
				$subject_prac1=mysqli_fetch_array(execute_query(connect(), $sql_subject));
				
				$sql_subject='select * from subject_fees where class_id="'.$row_class['sno'].'" and fees!=0 and sno!="'.$subject_prac['sno'].'" and sno!="'.$subject_prac1['sno'].'" limit 1';
				//echo $sql_subject.'<br>';
				$subject_prac2=mysqli_fetch_array(execute_query(connect(), $sql_subject));
				
				$sql_subject='select * from subject_fees where class_id="'.$row_class['sno'].'" and type="self" and fees=0 limit 1';
				$subject_self=mysqli_fetch_array(execute_query(connect(), $sql_subject));
				
				$sql_subject='select * from subject_fees where class_id="'.$row_class['sno'].'" and type="self" and fees!=0 limit 1';
				$subject_self_prac=mysqli_fetch_array(execute_query(connect(), $sql_subject));
				echo '
				<tr><td rowspan="2">'.++$i.'</td>
				<td rowspan="2">'.$row_class['class_description'].'</td>
				<td rowspan="2">'.$row_class['type'].'</td>
				<td>'.calc_fees($row_class['sno'],$subject_no_prac['subject_id'],$subject_no_prac['subject_id'],$subject_no_prac['subject_id'],'M','GEN').'</td>
				<td>'.calc_fees($row_class['sno'],$subject_no_prac['subject_id'],$subject_no_prac['subject_id'],$subject_no_prac['subject_id'],'F','GEN').'</td>
				<td>'.calc_fees($row_class['sno'],$subject_prac['subject_id'],$subject_no_prac['subject_id'],$subject_no_prac['subject_id'],'M','GEN').'</td>
				<td>'.calc_fees($row_class['sno'],$subject_prac['subject_id'],$subject_no_prac['subject_id'],$subject_no_prac['subject_id'],'F','GEN').'</td>
				<td>'.calc_fees($row_class['sno'],$subject_prac['subject_id'],$subject_prac1['subject_id'],$subject_no_prac['subject_id'],'M','GEN').'</td>
				<td>'.calc_fees($row_class['sno'],$subject_prac['subject_id'],$subject_prac1['subject_id'],$subject_no_prac['subject_id'],'F','GEN').'</td>
				<td>'.calc_fees($row_class['sno'],$subject_prac['subject_id'],$subject_prac1['subject_id'],$subject_prac2['subject_id'],'M','GEN').'</td>
				<td>'.calc_fees($row_class['sno'],$subject_prac['subject_id'],$subject_prac1['subject_id'],$subject_prac2['subject_id'],'F','GEN').'</td>
				</tr>
				<tr>
				<td colspan="2">'.calc_fees($row_class['sno'],$subject_self['subject_id'],$subject_no_prac['subject_id'],$subject_no_prac['subject_id'],'F','GEN').'</td>
				<td colspan="2">'.calc_fees($row_class['sno'],$subject_self_prac['subject_id'],$subject_self['subject_id'],$subject_self['subject_id'],'F','GEN').'</td>
				<td colspan="2">'.calc_fees($row_class['sno'],$subject_self_prac['subject_id'],$subject_self_prac['subject_id'],$subject_self['subject_id'],'F','GEN').'</td>
				<td colspan="2">'.calc_fees($row_class['sno'],$subject_self_prac['subject_id'],$subject_self_prac['subject_id'],$subject_self_prac['subject_id'],'F','GEN').'</td>
				</tr>';
			}  
			?>
			</table>
		</div>
<?php
		break;
	}
	case 2:{
		
		$sql = 'select * from head_type order by sno';
		$result = execute_query(connect(), $sql);
		echo '<table width="100%" class="table table-striped table-hover rounded">
		<tr class="table-primary">
			<th>S.No.</th>
			<th>Class</th>
		';
		$a=1;
		while($row = mysqli_fetch_array($result)){
			if($row['sno']==23){
				echo '<th style="font-size:9px;">Lab Fee Half Yearly</th>';
			}
			echo '<th style="font-size:9px;">'.$row['fee_type'].' ('.$row['sno'].')</th>';
			}
		echo '
			<th>Total</th>
		</tr>';
		
		$sql = 'select * from class_detail where type!="SELF" order by sort_no, year';
		$result = execute_query(connect(), $sql);
		$i=1;
		$col='';
		while($row = mysqli_fetch_array($result)){
			$done=0;
			$sql = 'select * from subject_fees where class_id='.$row['sno'].' and fees="" limit 1';
			//echo $sql.'<br>';
			$res_sub = execute_query(connect(), $sql);
			$count = mysqli_num_rows($res_sub);
			//echo $count.'<br>';
			if(mysqli_num_rows($res_sub)!=0){
				$count=0;
				$tot=0;
				$done=1;
				echo '<tr>
				<td>'.$i++.'</td>
				<td>'.$row['class_description'].' ('.$count.')</td>';
				$sql = 'select * from fees_detail where class_id='.$row['sno'].' and head_id not in ("computer", "self", "tour") order by abs(head_id)';
				//echo $sql.'<br>';
				$res_fees = execute_query(connect(), $sql);
				while($row_fees = mysqli_fetch_array($res_fees)){
					if($row_fees['head_id']==14){
						$row_fees['fee_amount'] = $row_fees['fee_amount']*$count;
					}
					if($row_fees['head_id']==23){
						echo '<td>'.(120*$count).'</td>';
						$tot+=120*$count;
					}
					echo '<td>'.$row_fees['fee_amount'].'</td>';
					$tot+=$row_fees['fee_amount'];
				}
				echo '<td>'.$tot.'</td>
				<td>'.$row['class_description'].' ('.$count.')</td></tr>';
			}
			$sql = 'select * from subject_fees where class_id='.$row['sno'].' and fees!="" limit 1';
			//echo $sql.'<br>';
			$res_sub = execute_query(connect(), $sql);
			$count = mysqli_num_rows($res_sub);
			if(mysqli_num_rows($res_sub)!=0){
				$tot=0;
				$done=1;
				echo '<tr>
				<td>'.$i++.'</td>
				<td>'.$row['class_description'].' ('.$count.')</td>';
				$sql = 'select * from fees_detail where class_id='.$row['sno'].' and head_id not in ("computer", "self","tour") order by abs(head_id)';
				$res_fees = execute_query(connect(), $sql);
				while($row_fees = mysqli_fetch_array($res_fees)){
					if($row_fees['head_id']==14){
						$row_fees['fee_amount'] = $row_fees['fee_amount']*$count;
					}
					if($row_fees['head_id']==23){
						$prac_amount = mysqli_fetch_array($res_sub);
						$prac_amount = $prac_amount['fees'];
						echo '<td>'.($prac_amount*$count).'</td>';
						$tot+=$prac_amount*$count;
					}
					echo '<td>'.$row_fees['fee_amount'].'</td>';
					$tot+=$row_fees['fee_amount'];
				}
				echo '<td>'.$tot.'</td>
				<td>'.$row['class_description'].' ('.$count.')</td></tr>';
			}

			$sql = 'select * from subject_fees where class_id='.$row['sno'].' and fees!="" limit 2';
			$res_sub = execute_query(connect(), $sql);
			$count = mysqli_num_rows($res_sub);
			if(mysqli_num_rows($res_sub)>1){
				$tot=0;
				$done=1;
				echo '<tr>
				<td>'.$i++.'</td>
				<td>'.$row['class_description'].' ('.$count.')</td>';
				$sql = 'select * from fees_detail where class_id='.$row['sno'].' and head_id not in ("computer", "self" ,"tour") order by abs(head_id)';
				$res_fees = execute_query(connect(), $sql);
				while($row_fees = mysqli_fetch_array($res_fees)){
					if($row_fees['head_id']==14){
						$row_fees['fee_amount'] = $row_fees['fee_amount']*$count;
					}
					if($row_fees['head_id']==23){
						$prac_amount = mysqli_fetch_array($res_sub);
						$prac_amount = $prac_amount['fees'];
						echo '<td>'.($prac_amount*$count).'</td>';
						$tot+=$prac_amount*$count;
					}
					echo '<td>'.$row_fees['fee_amount'].'</td>';
					$tot+=$row_fees['fee_amount'];
				}
				echo '<td>'.$tot.'</td>
				<td>'.$row['class_description'].' ('.$count.')</td></tr>';
			}

			$sql = 'select * from subject_fees where class_id='.$row['sno'].' and fees!="" limit 3';
			$res_sub = execute_query(connect(), $sql);
			$count = mysqli_num_rows($res_sub);
			if(mysqli_num_rows($res_sub)>2){
				$tot=0;
				$done=1;
				echo '<tr>
				<td>'.$i++.'</td>
				<td>'.$row['class_description'].' ('.$count.')</td>';
				$sql = 'select * from fees_detail where class_id='.$row['sno'].' and head_id not in ("computer", "self" ,"tour") order by abs(head_id)';
				$res_fees = execute_query(connect(), $sql);
				while($row_fees = mysqli_fetch_array($res_fees)){
					if($row_fees['head_id']==14){
						$row_fees['fee_amount'] = $row_fees['fee_amount']*$count;
					}
					if($row_fees['head_id']==23){
						$prac_amount = mysqli_fetch_array($res_sub);
						$prac_amount = $prac_amount['fees'];
						echo '<td>'.($prac_amount*$count).'</td>';
						$tot+=$prac_amount*$count;
					}
					echo '<td>'.$row_fees['fee_amount'].'</td>';
					$tot+=$row_fees['fee_amount'];
				}
				echo '<td>'.$tot.'</td>
				<td>'.$row['class_description'].' ('.$count.')</td></tr>';
			}
			if($done==0){
				echo '<tr>
				<td>'.$i++.'</td>
				<td>'.$row['class_description'].' ('.$count.')</td>
				<td colspan="25">DETAILS MISSING</td>
				</tr>';
			}
		}
	
		
	
		$sql = 'select * from head_type_self order by sno';
		$result = execute_query(connect(), $sql);
		echo '<table width="100%" class="table table-striped table-hover rounded">
		<tr class="table-primary">';
	
		echo '<h2>Self Finance Courses</h2>';
		echo '</tr>
		<tr class="table-primary">
			<th>S.No.</th>
			<th>Class</th>
		';
		$a=1;
		while($row = mysqli_fetch_array($result)){
			echo '<th style="font-size:9px;">'.$row['fee_type'].' ('.$row['sno'].')</th>';
		}
		echo '
			<th>Total</th>
		</tr>';
		
		$sql = 'select * from class_detail where type="SELF" order by sort_no, year';
		$result = execute_query(connect(), $sql);
		$i=1;
		$col='';
		while($row = mysqli_fetch_array($result)){
			$done=0;
			$sql = 'select * from subject_fees where class_id='.$row['sno'].' and fees="" limit 1';
			//echo $sql.'<br>';
			$res_sub = execute_query(connect(), $sql);
			$count = mysqli_num_rows($res_sub);
			//echo $count.'<br>';
			if(mysqli_num_rows($res_sub)!=0){
				$count=0;
				$tot=0;
				$done=1;
				echo '<tr>
				<td>'.$i++.'</td>
				<td>'.$row['class_description'].' ('.$count.')</td>';
				$sql = 'select * from fees_detail where class_id='.$row['sno'].' and head_id not in ("computer", "self", "tour") order by abs(head_id)';
				//echo $sql.'<br>';
				$res_fees = execute_query(connect(), $sql);
				while($row_fees = mysqli_fetch_array($res_fees)){
					if($row_fees['head_id']==14){
						$row_fees['fee_amount'] = $row_fees['fee_amount']*$count;
					}
					if($row_fees['head_id']==23){
						echo '<td>'.(120*$count).'</td>';
						$tot+=120*$count;
					}
					echo '<td>'.$row_fees['fee_amount'].'</td>';
					$tot+=$row_fees['fee_amount'];
				}
				echo '<td>'.$tot.'</td>
				<td>'.$row['class_description'].' ('.$count.')</td></tr>';
			}
			$sql = 'select * from subject_fees where class_id='.$row['sno'].' and fees!="" limit 1';
			//echo $sql.'<br>';
			$res_sub = execute_query(connect(), $sql);
			$count = mysqli_num_rows($res_sub);
			if(mysqli_num_rows($res_sub)!=0){
				$tot=0;
				$done=1;
				echo '<tr>
				<td>'.$i++.'</td>
				<td>'.$row['class_description'].' ('.$count.')</td>';
				$sql = 'select * from fees_detail where class_id='.$row['sno'].' and head_id not in ("computer", "self","tour") order by abs(head_id)';
				$res_fees = execute_query(connect(), $sql);
				while($row_fees = mysqli_fetch_array($res_fees)){
					if($row_fees['head_id']==14){
						$row_fees['fee_amount'] = $row_fees['fee_amount']*$count;
					}
					if($row_fees['head_id']==23){
						$prac_amount = mysqli_fetch_array($res_sub);
						$prac_amount = $prac_amount['fees'];
						echo '<td>'.($prac_amount*$count).'</td>';
						$tot+=$prac_amount*$count;
					}
					echo '<td>'.$row_fees['fee_amount'].'</td>';
					$tot+=$row_fees['fee_amount'];
				}
				echo '<td>'.$tot.'</td>
				<td>'.$row['class_description'].' ('.$count.')</td></tr>';
			}

			$sql = 'select * from subject_fees where class_id='.$row['sno'].' and fees!="" limit 2';
			$res_sub = execute_query(connect(), $sql);
			$count = mysqli_num_rows($res_sub);
			if(mysqli_num_rows($res_sub)>1){
				$tot=0;
				$done=1;
				echo '<tr>
				<td>'.$i++.'</td>
				<td>'.$row['class_description'].' ('.$count.')</td>';
				$sql = 'select * from fees_detail where class_id='.$row['sno'].' and head_id not in ("computer", "self" ,"tour") order by abs(head_id)';
				$res_fees = execute_query(connect(), $sql);
				while($row_fees = mysqli_fetch_array($res_fees)){
					if($row_fees['head_id']==14){
						$row_fees['fee_amount'] = $row_fees['fee_amount']*$count;
					}
					if($row_fees['head_id']==23){
						$prac_amount = mysqli_fetch_array($res_sub);
						$prac_amount = $prac_amount['fees'];
						echo '<td>'.($prac_amount*$count).'</td>';
						$tot+=$prac_amount*$count;
					}
					echo '<td>'.$row_fees['fee_amount'].'</td>';
					$tot+=$row_fees['fee_amount'];
				}
				echo '<td>'.$tot.'</td>
				<td>'.$row['class_description'].' ('.$count.')</td></tr>';
			}

			$sql = 'select * from subject_fees where class_id='.$row['sno'].' and fees!="" limit 3';
			$res_sub = execute_query(connect(), $sql);
			$count = mysqli_num_rows($res_sub);
			if(mysqli_num_rows($res_sub)>2){
				$tot=0;
				$done=1;
				echo '<tr>
				<td>'.$i++.'</td>
				<td>'.$row['class_description'].' ('.$count.')</td>';
				$sql = 'select * from fees_detail where class_id='.$row['sno'].' and head_id not in ("computer", "self" ,"tour") order by abs(head_id)';
				$res_fees = execute_query(connect(), $sql);
				while($row_fees = mysqli_fetch_array($res_fees)){
					if($row_fees['head_id']==14){
						$row_fees['fee_amount'] = $row_fees['fee_amount']*$count;
					}
					if($row_fees['head_id']==23){
						$prac_amount = mysqli_fetch_array($res_sub);
						$prac_amount = $prac_amount['fees'];
						echo '<td>'.($prac_amount*$count).'</td>';
						$tot+=$prac_amount*$count;
					}
					echo '<td>'.$row_fees['fee_amount'].'</td>';
					$tot+=$row_fees['fee_amount'];
				}
				echo '<td>'.$tot.'</td>
				<td>'.$row['class_description'].' ('.$count.')</td></tr>';
			}
			if($done==0){
				echo '<tr>
				<td>'.$i++.'</td>
				<td>'.$row['class_description'].' ('.$count.')</td>
				<td colspan="25">DETAILS MISSING</td>
				</tr>';
			}
		}
	
		break;
	}
}
?>
</form></div>
<?php 
page_footer_start();
page_footer_end();
?></body>