<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate('admin');
$response=1;
$msg='';
$sql_session = 'SELECT * FROM `general_settings` WHERE `description`="session"';
$result_session = execute_query(connect(), $sql_session);
$row_session = mysqli_fetch_array($result_session);
$current_session = $row_session['value'];
if(isset($_GET['id'])){
	
	$sql="select * from student_info_mannul_icard_hostel where sno='".$_GET['id']."'";
	$run=execute_query(connect(), $sql);
	$row=mysqli_fetch_array($run);
	$stu_id = $row;
}
	
?>
<html>
	<head>
		<title>Hosteller Identity Card Print</title>
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
			.page2 tr{line-height: 34px;}
		
		</style>
	</head>
	<body id="public">
		<div id="wrapper" style="background-image: linear-gradient(#fff, #eee);">	
			<table border="0" style="width: 85mm;">
				<tr>
					<td colspan="2" align="center"><!--<h1>KAMLA NEHRU INSTITUTE OF PHYSICAL & SOCIAL SCIENCES</h1>--><img src="images/kngi.png" style="width:84mm;"><br/><span style="font-size: 14px; font-stretch: extra-expanded">www.knipss.ac.in | www.knmt.org.in</span></td>
				</tr>
				<tr>
					<td colspan="1" rowspan="2" align="center" style=""><img src="images/kngi_logo.jpeg" style="height: 50px"></td>
					<td><h3>Campus:-Faridipur, Sultanpur (U.P.)</h3></td>
				</tr>
				<tr>
					<td colspan="2"><h3><span style="border: 2px solid #f00; padding: 2px;">HOSTEL IDENTITY CARD <?php echo $current_session; ?></span></h3></td>
					
				</tr>
			</table>
			<table border="0" style="width: 85mm;">
				<tr>
					<td>Class : <span class="content"><?php echo $stu_id['class']; ?></span></td>
					<td></td>
					<td width="10%" rowspan="4" align="center"><img src="student_mannual_icard_hostel/<?php echo $stu_id['photo_id']; ?>" style="height:65px; border:2px solid;"/><br/><img src="images/hostel_incharge.gif" style="width: 60px; height: 20px;"><br/>Hostel Incharge</td>					
				</tr>
				<tr>
					<td width="30%">Student Name : </td>
					<td width="25%" class="content"><?php echo $stu_id['stu_name']; ?></td>
				</tr>
				<tr>
					<td>Father's Name : </td>
					<td class="content"><?php echo $stu_id['father_name']; ?></td>
					
				</tr>
				<tr>
					<td>Parent Contact : </td>
					<td colspan="1" class="content"><?php echo $stu_id['parent_contact']; ?></td>
					
				</tr>
			</table>
		</div>
		<div id="wrapper" style="background-image: linear-gradient(#fff, #eee);" class="page2">
			<table border="0" style="width: 85mm;">
				<tr>
					<td colspan="2">Date of Birth : </td>
					<td class="content"><?php echo date("d-m-Y",strtotime($stu_id['dob'])); ?></td>
					<td colspan="3">Blood Group :</td>
					<td class="content"><?php if($stu_id['blood_group']=='Not Applicable'){echo "&nbsp;";}else{echo $stu_id['blood_group'];} ?></td>
				</tr>
				<tr>
					<td colspan="2">Aadhar No. :</td>
					<td colspan="2" class="content"><?php echo $stu_id['aadhar']; ?></td>
					<td colspan="2" width="25%">Mobile :</td>
					<td width="25%" class="content"><?php echo $stu_id['mobile']; ?></td>
				</tr>
				<tr>
					<td width="20%">Address </td>
					<td colspan="6" class="content">
						<u style="text-decoration-style:solid;  line-height:14px;">
						<?php echo $stu_id['temp_address']; ?>
						</u>
						
					</td>
					
				</tr>
				<tr>
					<td width="20%">&nbsp;</td>
					<td colspan="6" class="content">
						<u style="text-decoration-style:solid; line-height:14px;">
						<?php echo $stu_id['perm_address']; ?>
						</u>
					</td>
				</tr>
				<tr>
					<td width="20%">&nbsp;</td>
					<td colspan="6" class="content">
						<u style="text-decoration-style:solid; line-height:14px;">
						<?php echo $stu_id['post']; ?>
						</u>
					</td>
				</tr>
				
			</table>
		</div>
	</body>	
</html>
 