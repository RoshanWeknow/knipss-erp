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
                <div class="bg-secondary text-white p-1 text-center"><h3>ASSESSMENT COMPONENTS</h3></div>
                <div class="col-md-12">
						<div class="row">
							<div class="col-md-4 mb-3">
								<label for="courseOption1" class="form-label">Academic Session</label>
								<select class="form-select" id="courseOption1">
									<option value="co">---Please Select---</option>
								</select>
							</div>

							<div class="col-md-4 mb-3">
								<label for="courseOption2" class="form-label">Course</label>
								<select class="form-select" id="courseOption2">
									<option value="co">---Please Select---</option>
								</select>
							</div>
						</div>
                    </div>
						<script>
							function addRow() {
								// Get the table body
								const amenitiesTableBody = document.querySelector("#amenitiestable tbody");

								// Create a new row
								const newRow = document.createElement("tr");

								// Create cells for the new row
								const amenitiesCell = document.createElement("td");
								const descriptionCell = document.createElement("td");
								const graduateAttributesCell = document.createElement("td");
								const actionCell = document.createElement("td");

								// Create and append input elements
								const amenitiesInput = document.createElement("input");
								amenitiesInput.name = "amenities[]";
								amenitiesInput.className = "form-control";

								const descriptionInput = document.createElement("input");
								descriptionInput.name = "description[]";
								descriptionInput.className = "form-control";

								const graduateAttributesInput = document.createElement("input");
								graduateAttributesInput.name = "graduate_attributes[]";
								graduateAttributesInput.className = "form-control";

								// Create Delete button for the Action column
								const deleteButton = document.createElement("button");
								deleteButton.className = "btn btn-danger btn-sm";
								deleteButton.textContent = "Delete";
								deleteButton.onclick = () => {
									// Delete the current row
									newRow.remove();
								};

								// Append inputs to their respective cells
								amenitiesCell.appendChild(amenitiesInput);
								descriptionCell.appendChild(descriptionInput);
								graduateAttributesCell.appendChild(graduateAttributesInput);
								actionCell.appendChild(deleteButton);

								// Append cells to the row
								newRow.appendChild(amenitiesCell);
								newRow.appendChild(descriptionCell);
								newRow.appendChild(graduateAttributesCell);
								newRow.appendChild(actionCell);

								// Insert the new row before the last row (button row)
								const lastRow = amenitiesTableBody.lastElementChild;
								amenitiesTableBody.insertBefore(newRow, lastRow);
							}
						</script>

						<table id="amenitiestable" class="table table-bordered">
							<thead>
								<tr class="text-white  text-center" style="background-color: #2f4f4f;">
									<th class="text-white">Exam</th>
									<th class="text-white">Max Marks</th>
									<th class="text-white">IsRubric</th>
									<th class="text-white">Action</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input name="amenities[]" class="form-control"></td>
									<td><input name="description[]" class="form-control"></td>
									<td><input name="graduate_attributes[]" class="form-control"></td>
									<td>
										<button class="btn btn-danger btn-sm" type="button" onclick="this.closest('tr').remove()">Delete</button>
									</td>
								</tr>
								<tr>
									<!-- Button Row -->
									<td colspan="4" class="text-end">
										<button class="btn btn-success" type="button" onclick="addRow()">Add</button>
									</td>
								</tr>
							</tbody>
						</table>
                       
                        <button type="submit" class="btn " style="background-color: #2f4f4f;" name="save" value="">Submit </button>
                        <button type="submit" class="btn btn-danger " name="save" value="">Cancel </button>
						<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
                    </div>
                </form>
            </div>
        </div>

        </div>
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
	






























