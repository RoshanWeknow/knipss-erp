<?php 
include("scripts/settings.php");

$msg='';
page_header_start();
page_header_end();
page_sidebar();
?>

<div id="container">
    <div class="card card-body p-2">
        <div class="row d-flex my-auto">
            <div class="bg-secondary text-white p-1 text-center">
                <h3>PO Attainment</h3>
            </div>

            <!-- Forms to Display -->
            <div id="poForm" class="form-section" style="display: none;  padding: 20px;">
                <!-- Your form content goes here -->
                <form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"
                    enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
                    <div class="col-md-12">
						<div class="row">
							<div class="col-md-4 mb-3">
								<label for="courseOption1" class="form-label">Academic Session</label>
								<select class="form-select" id="courseOption1">
									<option value="co">---Please Select</option>
								</select>
							</div>

							<div class="col-md-4 mb-3">
								<label for="courseOption2" class="form-label">Program</label>
								<select class="form-select" id="courseOption2">
									<option value="co">---Please Select</option>
								</select>
							</div>

							<div class="col-md-4 mb-3">
								<label for="courseOption3" class="form-label">Scheme</label>
								<select class="form-select" id="courseOption3">
									<option value="co">---Please Select</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 mb-3">
								<label for="courseOption1" class="form-label">Semester</label>
								<select class="form-select" id="courseOption1">
									<option value="co">---Please Select</option>
								</select>
							</div>

							<div class="col-md-4 mb-3">
								<label for="courseOption2" class="form-label">Course Name</label>
								<select class="form-select" id="courseOption1">
									<option value="co">---Please Select</option>
								</select>
							</div>
							</div>
						</div>

						<button type="submit" class="btn " style="background-color: #2f4f4f;" name="save" value="">Submit </button>
                        <button type="submit" class="btn btn-danger " name="save" value="">Cancle </button>
						<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
                    </div>
            </div>

            
            

            <div id="deleteForm" class="form-section" style="display: none; background-color: #f8d7da; padding: 20px;">
                <!-- Your form content goes here -->
               <div class="row">
					<div class="col-md-4 mb-3">
						<label for="courseOption1" class="form-label">CO PO Mapping Name</label>
						<select class="form-select" id="courseOption1">
							<option value="co">---Please Select</option>
						</select>
					</div>
					
				</div>
				<button type="submit" class="btn btn-primary">CO PO Mapping Report</button>
            </div>

            
</div>

<script>
    // Function to show the selected form
    function showForm(formId) {
        // Hide all forms
        const forms = document.querySelectorAll('.form-section');
        forms.forEach(form => form.style.display = 'none');

        // Show the selected form
        const selectedForm = document.getElementById(formId);
        if (selectedForm) {
            selectedForm.style.display = 'block';
        }
    }

    // Show PO form by default when the page loads
    window.onload = function() {
        showForm('poForm');
    };
</script>

<?php
page_footer_start();
page_footer_end();
?>
