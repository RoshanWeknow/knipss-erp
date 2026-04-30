<?php
include("scripts/settings.php");
$msg='';
$tab=1;
$responce = 0;



page_header_start();
page_header_end();
page_sidebar();	
?>
<!-- FONT AWESOME  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<style>
		.course_name, .sub_name, .paper_name, .paper_num{
			font-size:15px;
			padding:5px;
		}
	</style>
		

<div id="container">
	<div class="card card-body">
		<div class="row d-flex my-auto">
			<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
				<div class="bg-primary text-white p-2"><h2 class="bg-primary text-white text-center fs-1">ABS</h2></div>
				
				<div class="col-md-12">
			
					<table width="100%" class="table table-striped table-bordered table-hover rounded">
						<tr>
							<th width="15%">Course Name</th>
							<th width="15%">
								<select name="course_name" id="course_name" value="" class="form-control course_name" >
									<option disabled selected>---Select Course---</option>
									<option value="1" >Course 1</option>
									<option value="2" >Course 2</option>
									<option value="3" >Course 3</option>
								</select>
							</th>
							<th>Subject Name</th>
							<th>
								<select name="sub_name" id="sub_name" value="" class="form-control sub_name" >
									<option disabled selected>---Select Subject---</option>
									<option value="1" >Subject 1</option>
									<option value="2" >Subject 2</option>
									<option value="3" >Subject 3</option>
								</select>
							</th>
							<th>Paper Name</th>
							<th>
								<select name="paper_name" id="paper_name" value="" class="form-control paper_name" >
									<option disabled selected>---Select Paper---</option>
									<option value="1" >Paper 1</option>
									<option value="2" >Paper 2</option>
									<option value="3" >Paper 3</option>
								</select>
							</th>
						</tr>
						<tr>
							<th width="15%">Paper Number</th>
							<th width="15%">
								<select name="paper_num" id="paper_num" value="" class="form-control paper_num" >
									<option disabled selected>---Select Paper---</option>
									<option value="1" >I</option>
									<option value="2" >II</option>
									<option value="3" >III</option>
								</select></th>
							<th>Exam Date </th>
							<th><input type="date" name="exam_date" id="exam_date" class="form-control  exam_date" required="" value=""></th>
							<th>Entry Close Date</th>
							<th><input type="date" name="entry_close_date" id="entry_close_date" class="form-control entry_close_date" value="" required="" ></th>
						</tr>
					</table>



				   
					<button type="submit" class="btn btn-primary " name="save" value="">Submit </button>
					<input type="hidden" name="edit" value="">
				</div>
			</form>
		</div>
	</div>
	<div class="card card-body">
		<div class="bg-primary text-white p-2 mb-2"><h3> ABS Report</h3></div>
		<table width="100%" class="table table-striped table-bordered table-hover rounded">
			
			<tr class="text-white bg-primary" align="center">
				<th >S.NO.</th>
				<th >EXAM DATE</th>
				<th>ENTRY CLOSE DATE</th>
				<th >COURES DETAILS</th>
				<th >SUBJECT NAME</th>
				<th >PAPER NAME</th>
				<th >PAPER</th>
				<th >SUTDENT COUNT</th>
				<th></th>
			</tr>
			
			<tr>
				<td class="">1</td>
				<td>12 Feb 2024 09:30</td>
				<td>12 Feb 2024 05:30</td>
				<td>B.B.A. IST SEMESTER </td>
				<td>B.B.A. I ST SEMESTER</td>
				<td>BUSINESS ETHICS </td>
				<td>VII</td>
				<td>
					<table class="table table-bordered">
						<tr>
							<td width="50%">Total :</td>
							<td width="20%">1</td>
						</tr>
						<tr>
							<td>ABSENT :</td>
							<td>0</td>
						</tr>
						<tr>
							<td>UFM :</td>
							<td>0</td>
						</tr>
					</table>
				</td>
				<td><a href="#" target="_blank">PRINT</a></td>
			</tr>
			<tr>
				<td>2</td>
				<td>12 Feb 2024 09:30</td>
				<td>12 Feb 2024 05:30</td>
				<td>B.B.A. IST SEMESTER </td>
				<td>B.B.A. I ST SEMESTER</td>
				<td>BUSINESS ETHICS </td>
				<td>VII</td>
				<td>
					<table class="table table-bordered">
						<tr>
							<td width="50%">Total :</td>
							<td width="20%">1</td>
						</tr>
						<tr>
							<td>ABSENT :</td>
							<td>0</td>
						</tr>
						<tr>
							<td>UFM :</td>
							<td>0</td>
						</tr>
					</table>
				</td>
				<td><a href="#" target="_blank" class="btn btn-success">PRINT</a></td>
			</tr>
			<tr>
				<td>3</td>
				<td>12 Feb 2024 09:30</td>
				<td>12 Feb 2024 05:30</td>
				<td>B.B.A. IST SEMESTER </td>
				<td>B.B.A. I ST SEMESTER</td>
				<td>BUSINESS ETHICS </td>
				<td>VII</td>
				<td>
					<table class="table table-bordered">
						<tr>
							<td width="50%">Total :</td>
							<td width="20%">1</td>
						</tr>
						<tr>
							<td>ABSENT :</td>
							<td>0</td>
						</tr>
						<tr>
							<td>UFM :</td>
							<td>0</td>
						</tr>
					</table>
				</td>
				<td><a href="#" target="_blank">PRINT</a></td>
			</tr>
			<tr>
				<td>4</td>
				<td>12 Feb 2024 09:30</td>
				<td>12 Feb 2024 05:30</td>
				<td>B.B.A. IST SEMESTER </td>
				<td>B.B.A. I ST SEMESTER</td>
				<td>BUSINESS ETHICS </td>
				<td>VII</td>
				<td>
					<table class="table table-bordered">
						<tr>
							<td width="50%">Total :</td>
							<td width="20%">1</td>
						</tr>
						<tr>
							<td>ABSENT :</td>
							<td>0</td>
						</tr>
						<tr>
							<td>UFM :</td>
							<td>0</td>
						</tr>
					</table>
				</td>
				<td><a href="#" target="_blank">PRINT</a></td>
			</tr>
			<tr>
				<td>5</td>
				<td>12 Feb 2024 09:30</td>
				<td>12 Feb 2024 05:30</td>
				<td>B.B.A. IST SEMESTER </td>
				<td>B.B.A. I ST SEMESTER</td>
				<td>BUSINESS ETHICS </td>
				<td>VII</td>
				<td>
					<table class="table table-bordered">
						<tr>
							<td width="50%">Total :</td>
							<td width="20%">1</td>
						</tr>
						<tr>
							<td>ABSENT :</td>
							<td>0</td>
						</tr>
						<tr>
							<td>UFM :</td>
							<td>0</td>
						</tr>
					</table>
				</td>
				<td><a href="#" target="_blank">PRINT</a></td>
			</tr>
			
		</table>
	</div>
</div>