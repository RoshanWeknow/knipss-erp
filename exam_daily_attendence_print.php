<?php 
	include("scripts/settings.php"); 
	$sql = 'SELECT * FROM exam_daily_examination_attendence where sno="'.$_GET['edit'].'"';
		$result = mysqli_query($db,$sql);
		$i=1;
		$row = mysqli_fetch_assoc($result)
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Examination Duty Report</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<style>
		body {
			font-family: 'Roboto', sans-serif;
			font-size: 0.9rem;
			margin: 10px;
			position: relative;
		}
		#logoWatermark {
			opacity: 0.08;
			position: fixed;
			top: 70%;
			left: 50%;
			transform: translate(-50%, -50%);
			z-index: -1;
			width: 40%;
			display: block;
		}
		@media print {
			#printButton {
				display: none;
			}
			#logoWatermark {
				opacity: 0.08;
				position: fixed;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				z-index: -1;
				width: 80%;
				display: block;
			}
		}
		
		.table th, .table td {
			vertical-align: middle;
			text-align: center;
		}
	</style>
	<script>
		function printAndRemoveButton() {
			window.print();
			var btn = document.getElementById("printButton");
			btn.parentNode.removeChild(btn);
		}
	</script>
</head>
<body>

<div class="text-center mb-2">
	<button id="printButton" class="btn btn-primary btn-sm" onclick="printAndRemoveButton()">Print</button>
</div>

<img src="images/logo_bg.png" id="logoWatermark" alt="Watermark">

<div class="container-fluid col-md-9 mx-auto">
	<table class="w-100 mb-4">
		<tr>
			<td width="15%"><img src="images/kni_logo.png" style="height:90px;" class="img-fluid" alt="Logo"></td>
			<td class="text-center">
				<h4 class="mb-0"><strong>Kamla Nehru Institute Of Physical & Social Sciences</strong></h4>
				<h4 class="mb-0"><strong>Sultanpur, Uttar Pradesh</strong></h4>
				<p class="mb-0">An Autonomous Institute | Accredited "A" Grade by NAAC</p>
				<p class="mb-0">(Affiliated to Dr. Rammanohar Lohia Avadh University, Ayodhya U.P.)</p>
			</td>
		</tr>
	</table>

	<div class="text-center mb-3">
		<h5><u>Examination Duty Report</u></h5>
	</div>

	<!-- Duty Report Table -->
	<table class=" P-3" width="100%">
		<tr>
			<th width="30%">DATE OF EXAMINATION</th>
			<td width="20%">: <?php echo date('d-m-Y', strtotime($row['exam_date'])); ?></td>
			<th width="30%">EXAMINATION SHIFT</th>
			<td width="20%">: <?php echo $row['exam_shift']; ?></td>
		</tr>
		<tr>
			<th>NUMBER OF ROOMS</th>
			<td>: <?php echo $row['room_count']; ?></td>
		
			<th>TOTAL STUDENT REG.</th>
			<td>: <?php echo $row['total_reg_stud']; ?></td>
		</tr>
		<tr>	
			<th>SHIFT WISE NO. OF STUDENT</th>
			<td>: <?php echo $row['shift_wise_stud_count']; ?></td>
			<th>TOTAL DUTY</th>
			<td>: <?php $tot_duty = $row['alloted_cs'] + $row['alloted_as'] + $row['alloted_ri'] + $row['alloted_relive'] ; echo $tot_duty; ?></td>
		</tr>
	</table>
	<br>
		<table class="table table-bordered table-striped">
		
			<tr class="bg-secondary text-white p-2">
				<th>S.No.</th>
				<th>DUTY ASSIGNED</th>
				<th>DESIGNATION</th>
				<th>FACULTY NAME</th>
			</tr>
		<tbody>
		<?php
			$sql = 'SELECT * FROM exam_daily_attendence2 where exam_daily_attendence2_sno="'.$row['sno'].'"';
			$result = mysqli_query($db,$sql);
			$i=1;
			while($row2 = mysqli_fetch_assoc($result)){
				$sql2  = 'SELECT * FROM exam_faculty_master_info where sno="'.$row2['sel_faculty'].'"';
				$result2 = mysqli_query($db,$sql2);
				$faculty = mysqli_fetch_assoc($result2)
		?>
			<tr>	
				<td><?php echo $i++; ?></td>
				<td><?php echo $row2['duty_assign']; ?></td>
				<td><?php echo $row2['sel_designation']; ?></td>
				<td><?php echo $faculty['name']; ?></td>
			</tr>
		<?php }?>
		</tbody>
	</table>
		<div class="row mt-5">
			<div class="col-6 text-start">
			</div>
			<div class="col-6 text-end mt-5" >
				<p><strong>Controller of Examinations</strong></p>
			</div>
		</div>

</div>

</body>
</html>
