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
                <div class="bg-secondary text-white p-1 text-center"><h3>PROGRAM OUTCOME</h3></div>
                <div class="col-md-12">
                    <div class="btn-group d-flex justify-content-center my-3" role="group" aria-label="First group">
                        <button type="button" class="btn btn-outline-primary" onclick="showForm('poForm')">PO</button>
                        <button type="button" class="btn btn-outline-success" onclick="showForm('printForm')">Print Data</button>
                        <button type="button" class="btn btn-outline-info" onclick="showForm('copyForm')">Copy Data</button>
                        <button type="button" class="btn btn-outline-danger" onclick="showForm('deleteForm')">Delete PO</button>
                        <button type="button" class="btn btn-outline-warning" onclick="showForm('guideForm')">Guide Me</button>
                        <button type="button" class="btn btn-outline-secondary" onclick="showForm('poCompetencyForm')">PO Competency</button>
                        <button type="button" class="btn btn-outline-dark" onclick="showForm('competencyIndicatorsForm')">Competency Indicators</button>
                    </div>

                    <!-- Forms to Display -->
                    <div id="poForm" class="form-section" style="display: none;">
                       
                        <div class="card card-body">
							<div class="row d-flex my-auto">
								<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"
									enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
									<div class="col-md-12">
										 <h5 class=" text-center text-white p-1" style="background-color: #2f4f4f;">PO Form</h5>
										<!-- first row -->
										<table width="100%" class="table table-striped table-hover rounded">
											<tr >
												
												
												<th width="">
													<label>Curriculum</label> 
													<select name="" id="" class="form-control" value=""tabindex="<?php echo $tab++; ?>">
														<option selected=""> ----Select-----</option>
														<option value="Ground floor" >BMCC-Bachelor of Commerce - B Com - B Com -2022-2025</option>
														<option value="First Floor" >BMCC-Bachelor of Commerce B Com- B Com -2022-2025-[MS]</option>
														<option value="First Floor" >BMCC - Bachelor of Commerce B Com-B Com-2021-2024-[MS]</option>

													</select>
												</th>
												<th width="">
													<label>PO</label> 
													<select name="" id="" class="form-control" value=""tabindex="<?php echo $tab++; ?>">
														<option selected=""> ----Select-----</option>
														<option value="Ground floor" >PO of BMCC - Bachelor of Commerce B Com-B Com-2021-2024-[MS]</option>

													</select>
												</th>
												<th width="">
													<label>Final Status</label> 
													<select name="" id="" class="form-control" value=""tabindex="<?php echo $tab++; ?>">
														<option selected=""> ----Select-----</option>
														<option value="Ground floor" >PO of BMCC - Bachlor of Commerce-B.com-2025</option>
														<option value="First Floor" >Po of BMCC Bachelor of Commerce-B.com-2024</option>
														<option value="First Floor" >Po of BMCC Bachelor of Commerce-B.com-2023</option>
														<option value="First Floor" >Po of BMCC Bachelor of Commerce-B.com-2022</option>

													</select>
												</th>
											</tr>
											<tr>
												<th>
													<label>Download</label>
													<input type="file" name="edit" class="form-control" value="">
												</th>
												<th>
													<label>.</label>
													<input type="file" name="edit" class="form-control" value="">
												</th>
											</tr>
										</table>
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
													<th class="text-white">PO NAME</th>
													<th class="text-white">Description</th>
													<th class="text-white">Graduate Attributes</th>
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
										<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
									</div>
								</form>
							</div>
						</div>
		
                    </div>

                    <div id="printForm" class="form-section card p-2" style="display: none;">
                        <h5 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Print Data </h5>
                        <div class="row">
							<div class="col-md-4 mb-3">
								<label for="courseOption1" class="form-label">Program</label>
								<select class="form-select" id="courseOption1">
									<option value="co">---Please Select</option>
								</select>
							</div>

							<div class="col-md-4 mb-3">
								<label for="courseOption2" class="form-label">Curriculum</label>
								<select class="form-select" id="courseOption2">
									<option value="co">---Please Select</option>
								</select>
							</div>

							<div class="col-md-4 mb-3">
								<label for="courseOption3" class="form-label">Course</label>
								<select class="form-select" id="courseOption3">
									<option value="co">---Please Select</option>
								</select>
							</div>
						</div>
						<button type="submit" class="btn " style="background-color: #2f4f4f;" name="save" value="">Submit </button>
						</form>
                    </div>

                    <div id="copyForm" class="form-section card p-2" style="display: none;">
                        <h5 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Copy Data </h5>
                        <div class="row">
							<div class="col-md-4 mb-3">
								<label for="courseOption1" class="form-label">Program</label>
								<select class="form-select" id="courseOption1">
									<option value="co">---Please Select</option>
								</select>
							</div>

							<div class="col-md-4 mb-3">
								<label for="courseOption2" class="form-label">Curriculum</label>
								<select class="form-select" id="courseOption2">
									<option value="co">---Please Select</option>
								</select>
							</div>

							<div class="col-md-4 mb-3">
								<label for="courseOption3" class="form-label">Course</label>
								<select class="form-select" id="courseOption3">
									<option value="co">---Please Select</option>
								</select>
							</div>
						</div>
						<button type="submit" class="btn " style="background-color: #2f4f4f;" name="save" value="">Submit </button>
                    </div>

                    <div id="deleteForm" class="form-section card p-2" style="display: none;">
                        <h5 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Delete PO </h5>
                        <div class="row">
							<div class="col-md-4 mb-3">
								<label for="courseOption1" class="form-label">Program</label>
								<select class="form-select" id="courseOption1">
									<option value="co">---Please Select</option>
								</select>
							</div>

							<div class="col-md-4 mb-3">
								<label for="courseOption2" class="form-label">Curriculum</label>
								<select class="form-select" id="courseOption2">
									<option value="co">---Please Select</option>
								</select>
							</div>

							<div class="col-md-4 mb-3">
								<label for="courseOption3" class="form-label">Course</label>
								<select class="form-select" id="courseOption3">
									<option value="co">---Please Select</option>
								</select>
							</div>
						</div>
						<button type="submit" class="btn " style="background-color: #2f4f4f;" name="save" value="">Submit </button>
                    </div>

                    <div id="guideForm" class="form-section" style="display: none;">
					<!-- Section Heading -->
					<h5 class="text-center text-white p-1" style="background-color: #2f4f4f;">Guide Me</h5>

					<!-- Guide Form Content -->
					<div class="container">
						<div class="po-container">
							<ul>
								<li><strong>PO 1:</strong> Engineering Knowledge - Apply knowledge of mathematics, science, and engineering to solve complex problems.</li>
								<li><strong>PO 2:</strong> Problem Analysis - Identify, formulate, and analyze engineering problems to reach valid conclusions.</li>
								<li><strong>PO 3:</strong> Design/Development of Solutions - Design solutions that meet societal and environmental needs.</li>
								<li><strong>PO 4:</strong> Conduct Investigations - Use research-based knowledge and methods to analyze data and provide valid conclusions.</li>
								<li><strong>PO 5:</strong> Modern Tool Usage - Apply modern engineering and IT tools for complex engineering activities.</li>
								<!-- Add more Program Outcomes as needed -->
							</ul>
						</div>
					</div>
				</div>


                    <div id="poCompetencyForm" class="form-section" style="display: none;">
                        <h5 class="text-center text-white p-1" style="background-color: #2f4f4f;">PO Competency</h5>

						<!-- PO Competency Content -->
						<div class="container">
							<div class="po-container">
								<ul>
									<li><strong>Competency 1:</strong> Ability to apply engineering principles and technical knowledge in practical scenarios to solve complex problems effectively.</li>
									<li><strong>Competency 2:</strong> Proficiency in analyzing real-world challenges and providing evidence-based solutions.</li>
									<li><strong>Competency 3:</strong> Expertise in designing and implementing innovative solutions that meet societal and environmental needs.</li>
									<li><strong>Competency 4:</strong> Strong communication and teamwork skills to lead and collaborate effectively in diverse environments.</li>
									<li><strong>Competency 5:</strong> Commitment to ethical practices, lifelong learning, and professional growth.</li>
									<!-- Add more Competencies as needed -->
								</ul>
							</div>
						</div>
                    </div>

                    <div id="competencyIndicatorsForm" class="form-section" style="display: none;">
                        <h5 class="text-center text-white p-1" style="background-color: #2f4f4f;">Competency Indicators</h5>

						<!-- Competency Indicators Content -->
						<div class="container">
							<div class="po-container">
								<ul>
									<li><strong>Indicator 1.1:</strong> Demonstrates foundational knowledge of mathematics, science, and engineering principles.</li>
									<li><strong>Indicator 1.2:</strong> Applies technical skills and tools to solve engineering problems effectively.</li>
									<li><strong>Indicator 2.1:</strong> Identifies and analyzes complex engineering problems to derive logical conclusions.</li>
									<li><strong>Indicator 2.2:</strong> Uses evidence-based approaches to evaluate alternative solutions.</li>
									<li><strong>Indicator 3.1:</strong> Designs sustainable and innovative solutions to address societal and environmental needs.</li>
									<li><strong>Indicator 4.1:</strong> Conducts experiments, collects data, and interprets results to support valid conclusions.</li>
									<li><strong>Indicator 5.1:</strong> Utilizes modern engineering tools and technology with an understanding of limitations.</li>
									<!-- Add more Competency Indicators as needed -->
								</ul>
							</div>
						</div>
                    </div>

                </div>
            </form>
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
	






























