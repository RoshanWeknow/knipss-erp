<?php 
//include("scripts/settings.php");
include("ag_lib_setting.php");

$msg='';

// page_header_start();
// page_header_end();
// page_sidebar();
header_lib();
?>

<style>
form div.row:nth-child(odd) {
  background: #eeeeee;
  border-radius: 5px;
  margin-bottom:5px;
  margin-top:5px;
  padding:5px;
}
form div.row label{
	color:#000000;
}
</style>

<div id="container">
	<div class="card card-body">
		<div class="row d-flex my-auto">
			<form action="barcode_printing.php" class="wufoo leftLabel page1" name="feesdeposit"
				enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
				<h3 class="bg-success text-white text-center p-2"> Bar Code Generate</h3>
				<div class="col-md-12">
					<!-- first row -->
					<div class="row">
						<div class=" col-md-3 ">
							<label>Accession No. From</label>
							<input type="text" name="acc1" id="acc1" value="" class="form-control" required="required">
						</div>
						<div class="  col-md-3 ">
							<label>Accession Number To</label><br>
							<input type="text" name="acc2" id="acc2" value="" class="form-control" required>
						</div>
					</div>
					</br>
					<button type="submit" class="btn btn-primary ms-4" name="save" value="">Submit </button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
// page_footer_start();
// page_footer_end();
footer_lib();
?>