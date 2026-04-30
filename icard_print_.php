<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate('admin');
$response=1;
$msg='';
if(isset($_GET['id'])){
	//echo $_GET['id'];
	$sql = "select student_info.sno as sno, class_description, class_detail.category as class_category, student_info.form_no, student_info.e_mail1 as e_mail, uin_data.mobile as mobile, student_info.stu_name, student_info.father_name, student_info.dob, student_info.roll_no as roll_no, uin_data.blood_group, student_info.sub1, student_info.sub2, student_info.sub3, uin_data.aadhar as aadhar_no, uin_data.university_uin2 as university_uin2, student_info.photo_id as photo_id, uin_data.p_house_no as house_no, uin_data.p_village as village, uin_data.p_post as post, uin_data.p_district as district, uin_data.p_state as state from student_info left join class_detail on class_detail.sno = student_info.class left join uin_data on uin_data.student_id = student_info.sno where student_info.sno=".$_GET['id'];
	$stu_id = mysqli_fetch_array(execute_query(connect(), $sql));
	//print_r($stu_id);
	//echo $sql;
	
	$sql = 'select `sno` as serial, `student_id` as `sno`, `stu_name`, `father_name`, `mother_name`, `class`, `reservation`, `waightage`, `minority`, `physical_handicapped`, 

`dob`, `acc_no`, `bank_name`, `branch_name`, `temp_address`, student_info2.roll_no as roll_no, `perm_address`, `pin`, `mobile`, `p_mobile`, `p_pin`, `date_of_admission`, 

`gender`, `photo_id`, `signature_id`, `subject_id`, `district`, `state`, `nationality`, `category`, `form_no`, `p_district`, `p_state`, `post`,`p_post`, `sub1`, `sub2`, `sub3`, `e_mail1`, 

`e_mail2`, `status`, `roll_no`, `marks`, `counselling_date`, `cat_rank`, `income_certificate`, `annual_income`, `other_univ`, `user_id`, `icard`, `univ_roll`,`remarks`, `aadhar`, 

`aadhar_type`  from student_info2 where status=2 and student_id='.$stu_id['sno'].' and type="subject_change"';
	//echo $sql;
	$r_chk = execute_query(connect(), $sql);
	$row_chk = mysqli_num_rows($r_chk);
	if($row_chk!=0){
		$stu_id = mysqli_fetch_array($r_chk);
		//print_r ($stu_id);
	}
	
	if(file_exists("PHOTO/".$stu_id['photo_id'])){
		$photo = "PHOTO/".$stu_id['photo_id'];
	}
	else{
		$photo = "PHOTO/".$stu_id['sno'].'.jpg';
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
			td{font-size: 10px;}
			td.content{border-bottom:1px solid; font-weight: bold;}
		
		</style>
	</head>
	<body id="public">
		<div id="wrapper" style="background-image: linear-gradient(#fff, #eee);">	
			<table border="0" width="100%">
				<tr>
					<td colspan="6" align="center"><!--<h1>KAMLA NEHRU INSTITUTE OF PHYSICAL & SOCIAL SCIENCES</h1>--><img src="images/college_name.jpg" style="width:85mm;"></td>
				</tr>
				<tr>
					<td colspan="1" rowspan="3" align="center"><img src="images/college_log.png" style="height: 50px"></td>
					<td colspan="5"><h3>Sultanpur (U.P.) - 228 118</h3></td>
				</tr>
				<tr>
					<td colspan="5"><h3 style="color: #0024FF; font-style: italic; font-size: 13px;">Accredited by "NAAC" with 'A' 

Grade</h3></td>
				</tr>
				<tr>
					<td colspan="6"><h3><span style="border: 2px solid #f00; padding: 2px;">IDENTITY CARD 2019-2020</span></h3></td>
					
				</tr>
				<tr>
					<td>Class : </td>
					<td class="content"><?php echo $stu_id['class_description']; ?></td>
					<td>Ledger : </td>
					<td colspan="2" class="content"><?php echo $stu_id['roll_no']; ?></td>
					<td colspan="2" rowspan="4" align="center"><img src="<?php echo $photo; ?>" style="height:70px; border:2px solid;"/><br/><img src="images/sign.png" style="width: 60px; height: 25px;"><br/>Proctor's Signature</td>					
				</tr>
				<tr>
					<td>Student Name : </td>
					<td colspan="4" class="content"><?php echo $stu_id['stu_name']; ?></td>
				</tr>
				<tr>
					<td>Father Name : </td>
					<td colspan="4" class="content"><?php echo $stu_id['father_name']; ?></td>
					
				</tr>
				<tr>
					<td>Subjects : </td>
					<td colspan="4" class="content" style="font-size:8px;">
						<?php 
						if($stu_id['class_category']=='PG'){
							$pg = mysqli_fetch_array(execute_query(connect(), "select * from pg_subject where student_id=".$stu_id['sno']));
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
			<table width="100%">
				<tr>
					<td>&nbsp;</td>
				</tr>
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
					<td width="20%">E-Mail :</td>
					<td width="30%" class="content"><?php echo $stu_id['e_mail']; ?></td>
					<td width="20%">Mobile :</td>
					<td width="30%" class="content"><?php echo $stu_id['mobile']; ?></td>
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="20%">&nbsp;</td>
					<td width="80%">&nbsp;</td>
				</tr>
				
				<tr>
					<td width="20%">Address</td>
					<td width="80%" class="content">
						<u style="text-decoration-style:solid; line-height:14px;">
						<?php echo $stu_id['house_no']; ?>&nbsp;
						<?php echo $stu_id['village']; ?>&nbsp;
						<?php echo $stu_id['post'].'&nbsp;'.$stu_id['district'];
						if($stu_id['state']!=''){
							echo '('.$stu_id['state'].')';
						}?>&nbsp;
						</u>
					</td>
				</tr>
				<tr>
					<td width="20%">&nbsp;</td>
					<td width="80%">&nbsp;</td>
				</tr>
			</table>
			<div id="footer"><h3>Chief Proctror : 7905803842</h3></div>
		</div>
	</body>	
</html>
 