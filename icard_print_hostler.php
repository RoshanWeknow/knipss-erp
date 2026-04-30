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
	
	$sql = "select student_info.sno as sno, class_description, class_detail.sno as class_id , class_detail.sort_no as class_sort_no , class_detail.year as class_year , class_detail.category as class_category, student_info.roll_no as roll_no, student_info.form_no, student_info.e_mail1 as e_mail, student_info.stu_name, student_info.father_name, student_info.dob, student_info.sub1, student_info.sub2, student_info.sub3, student_info.photo_id as photo_id, student_info.p_house_no as house_no, student_info.p_village as village, student_info.perm_address, student_info.p_post as post, student_info.p_district as district, student_info.p_state as state, blood_group, aadhar as aadhar_no, p_mobile as mobile, university_uin as university_uin2 from student_info left join class_detail on class_detail.sno = student_info.class where student_info.sno=".$_GET['id'];
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
	}
	else{
		$photo = "PHOTO/".$stu_id['sno'].'.jpg';
	}
	$response=2;
}
?>
<html>
	<head>
		<title>Hostler Identity Card Print</title>
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
			td.content, span.content{border-bottom:1px solid; font-weight: bold;}
		
		</style>
	</head>
	<body id="public">
		<div id="wrapper" style="background-image: linear-gradient(#fff, #eee);">	
			<table border="0" style="width: 85mm;">
				<tr>
					<td colspan="2" align="center"><!--<h1>KAMLA NEHRU INSTITUTE OF PHYSICAL & SOCIAL SCIENCES</h1>--><img src="images/kngi.png" style="width:84mm;"></td>
				</tr>
				<tr>
					<td colspan="1" rowspan="3" align="center" style="width: 20mm;"><img src="images/kngi_logo.jpeg" style="height: 50px"></td>
					<td><h3>Sultanpur (U.P.) - 228 118</h3></td>
				</tr>
				<tr>
					<td colspan="2"><h3><span style="border: 2px solid #f00; padding: 2px;">HOSTLER IDENTITY CARD <?php echo $current_session; ?></span></h3></td>
					
				</tr>
			</table>
			<table border="0" style="width: 85mm;">
				<tr>
					<td colspan="2">Class : <span class="content"><?php echo $stu_id['class_description']; ?></span></td>
					<td colspan="3"></td>
					<td colspan="2" rowspan="4" align="center"><img src="<?php echo $photo; ?>" style="height:70px; border:2px solid;"/><br/><img src="images/hostel_incharge.gif" style="width: 60px; height: 25px;"><br/>Hostel Incharge</td>					
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
					<td>Date of Birth : </td>
					<td class="content"><?php echo $stu_id['dob']; ?></td>
					<td>Blood Group :</td>
					<td class="content" colspan="2"><?php if($stu_id['blood_group']=='Not Applicable'){echo "&nbsp;";}else{echo $stu_id['blood_group'];} ?></td>
				</tr>
				<tr>
					<td colspan="2">Aadhar No. :</td>
					<td colspan="2" class="content"><?php echo $stu_id['aadhar_no']; ?></td>
					<td colspan="2" width="25%">Mobile :</td>
					<td width="25%" class="content"><?php echo $stu_id['mobile']; ?></td>
				</tr>
				<tr>
					<td width="20%">Address</td>
					<td colspan="6" class="content">
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
				
			</table>
		</div>
	</body>	
</html>
 