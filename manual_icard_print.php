<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
//logvalidate('');
$response=1;
$msg='';
if(isset($_GET['id'])){
	
	$sql="select * from student_info_mannul_icard where sno='".$_GET['id']."'";
	$run=execute_query(connect(), $sql);
	$row=mysqli_fetch_array($run);
}
$sql_session = 'SELECT * FROM `general_settings` WHERE `description`="session"';
$result_session = execute_query(connect(), $sql_session);
$row_session = mysqli_fetch_array($result_session);
$current_session = $row_session['value'];
	
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
			td.content, span.content{border-bottom:1px solid; font-weight: bold;}
		
		</style>
	</head>
	<body id="public">
		<div id="wrapper" style="background-image: linear-gradient(#fff, #eee);">	
			<table border="0" style="width: 85mm;">
				<tr>
					<td colspan="2" align="center"><!--<h1>KAMLA NEHRU INSTITUTE OF PHYSICAL & SOCIAL SCIENCES</h1>--><img src="images/college_name.jpg" style="width:84mm;"></td>
				</tr>
				<tr>
					<td colspan="1" rowspan="3" align="center" style="width: 20mm;"><img src="images/college_log.png" style="height: 50px"></td>
					<td><h3>Sultanpur (U.P.) - 228 118</h3></td>
				</tr>
				<tr>
					<td colspan="2"><h3 style="color: #0024FF; font-style: italic; font-size: 13px;">Accredited by "NAAC" with 'A' 

Grade</h3></td>
				</tr>
				<tr>
					<td colspan="2"><h3><span style="border: 2px solid #f00; padding: 2px;">IDENTITY CARD <?php echo $current_session; ?></span></h3></td>
					
				</tr>
			</table>
			<table border="0" style="width: 85mm;">
				<tr>
					<td colspan="5">Class : <span class="content"><?php echo $row['class']; ?></span></td>
					<td colspan="2" rowspan="4" align="center"><img src="student_mannual_icard/<?php echo $row['photo_id']; ?>" style="height:70px; border:2px solid;"/><br/><img src="images/Proctor_sign_id.png" style="width: 60px; height: 25px;"><br/>Proctor's Signature</td>
				</tr>
				<tr>
					<td>Student Name : </td>
					<td colspan="4" class="content"><?php echo $row['stu_name']; ?></td>
				</tr>
				<tr>
					<td>Father's Name : </td>
					<td colspan="4" class="content"><?php echo $row['father_name']; ?></td>
					
				</tr>
			</table> 
		</div>		
		<div id="wrapper">	
			<table style="width:85mm">
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Date of Birth : </td>
					<td class="content"><?php echo $row['dob']; ?></td>
					<td>Blood Group :</td>
					<td class="content" colspan="2"><?php if($row['blood_group']=='Not Applicable'){echo "&nbsp;";}else{echo $row['blood_group'];} ?></td>
				</tr>
				<tr>
					<td>Aadhar No. :</td>
					<td class="content"><?php echo $row['aadhar']; ?></td>
								
				</tr>
				<tr>
					<td width="25%">E-Mail :</td>
					<td width="25%" class="content"><?php echo $row['e_mail1']; ?></td>
					<td width="25%">Mobile :</td>
					<td width="25%" class="content"><?php echo $row['mobile']; ?></td>
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td width="20%">&nbsp;</td>
					<td width="80%">&nbsp;</td>
				</tr>
				
				<tr>
					<td width="20%">Address</td>
					<td width="80%" class="content"><?php echo $row['post']; ?>
						
					</td>
				</tr>
				<tr>
					<td width="20%">&nbsp;</td>
					<td width="80%">&nbsp;</td>
				</tr>
			</table>
			<div id="footer" style="text-align: right;"><img src="images/stamp.png" style="height: 40px; margin-bottom: 2px;"><h3>Chief Proctror : 7905803842</h3></div>
		</div>
	</body>	
</html>
 