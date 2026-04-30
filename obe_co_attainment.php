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
                <h3>CO ATTAINMENT</h3>
            </div>

            <!-- Button Group -->
            <div class="btn-group d-flex justify-content-center my-3" role="group" aria-label="First group">
                <button type="button" class="btn btn-outline-primary" onclick="showForm('poForm')">Define Co target</button>
                <button type="button" class="btn btn-outline-success" onclick="showForm('printForm')">Exam Wise Attainment Process</button>
                <button type="button" class="btn btn-outline-info" onclick="showForm('copyForm')">Course Wise Attainment Process</button>
                <button type="button" class="btn btn-outline-danger" onclick="showForm('deleteForm')">Gap Analysis</button>
                <button type="button" class="btn btn-outline-warning" onclick="showForm('guideForm')">Guide Me</button>
                <button type="button" class="btn btn-outline-secondary" onclick="showForm('poCompetencyForm')">Calculate Target</button>
            </div>

            <!-- Forms to Display -->
            <div id="poForm" class="form-section card p-2" style="display: none;  padding: 20px;">
                <h5 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Define Co target</h5>
				
                <!-- Your form content goes here -->
                <form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"
                    enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
                    <div class="col-md-12">
					<div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="courseOption1" class="form-label">Session Name</label>
                        <select class="form-select" id="courseOption1">
                            <option value="co">---Please Select</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="courseOption3" class="form-label">Course Name</label>
                        <select class="form-select" id="courseOption3">
                            <option value="co">---Please Select</option>
                        </select>
                    </div>
					<div class="col-md-1 mb-3">
                        <label >Status</label>
						<input type="checkbox" class="form-control">
                    </div>
					<div class="col-md-3 mb-3">
                        <label >.</label>
						<p>Check If Active</p>
                    </div>
                </div>
                       
                        <button type="submit" class="btn " style="background-color: #2f4f4f;" name="save" value="">Submit </button>
                        <button type="submit" class="btn btn-danger " name="save" value="">Cancel </button>
						<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
                    </div>
            </div>

            <div id="printForm" class="form-section card p-2" style="display: none;  padding: 20px;">
                <h5 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Exam Wise Attainment Process</h5>
                <!-- Your form content goes here -->
                <form>
                    <div class="row">
							<div class="col-md-4 mb-3">
								<label for="courseOption1" class="form-label"> Session Name</label>
								<select class="form-select" id="courseOption1">
									<option value="co">---Please Select</option>
								</select>
							</div>

							<div class="col-md-4 mb-3">
								<label for="courseOption2" class="form-label">Course Name</label>
								<select class="form-select" id="courseOption2">
									<option value="co">---Please Select</option>
								</select>
							</div>

							<div class="col-md-4 mb-3">
								<label for="courseOption3" class="form-label">Exam Name</label>
								<select class="form-select" id="courseOption3">
									<option value="co">---Please Select</option>
								</select>
							</div>
						</div>
						
						<button type="submit" class="btn btn-primary " name="save" value="">CO Attainment Process </button>
						<button type="submit" class="btn btn-warning " name="save" value="">Co Attainment Report </button>
						<button type="submit" class="btn btn-danger " name="save" value="">Cancel </button>
                </form>
            </div>

            <div id="copyForm" class="form-section card p-2" style="display: none;  padding: 20px;">
						<div class="card-header text-center bg-secondary text-white">
							<h2>Course Wise Attainment Process</h2>
						</div>
						<div class="row pt-2">
							<div class="col-md-4 mb-3">
								<label for="courseOption1" class="form-label"> Session Name</label>
								<select class="form-select" id="courseOption1">
									<option value="co">---Please Select</option>
								</select>
							</div>

							<div class="col-md-4 mb-3">
								<label for="courseOption2" class="form-label">Course Name</label>
								<select class="form-select" id="courseOption2">
									<option value="co">---Please Select</option>
								</select>
							</div>
						</div>
						
						<button type="submit" class="btn btn-primary " name="save" value="">CO Attainment Process </button>
						<button type="submit" class="btn btn-warning " name="save" value=""> Report </button>
						<button type="submit" class="btn btn-danger " name="save" value="">Cancel </button>
					
            </div>

            <div id="deleteForm" class="form-section" style="display: none;  ">
								<h3 class="card-header text-center bg-secondary text-white">Gap Analysis</h3>
						<div class="row">
							<div class="col-md-4 mb-3">
								<label for="courseOption1" class="form-label"> Session Name</label>
								<select class="form-select" id="courseOption1">
									<option value="co">---Please Select</option>
								</select>
							</div>

							<div class="col-md-4 mb-3">
								<label for="courseOption2" class="form-label">Course Name</label>
								<select class="form-select" id="courseOption2">
									<option value="co">---Please Select</option>
								</select>
							</div>
						</div>
						
						<button type="submit" class="btn " style="background-color: #2f4f4f;" name="save" value="">Submit </button>
						<button type="submit" class="btn btn-danger " name="save" value="">Cancel </button>
					
            </div>

            <div id="guideForm" class="form-section" style="display: none; padding: 20px;">
                <div class="container">
    <div class="card">
        <div class="card-header text-center bg-secondary text-white">
            <h3>CO Attainment (Course Outcome Attainment) in Outcome-Based Education (OBE)</h3>
        </div>
        <div class="card-body">
            <section>
                <h3 class=" text-center text-white p-1" style="background-color: #2f4f4f;">What is CO Attainment?</h3>
                <p>CO Attainment refers to the process of measuring how effectively the course outcomes (COs) have been achieved by the students by the end of the course. In Outcome-Based Education (OBE), the main goal is to ensure that students have learned the desired skills, knowledge, and attributes. CO Attainment helps evaluate the effectiveness of the course design, teaching strategies, and assessment methods.</p>
            </section>

            <section>
                <h3 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Importance of CO Attainment</h3>
                <p>CO Attainment is important because it helps the educational institution track how well students are performing with respect to the specific learning outcomes. It ensures the following:</p>
                <ul>
                    <li>Ensures that the course objectives align with the overall program goals.</li>
                    <li>Helps in continuous improvement of the curriculum based on student performance.</li>
                    <li>Provides data for academic audits and accreditation processes.</li>
                    <li>Helps in identifying areas where students might be struggling, allowing instructors to adjust teaching methods.</li>
                </ul>
            </section>

            <section>
                <h3 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Methods for Measuring CO Attainment</h3>
                <p>There are various ways in which CO Attainment can be measured, depending on the course and its specific outcomes:</p>
                <ul>
                    <li><strong>Direct Assessment:</strong> Direct assessment methods include exams, quizzes, assignments, practicals, projects, presentations, and other forms of evaluation that directly assess the achievement of course outcomes.</li>
                    <li><strong>Indirect Assessment:</strong> Indirect assessment methods include surveys, interviews, self-assessments, and feedback from students regarding how they perceive their learning and attainment of course outcomes.</li>
                    <li><strong>Rubrics and Marking Schemes:</strong> Using rubrics to evaluate student work based on a scale can help objectively measure how well the student has achieved a particular course outcome.</li>
                    <li><strong>Course Evaluation:</strong> At the end of the course, student evaluation surveys or feedback forms can provide insights into how effectively the course outcomes were met.</li>
                </ul>
            </section>

            <section>
                <h3 class=" text-center text-white p-1" style="background-color: #2f4f4f;">CO Attainment Levels</h3>
                <p>CO attainment levels are used to quantify how well students have met the expected outcomes. These levels may vary but typically follow a scale:</p>
                <ul>
                    <li><strong>Level 1 (Low Attainment):</strong> Minimal achievement of the course outcomes. Students demonstrate limited understanding or application of the concepts.</li>
                    <li><strong>Level 2 (Moderate Attainment):</strong> Adequate achievement of the course outcomes. Students demonstrate a basic understanding but need further development.</li>
                    <li><strong>Level 3 (High Attainment):</strong> Strong achievement of the course outcomes. Students can apply the knowledge effectively and demonstrate a deep understanding.</li>
                </ul>
            </section>

            <section>
                <h3 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Steps for CO Attainment Process</h3>
                <p>The process of CO Attainment generally follows these steps:</p>
                <ol>
                    <li><strong>Define Course Outcomes:</strong> Clearly define the Course Outcomes (COs) based on the program objectives and the subject matter.</li>
                    <li><strong>Align Assessments with COs:</strong> Design assignments, tests, and other forms of evaluation to measure students' ability to meet the defined COs.</li>
                    <li><strong>Collect Data:</strong> Gather data on students' performance from different assessments and evaluations throughout the course.</li>
                    <li><strong>Analyze Data:</strong> Analyze the collected data to evaluate the attainment levels for each CO.</li>
                    <li><strong>Report Findings:</strong> Present the findings of CO attainment, highlighting areas of success and areas for improvement.</li>
                    <li><strong>Continuous Improvement:</strong> Use the findings to improve the course design, teaching methods, and assessments for future iterations of the course.</li>
                </ol>
            </section>

            <section>
                <h3 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Example of CO Attainment Report</h3>
                <p>Here is an example of a CO Attainment Report for a course:</p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Course Outcome (CO)</th>
                            <th>Assessment Method</th>
                            <th>Attainment Level</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>CO1: Understand basic programming concepts</td>
                            <td>Midterm Exam, Assignment 1</td>
                            <td>Level 2</td>
                            <td>Need further reinforcement of basic concepts</td>
                        </tr>
                        <tr>
                            <td>CO2: Apply algorithms in solving problems</td>
                            <td>Project, Final Exam</td>
                            <td>Level 3</td>
                            <td>Students demonstrated a strong grasp of algorithms</td>
                        </tr>
                        <tr>
                            <td>CO3: Develop real-world applications</td>
                            <td>Project, Presentation</td>
                            <td>Level 2</td>
                            <td>Moderate achievement, additional practical experience required</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section>
                <h3 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Conclusion</h3>
                <p>CO Attainment is a crucial part of the Outcome-Based Education (OBE) framework. By measuring and tracking the attainment of course outcomes, educational institutions can ensure that students are gaining the necessary skills and knowledge. This process also allows for continuous improvement, ensuring that the curriculum remains effective and aligned with the evolving needs of the industry and society.</p>
            </section>
        </div>
    </div>
</div>
            </div>

            <div id="poCompetencyForm" class="form-section" style="display: none;  padding: 20px;">
               
							<h5 class=" text-center text-white p-1" style="background-color: #2f4f4f;">Calculate Target</h5>
				<div class="row">
					<div class="col-md-4 mb-3">
						<input type="text" placeholder="Enter Details" id="documentUpload" class="form-control mb-3">
					</div>
				</div>
				<button type="submit" class="btn " style="background-color: #2f4f4f;" name="save" value="">Submit </button>

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
