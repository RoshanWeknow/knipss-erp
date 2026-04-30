<?php 
include("scripts/settings.php");


$msg='';
page_header_start();
page_header_end();
page_sidebar();
?>

	<div id="container">
		<div class="card card-body">
			<div class="row d-flex my-auto">
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"
                enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
					<div class="bg-secondary text-white p-1 text-center"><h3>MARKS ENTRY</h3></div>
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-4 mb-3">
								<label for="courseOption1" class="form-label">Session Name</label>
								<select class="form-select" id="courseOption1">
									<option value="co">---Please Select---</option>
								</select>
							</div>
						</div>
                    </div>
					<button type="submit" class="btn " style="background-color: #2f4f4f;" name="save" value="">Submit </button>
					<button type="submit" class="btn btn-danger " name="save" value="">Cancel </button>
                </form>
            </div>
        </div>
    </div>
<?php
page_footer_start();
page_footer_end();


?>	
	






























