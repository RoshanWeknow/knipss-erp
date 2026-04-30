<?php
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");
$msg='';
$tab=1;
$responce = 0;

page_header_start();
page_header_end();
page_sidebar();	
?>
<!----cdn lind---->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!------cdn link end-------->


<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title text-center"></h4></br>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" name="" target="_blank">
					<?php echo $msg; ?> 
					<div class="col-md-12">
						<h2 class="bg-primary text-white p-2" style="text-align:center;">Facultywise Duty Report</h2>
						<div class="row">
							<div class="col-md-3"></div>
							<div class="col-md-6 mt-5">
								<form>
									<!----------<h3 style="text-align:center;background-color:#0d6efd;color:white;height:4rem;line-height:4rem;">DETAILS OF DAILY EXAMINATION ATTENDANCE REPORT</h3>----------->
									<div style="padding-left:10px;padding-right:10px;">
										<div class="mb-3 pt-3" >
											<label for="date" class="form-label">From Date</label>
											<input type="date" class="form-control" name="date" id="date" required="required">
										</div>
										<div class="mb-3 pt-3" >
											<label for="date" class="form-label">To Date</label>
											<input type="date" class="form-control" name="date" id="date" required="required">
										</div>
										<div class="d-flex" style="justify-content:space-around;">
											<div class="pt-2">
												<button type="search" name = "search" value="search" class="btn btn-primary mt-2 ms-2" style="padding-left:30px;padding-right:30px;">Get Data</button>
											</div>
											<div  class="pt-2">
												<button type="cancel" name = "cancel" value="" class="btn btn-primary mt-2 ms-2"  style="padding-left:30px;padding-right:30px;">Cancel</button>
											</div>	
										</div>
									</div>
								</form>					
							</div>
							<div class="col-md-3"></div>					
						</div>
						<div class="row pt-3">
							<div class="col-md-12">
								<h3 style="text-align:center;background-color:#0d6efd;color:white;height:4rem;line-height:4rem;">DETAILS OF FACULTYWISE DUTY REPORT</h3>
								<div class="d-flex">
									<div class="pt-2 pb-3">
										<button type="excel" name = "excel" value="excel" class="btn btn-primary mt-2 ms-2" style="padding-left:30px;padding-right:30px;">Excel</button>
									</div>
									<div  class="pt-2 pb-3">
										<button type="text" name = "text" value="" class="btn btn-primary mt-2 ms-2"  style="padding-left:30px;padding-right:30px;">Print</button>
									</div>
									<div class="p-4">
										<input type="search" placeholder="search">
									</div>
								</div>
								<table class="table table-striped px-auto">
									<tr>
										<td>#</td>
										<td>NAME</td>
										<td>TOTAL DUTY</td>
										<td>REMUNARATION</td>
										<td>MOBILE NO.</td>
										<td>PAN NO</td>
										<td>ACCOUNT NO</td>
										<td>IFSC</td>
										<td>BRANCH NAME</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
