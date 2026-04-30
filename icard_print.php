<?php
include("scripts/settings.php");
logvalidate('admin');
$response=1;
$msg='';
$sql_session = 'SELECT * FROM `general_settings` WHERE `description`="session"';
$result_session = execute_query(connect(), $sql_session);
$row_session = mysqli_fetch_array($result_session);
$current_session = $row_session['value'];
if(isset($_GET['id'])){
	
	$sql = "select student_info.sno as sno, class_description, class_detail.sno as class_id , class_detail.sort_no as class_sort_no , class_detail.year as class_year , class_detail.category as class_category, student_info.roll_no as roll_no, student_info.form_no, student_info.e_mail1 as e_mail, student_info.stu_name, student_info.father_name, student_info.dob, student_info.sub1, student_info.sub2, student_info.sub3, student_info.photo_id as photo_id, student_info.p_house_no as house_no, student_info.p_village as village, student_info.perm_address, student_info.p_post as post, student_info.p_district as district, student_info.p_state as state, blood_group, aadhar as aadhar_no, mobile as mobile,p_mobile as p_mobile, university_uin as university_uin2 from student_info left join class_detail on class_detail.sno = student_info.class where student_info.sno=".$_GET['id'];
	//echo $sql.'<br>';
	$stu_id = mysqli_fetch_assoc(execute_query(connect(), $sql));
	
	$sql_uin = 'select uin_data.p_house_no as house_no, uin_data.p_village as village, uin_data.p_post as post, uin_data.p_district as district, uin_data.p_state as state, uin_data.aadhar as aadhar_no, blood_group, university_uin2, mobile from uin_data where student_id="'.$stu_id['sno'].'" order by sno desc limit 1';
	$uin_data = execute_query(connect(), $sql_uin);
	if(mysqli_num_rows($uin_data)!=0){
		$uin_data = mysqli_fetch_assoc($uin_data);
	}
	else{
		$uin_data = array();
	}
	//print_r($stu_id);
	//echo $sql_uin.'<br>';
	
	$sql = 'select `student_info2`.`sno` as serial, `student_id` as `sno`, class_description,  class_detail.sno as class_id , class_detail.sort_no as class_sort_no , class_detail.year as class_year , class_detail.category as class_category, student_info2.roll_no as roll_no, student_info2.form_no, student_info2.e_mail1 as e_mail, student_info2.stu_name, student_info2.father_name, student_info2.dob, student_info2.sub1, student_info2.sub2, student_info2.sub3, student_info2.photo_id as photo_id from student_info2 left join class_detail on class_detail.sno = student_info2.class where status=2 and student_id='.$stu_id['sno'].' and `student_info2`.type="subject_change"';
	//echo $sql;
	$r_chk = execute_query(connect(), $sql);
	$row_chk = mysqli_num_rows($r_chk);
	if($row_chk!=0){
		$stu_id2 = mysqli_fetch_assoc($r_chk);
		$stu_id['class_description'] = $stu_id2['class_description'];
		$stu_id['sub1'] = $stu_id2['sub1'];
		$stu_id['sub2'] = $stu_id2['sub2'];
		$stu_id['sub3'] = $stu_id2['sub3'];
		$stu_id['roll_no'] = $stu_id2['roll_no'];
		$stu_id['class_id'] = $stu_id2['class_id'];
		$stu_id['class_sort_no'] = $stu_id2['class_sort_no'];
		$stu_id['class_year'] = $stu_id2['class_year'];
	}
	//print_r ($stu_id);
	$stu_id = array_merge($stu_id,$uin_data);
	
	
	if(fileExists("PHOTO/".$stu_id['photo_id'])){
	    $photo = fileExists("PHOTO/".$stu_id['photo_id']);
	    $sign = fileExists("PHOTO/".$stu_id['signature_id']);
		//$photo = "PHOTO/".$stu_id['photo_id'];
		//$sign = "PHOTO/".$stu_id['signature_id'];
	}
	elseif(fileExists($stu_id['photo_id'])){
		$photo = fileExists($stu_id['photo_id']);
	    $sign = fileExists($stu_id['signature_id']);
	}
	else{
		$photo = "PHOTO/".$stu_id['sno'].'.jpg';
		$sign = "PHOTO/".$stu_id['sno'].'_sign.jpg';
	}
	$response=2;
}
?>
<html>
	<head>
		<title>Identity Card Print</title>
		<style>
			@charset "utf-8";
			/* CSS Document */
			@page {
				margin: 0mm;
				size: 54mm, 85mm;
			}
			#wrapper{
				font-family: Arial;
				height: 54mm;
				width: 85mm;
				border: 0px solid;
				page-break-after: always;
				position: relative;
				/*background: url(images/watermark_icard.png) no-repeat center;*/
			}
			#footer{
				position: absolute;
				bottom: 10px;
				right: 10px;				
			}
			h1{
				color:#CC0003;
				font-size: 13px;
				font-family:"Calibri";
				/*transform: scale(1, 2);
				  -webkit-transform: scale(1, 2); /* Safari and Chrome */
				  -moz-transform: scale(1, 2); /* Firefox */
				  -ms-transform: scale(1, 2); /* IE 9+ */
				  -o-transform: scale(1, 2);*/
			}
			h3{font-size: 12px; line-height: 9px; text-align: center; margin: 0px; padding: 0px;}
			td{font-size: 10px; font-weight:bold;}
			td.content, span.content{border-bottom:1px solid; font-weight: bold;}
		
		</style>
	</head>
	<body id="public">
		<div id="wrapper" style="background-image: linear-gradient(#fff, #eee);">	
			<table border="0" style="width: 85mm;">
				<tr>
					<td colspan="2" align="center"><!--<h1>KAMLA NEHRU INSTITUTE OF PHYSICAL & SOCIAL SCIENCES</h1>--><img src="images/icard_header.png" style="width:84mm;"></td>
				</tr>
				<tr>
					<td colspan="2"><h3><span style="border: 2px solid #f00; padding: 2px;">IDENTITY CARD <?php echo $current_session; ?></span></h3></td>
					
				</tr>
			</table>
			<table border="0" style="width: 85mm;">
				<tr>
					<td colspan="2">Class : <span class="content"><?php echo $stu_id['class_description']; ?></span></td>
					<td colspan="3">Ledger : 
						<span class="content"><?php echo $stu_id['roll_no']; ?></td></span>
					<td colspan="2" rowspan="4" align="center"><img src="<?php echo $photo; ?>" style="height:60px; border:2px solid;"/><br/><img src="images/Proctor_sign_id.png" style="width: 55px; height: 25px;"><br/>Proctor's Signature</td>					
				</tr>
				<tr>
					<td>Student Name : </td>
					<td colspan="4" class="content"><?php echo $stu_id['stu_name']; ?></td>
				</tr>
				<tr>
					<td>Father's Name : </td>
					<td colspan="4" class="content"><?php echo $stu_id['father_name']; ?></td>
					
				</tr>
				<tr>
					<td>Subjects : </td>
					<td colspan="4" class="content" style="font-size:8px;">
						<?php 
						if($stu_id['class_category']=='PG'){
						$sql = "select * from pg_subject where student_id=".$stu_id['sno'];
						$pg = execute_query(connect(), $sql);
						if(mysqli_num_rows($pg)!=0){
							$pg = mysqli_fetch_assoc($pg);
							$pgsub1 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$pg['sub1']."'"))['subject'];
							$pgsub2 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$pg['sub2']."'"))['subject'];
							$pgsub3 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$pg['sub3']."'"))['subject'];
							$pgsub4 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$pg['sub4']."'"))['subject'];
							$pgsub5 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$pg['sub5']."'"))['subject'];
							$pgsub6 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$pg['sub6']."'"))['subject'];
							$pgsub = array();
							if($pgsub1!=''){
								$pgsub[] = $pgsub1;
							}
							if($pgsub2!=''){
								$pgsub[] = $pgsub2;
							}
							if($pgsub3!=''){
								$pgsub[] = $pgsub3;
							}
							if($pgsub4!=''){
								$pgsub[] = $pgsub4;
							}
							if($pgsub5!=''){
								$pgsub[] = $pgsub5;
							}
							if($pgsub6!=''){
								$pgsub[] = $pgsub6;
							}
							$pgsub = implode(", ", $pgsub);
							echo $pgsub;
						}
					}
					else{
						echo get_subject_detail($stu_id['sub1'])['subject']; 
						if($stu_id['sub2']!=''){
							echo ', '.get_subject_detail($stu_id['sub2'])['subject']; 
						}
						if($stu_id['sub3']!=''){
							echo ', '.get_subject_detail($stu_id['sub3'])['subject']; 
						}
					}

						?>
					</td>
				</tr>
			</table> 
		</div>		
		<div id="wrapper">	
			<table style="width:85mm">
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td>Date of Birth : </td>
					<td class="content"><?php echo $stu_id['dob']; ?></td>
					<td>Blood Group :</td>
					<td class="content" colspan="2"><?php if($stu_id['blood_group']=='Not Applicable'){echo "&nbsp;";}else{echo $stu_id['blood_group'];} ?></td>
				</tr>
				<tr>
					<td>Aadhar No. :</td>
					<td class="content"><?php echo $stu_id['aadhar_no']; ?></td>
					<td>UIN :</td>
					<td class="content"><?php echo $stu_id['university_uin2']; ?></td>				
				</tr>
				<tr>
					<td width="25%">Mobile :</td>
					<td width="25%" class="content"><?php echo $stu_id['mobile']; ?></td>
					<td width="25%">P Mob. :</td>
					<td width="25%" class="content"><?php echo $stu_id['p_mobile']; ?></td>
				</tr>
				<tr>
					<td>E-Mail :</td>
					<td colspan="3" class="content"><?php echo $stu_id['e_mail']; ?></td>
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="20%">Address</td>
					<td width="80%" class="content">
						<u style="text-decoration-style:solid; line-height:14px;">
						<?php echo $stu_id['perm_address']; ?>&nbsp;
						<?php echo $stu_id['house_no']; ?>&nbsp;
						<?php echo $stu_id['village']; ?>&nbsp;
						<?php echo $stu_id['post'].'&nbsp;'.$stu_id['district'];
						if($stu_id['state']!=''){
							echo '('.$stu_id['state'].')';
						}?>&nbsp;
						</u>
					</td>
				</tr>
				<?php 
					$batch = array();
					$sql_check_sem = 'SELECT * FROM `class_detail` WHERE `sno`="'.$stu_id['class_id'].'" AND `class_description` LIKE "%Sem%"';
					$result_check_sem = execute_query(connect(), $sql_check_sem );
					if (mysqli_num_rows($result_check_sem) == 1) {
						$print = 'YES';
						$sql_class = 'SELECT * FROM `class_detail` WHERE `sort_no`="'.$stu_id['class_sort_no'].'" AND `year`>="'.$stu_id['class_year'].'" ORDER BY `YEAR`';
						//echo $sql_class;
						$result_class = execute_query(connect(), $sql_class );
						while ($row_class = mysqli_fetch_array($result_class)) {
							if ($print == 'YES') {
								$batch[] = '<span style="border:1px solid #000;">'.$current_session.'</span>';
							}
							if (($row_class['year'] % 2) == 0) {
								$print = 'YES';
								$start = strpos($current_session , "-");
								$start = substr($current_session , $start+1);
								$end = $start + 1;
								$current_session = $start.'-'.$end;
							}
							else{
								$print = 'NO';
							}
						}
					}
					else{
						$sql_class = 'SELECT * FROM `class_detail` WHERE `sort_no`="'.$stu_id['class_sort_no'].'" AND `year`>="'.$stu_id['class_year'].'" ORDER BY `YEAR`';
						//echo $sql_class;
						$result_class = execute_query(connect(), $sql_class );
						while ($row_class = mysqli_fetch_array($result_class)) {
							$batch[] = '<span style="border:1px solid #000;">'.$current_session.'</span>';
							$start = strpos($current_session , "-");
							$start = substr($current_session , $start+1);
							$end = $start + 1;
							$current_session = $start.'-'.$end;
						}
					}
				?>
				<tr>
					<td>Batch: </td>
					<td class="content"><?php echo implode(", ", $batch); ?></td>
				</tr>
			</table>
			<div id="footer" style="text-align: right;"><img src="images/stamp.png" style="height: 40px; margin-bottom: 2px;"><h3>Chief Proctror : 9654624826</h3></div>
		</div>
	</body>	
</html>
 