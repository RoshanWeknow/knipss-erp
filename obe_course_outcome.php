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
                <h3>COURSE OUTCOME</h3>
            </div>

            <!-- Button Group -->
            <div class="btn-group d-flex justify-content-center my-3" role="group" aria-label="First group">
                <button type="button" class="btn btn-outline-primary" onclick="showForm('poForm')">CO</button>
                <button type="button" class="btn btn-outline-success" onclick="showForm('printForm')">Document Upload</button>
                <button type="button" class="btn btn-outline-info" onclick="showForm('copyForm')">History</button>
                <button type="button" class="btn btn-outline-danger" onclick="showForm('deleteForm')">Print Data</button>
                <button type="button" class="btn btn-outline-warning" onclick="showForm('guideForm')">Delete CO</button>
                <button type="button" class="btn btn-outline-secondary" onclick="showForm('poCompetencyForm')">Guide Me</button>
                <button type="button" class="btn btn-outline-dark" onclick="showForm('copyco')">Copy CO</button>
                <button type="button" class="btn btn-outline-dark" onclick="showForm('colibrary')">CO Library</button>
            </div>

            <!-- Forms to Display -->
            <div id="poForm" class="form-section card p-3" style="display: none; background-color: #f4f4f4; padding: 20px;">
                <h5 class=" text-center text-white p-1" style="background-color: #2f4f4f;">CO Form</h5>
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

                        <!-- first row -->
						<table width="100%" class="table table-striped table-hover rounded">
							
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
									<th class="text-white">CO NAME</th>
									<th class="text-white">CO Description</th>
									<th class="text-white">Bloom's  Associated Lavel</th>
									<th class="text-white">KNowledge Lavel</th>
									<th class="text-white">Action</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input name="amenities[]" class="form-control"></td>
									<td><input name="description[]" class="form-control"></td>
									<td><input name="graduate_attributes[]" class="form-control"></td>
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
            </div>

            <div id="printForm" class="form-section card p-2" style="display: none; background-color: #e9ecef; padding: 20px;">
                <h5 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Document Upload</h5>
				<div class="row">
					<div class="col-md-4 mb-3">
						<input type="file" id="documentUpload" class="form-control mb-3">
					</div>
				</div>
				<button type="submit" class="btn " style="background-color: #2f4f4f;" name="save" value="">Submit </button>
            </div>

            <div id="copyForm" class="form-section" style="display: none;">
                <div class="container ">
					<div class="card">
						<h5 class=" text-center text-white p-1" style="background-color: #2f4f4f;">History of Course Outcomes (CO)</h5>
						<div class="card-body">
							<section>
								<h3 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Introduction</h3>
								<p>Course Outcomes (COs) are statements that define what students should be able to do by the end of a course. These outcomes are measurable and observable, ensuring that students acquire necessary knowledge, skills, and attributes to succeed in their field of study.</p>
							</section>

							<section>
								<h3 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Origins and Evolution</h3>
								<p>The concept of Course Outcomes can be traced back to the development of outcome-based education (OBE) in the 1990s. OBE focused on setting specific goals for learning and ensuring that students' learning achievements were measurable. Course outcomes were adopted as a way to specify these goals clearly and allow educators to assess whether students met the desired educational standards.</p>
							</section>

							<section>
								<h3 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Structure of Course Outcomes</h3>
								<p>CO statements typically include four main components:</p>
								<ul>
									<li><strong>Action:</strong> Describes the activity or task the learner should perform (e.g., analyze, design, evaluate).</li>
									<li><strong>Knowledge:</strong> Specifies the subject matter or content the learner should understand (e.g., mathematics, engineering principles, history).</li>
									<li><strong>Condition:</strong> Specifies the context under which the learner should perform the action (optional).</li>
									<li><strong>Criteria:</strong> Defines the acceptable level or standard for performing the action (optional).</li>
								</ul>
							</section>

							<section>
								<h3 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Importance of Course Outcomes</h3>
								<p>Course Outcomes are essential for guiding students' learning journeys, ensuring consistency in teaching and assessment, and making it clear to students and educators alike what is expected. They also provide a clear framework for evaluating the effectiveness of a course.</p>
							</section>

							<section>
								<h3 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Recent Trends</h3>
								<p>In recent years, educational institutions have increasingly aligned their course outcomes with accreditation standards and industry requirements. The adoption of Course Outcomes is seen in both traditional universities and online education platforms, as it helps maintain the quality and relevance of education.</p>
							</section>
						</div>
					</div>
				</div>
            </div>

            <div id="deleteForm" class="form-section" style="display: none; ">
                <h5 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Print Data</h5>
				<div class="row">
					<div class="col-md-4 mb-3">
						<input type="text" placeholder="Enter Details" id="documentUpload" class="form-control mb-3">
					</div>
				</div>
				<button type="submit" class="btn " style="background-color: #2f4f4f;" name="save" value="">Submit </button>
            </div>

            <div id="guideForm" class="form-section" style="display: none; ">
                <h5 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Delete CO</h5>
				<div class="row">
					<div class="col-md-4 mb-3">
						<input type="text" placeholder="Enter Details" id="documentUpload" class="form-control mb-3">
					</div>
				</div>
				<button type="submit" class="btn " style="background-color: #2f4f4f;" name="save" value="">Submit </button>
            </div>

            <div id="poCompetencyForm" class="form-section" style="display: none; background-color: #d1ecf1; padding: 20px;">
                <!-- Your form content goes here -->
                <div class="container">
					<div class="card">
							<h2 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Guide Me (CO)</h2>
						<div class="card-body">
							<p><strong>Course Outcomes (COs)</strong> are what the student should be able to do at the end of a course. It is an effective ability, including attributes, skills, and knowledge to successfully carry out the identified activity. The most important aspect of a CO is that it should be observable and measurable.</p>
							
							<h4 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Structure of a CO Statement</h4>
							<ul>
								<li><strong>Action:</strong> Represents a cognitive, affective, or psychomotor activity the learner should perform. An action is indicated by an action verb, occasionally two representing the concerned cognitive process(es).</li>
								<li><strong>Knowledge:</strong> Represents the specific knowledge from any one or more of the eight knowledge categories.</li>
								<li><strong>Condition:</strong> Represents the process the learner is expected to follow or the condition under which to perform the action. (This is an optional element of CO).</li>
								<li><strong>Criteria:</strong> Represents the parameters that characterize the acceptability levels of performing the action. (This is an optional element of CO).</li>
							</ul>

							<h4 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Example of a Course Outcome</h4>
							<p><strong>CO Example:</strong> "By the end of the course, the student will be able to analyze and interpret data using statistical methods, with an accuracy of at least 95% in data analysis results."</p>
							<p><strong>Explanation:</strong> 
								<ul>
									<li><strong>Action:</strong> Analyze and interpret data</li>
									<li><strong>Knowledge:</strong> Statistical methods</li>
									<li><strong>Condition:</strong> The student will use the provided datasets</li>
									<li><strong>Criteria:</strong> Accuracy of at least 95% in data analysis results</li>
								</ul>
							</p>
						</div>
					</div>
				</div>
            </div>

            <div id="copyco" class="form-section card p-2" style="display: none; ">
                <h5 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Copy CO</h5>
                <!-- Your form content goes here -->
                <form>
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
			 <div id="colibrary" class="form-section card p-2" style="display: none;  padding: 20px;">
                <h5 class=" text-center text-white p-1" style="background-color: #2f4f4f;">CO Library</h5>
				<div class="row">
					<div class="col-md-4 mb-3">
						<input type="text" placeholder="Enter Details" id="documentUpload" class="form-control mb-3">
					</div>
				</div>
				<button type="submit" class="btn " style="background-color: #2f4f4f;" name="save" value="">Submit </button>
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
