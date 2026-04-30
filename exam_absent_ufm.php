<?php

include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
$msg='';    


page_header_start();
?>

<script type="text/javascript" language="javascript">
function changeid(id){
	var elem='';
	elem = 'show_'+id;
	check = 'check_'+id;
	if(document.getElementById(check).checked== true){			
		document.getElementById(elem).style.display = 'block';
	}
	else {
		document.getElementById(elem).style.display = 'none';
	}
}
	

	
</script>

<?php
page_header_end();
page_sidebar();

?>


<body id="public">
	<div id="wrapper">	
		<div id="content" class="card card-body ">    
        	<div id="container" class="row d-flex my-auto">    	
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" enctype="multipart/form-data" method="post"  >
					<h2><img style="width:40px;" src="images/add.png" />UFM / Absent  <span class="orange"></span></h2>
					<?php echo $msg;?>
					<div class="row">
                        
						<div class="col-md-4">							
							<label>Date of Examination</label>
							<?php 
								$currentDate = date("Y-m-d");
								$selectDateSql = "SELECT * FROM exam_examination_scheme WHERE date <= '$currentDate' GROUP BY date ORDER BY date";
								$selectDateRes = mysqli_query($db, $selectDateSql);
							?>
							<select name="dateOfExam" id="dateOfExam" class="form-control" required>
								<option selected disabled>---Select Dates---</option>
								<?php
								while ($selectDateRow = mysqli_fetch_assoc($selectDateRes)) {
									$modifieddate = date("d-m-Y", strtotime($selectDateRow['date']));
								?>
									<option value="<?php echo $selectDateRow['date']; ?>"><?php echo $modifieddate; ?></option>
								<?php
								}
								?>
							</select>
							

						</div>

						<div class="col-md-12">							
							<label>Examination Subject Details</label>
							<div name="examSub" id="examSub">
								
							</div>
						</div>
						
					</div>

				</form>
			</div>
			<script>

				
                

               
$(document).ready(function () {
    $('#examSub').empty();

    // Generate HTML content for an empty table
    var emptyTable = '<table class="table table-striped table-hover " style="color:black;">';
    emptyTable += '<thead><tr class="bg-primary"><th>Serial No</th><th>Course</th><th>Subject</th><th>Paper Code</th><th>Paper Title</th><th>Subject Type</th><th>Time</th><th>Shift</th><th>Students Count</th><th>Absent</th><th>UFM</th><th>Print</th></tr></thead>';
    emptyTable += '<tbody></tbody></table>';

    // Append the empty table to the exam div
    $('#examSub').html(emptyTable);

    // Event listener for the date select box
    $('#dateOfExam').on('change', function () {
        var selectedDate = $(this).val();
        console.log(selectedDate);

        // Clear the current content in the exam table body
        $('#examSub tbody').empty();

        if (selectedDate !== '') {
            // Fetch exams and counts based on the selected date
            $.ajax({
                url: 'exam_get_ufm_absent_content.php',
                type: 'POST',
                data: { selectedDate: selectedDate },
                dataType: 'json',
                success: function (data) {
                    // Check if there are subjects to display
                    if (Object.keys(data).length > 0) {
                        // Initialize serial number
                        var serialNumber = 1;

                        // Iterate over each exam with a delay
                        for (var key in data) {
                            if (data.hasOwnProperty(key)) {
                                var value = data[key];
                                
                                // Generate HTML content for the current row
                                var content = '<tr>';
                                content += '<th>' + serialNumber++ + '</th>'; // Serial Number
                                content += '<td>' + value.class + '</td>';
                                content += '<td>' + value.subject + '</td>';
                                content += '<td>' + value.paper_code + '</td>';
                                content += '<td>' + value.paper_title + '</td>';
                                content += '<td>' + value.subject_type + '</td>';
                                content += '<td>' + value.time + '</td>';
                                content += '<td>' + value.shift + '</td>';
                                content += '<td>' + value.count + '</td>'; // Access count as part of the value object
                                content += '<td><a class="Btn btn-warning btn-sm" href="exam_absent_ufm_form.php?a_u=1&cc=' + value.classsno + '&pc=' + value.paper_code + '" target="_blank" >ABSENT</a></td>';
                                content += '<td><a class="Btn btn-danger btn-sm" href="exam_absent_ufm_form.php?a_u=0&cc=' + value.classsno + '&pc=' + value.paper_code + '" target="_blank">UFM</a></td>';
                                content += '<td><form action="exam_print_ufm_absent_report.php" class="wufoo leftLabel page1" enctype="multipart/form-data" method="post"  target="_blank"><button type="submit" class="Btn btn-success btn-sm">Print</button><input type="hidden" name="paper" value="'+value.paper_code+'"><input type="hidden" name="class_name" value="'+value.class+'"><input type="hidden" name="classsno" value="'+value.classsno+'"></form></td>';
                                content += '</tr>';

                                // Append the generated content to the exam table body
                                $('#examSub tbody').append(content);
                            }
                        }
                    }
                }
            });
        }
    });
});






				
			</script>
		</div>
	</div>

	<?php
	page_footer_start();
	page_footer_end();
	?>




</body>