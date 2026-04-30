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
              <div class="bg-secondary text-white p-1 text-center">
                <h3 >CO PO Mapping</h3>
            </div>

            <!-- Button Group -->
            <div class="btn-group d-flex justify-content-center my-3" role="group" aria-label="First group">
                <button type="button" class="btn btn-outline-primary" onclick="showForm('poForm')">CO PO Mapping</button>
                <button type="button" class="btn btn-outline-danger" onclick="showForm('deleteForm')">Print Data</button>
            </div>

            <!-- Forms to Display -->
            <div id="poForm" class="form-section card p-2" style="display: none;  padding: 20px;">
                <h5 class=" text-center text-white p-1" style="background-color: #2f4f4f;">CO PO Mapping</h5>
                <!-- Your form content goes here -->
                <form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"
                    enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
                    <div class="col-md-12">
						<div class="row">
							<div class="col-md-4 mb-3">
								<label for="courseOption1" class="form-label">Program</label>
								<select class="form-select" id="courseOption1">
									<option value="co">---Please Select</option>
								</select>
							</div>

							<div class="col-md-4 mb-3">
								<label for="courseOption2" class="form-label">Curriculum Name</label>
								<select class="form-select" id="courseOption2">
									<option value="co">---Please Select</option>
								</select>
							</div>

							<div class="col-md-4 mb-3">
								<label for="courseOption3" class="form-label">Program Course Name</label>
								<select class="form-select" id="courseOption3">
									<option value="co">---Please Select</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 mb-3">
								<label for="courseOption1" class="form-label">Status</label>
								<select class="form-select" id="courseOption1">
									<option value="co">---Please Select</option>
								</select>
							</div>

							<div class="col-md-4 mb-3">
								<label for="courseOption2" class="form-label">Mapping Name</label>
								<input placeholder="Enter mapping Name " type="text" class="form-control">
							</div>
						</div>

                       
                        <button type="submit" class="btn " style="background-color: #2f4f4f;" name="save" value="">Submit </button>
                        <button type="submit" class="btn btn-danger " name="save" value="">Cancle </button>
						<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
                    </div>
            </div>

            
            

            <div id="deleteForm" class="form-section card p-2" style="display: none; padding: 20px;">
                <!-- Your form content goes here -->
				<h5 class=" text-center text-white p-1" style="background-color: #2f4f4f;">CO PO Mapping Name</h5>
               <div class="row">
					<div class="col-md-4 mb-3">
						<label for="courseOption1" class="form-label">CO PO Mapping Name</label>
						<select class="form-select" id="courseOption1">
							<option value="co">---Please Select</option>
						</select>
					</div>
					
				</div>
				<button type="submit" class="btn " style="background-color: #2f4f4f;" name="save" value="">CO PO Mapping Report </button>
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
