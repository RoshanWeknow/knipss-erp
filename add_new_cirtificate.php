<?php 
include("scripts/settings.php");

require 'vendor/autoload.php';
require "scripts/pdfcrowd.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$msg = '';

if(isset($_POST['full_name']) && $_POST['full_name'] != ''){
	//print_r($_POST);
	if(isset($_POST['edit']) && $_POST['edit']!= ''){
		$sql = 'update add_new_cirtificate set 
			full_name="' . $_POST['full_name'] . '",
			email="' . $_POST['email'] . '",
			issue_date="' . $_POST['issue_date'] . '",
			edited_by="' . $_SESSION['username'] . '",
			edition_time="' . date("Y-m-d H:i:s") . '"
			where sno=' . $_POST['edit'];
		execute_query($db, $sql);
		if(mysqli_errno($db)){
			$msg .= '<li>Updation Failed</li>' ;
		}
		else{
			$msg .= '<li>Data Updated</li>' ;
		}
	}
	else{
		$sql = 'insert into add_new_cirtificate(full_name,email,issue_date,created_by,creation_time) values(
		"'.$_POST['full_name'].'", "'.
		$_POST['email'].'", "'.
		$_POST['issue_date'].'", "'.
		$_SESSION['username'].'", "'.
		date('d-m-20y').'")';
		execute_query($db, $sql);
		if(mysqli_errno($db)){
			$msg .= '<p class="text text-danger">Error # 1.6 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		else{
			$msg.= '<div class="alert alert-success"> Data Inserted </li>';
		}
	}
}

if(isset($_POST['total_cert'])){
	for($i=1;$i<=$_POST['total_cert'];$i++){
		if(isset($_POST['generate_'.$i])){
			$sql = 'insert into add_new_cirtificate(full_name,email,issue_date,created_by,creation_time) values("'.$_POST['full_name_'.$i].'", "'.$_POST['email_'.$i].'","'.$_POST['issue_date_'.$i].'", "'.$_SESSION['username'].'", "'.date('d-m-y').'")';
			execute_query($db, $sql);
			if(mysqli_errno($db)){
				$msg .= '<p class="text text-danger">Certificate Not-Generated for : '.$_POST['full_name_'.$i].'. Error # 1.6 : '.mysqli_error($db).'>> '.$sql.'</p>';
			}
			else{
				$msg.= '<div class="alert alert-success">Certificate Generated for : '.$_POST['full_name_'.$i].'</div>';
				$id = mysqli_insert_id($db);
				if(isset($_POST['generate_email_'.$i])){
					$base_url="http://".$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"].'?').'/';
					$file_link = $base_url."add_yoga_cirtificate_print.php?id=".$id;
					$html = file_get_contents($file_link);
					
					// instantiate and use the dompdf class
					$dompdf = new Dompdf();
					$dompdf->set_option('enable_remote', TRUE);

					$dompdf->set_option('enable_css_float', TRUE);
					$dompdf->set_option('enable_html5_parser', FALSE);
					$dompdf->loadHtmlFile($file_link);

					// (Optional) Setup the paper size and orientation
					//$dompdf->setPaper('A4', 'landscape');

					// Render the HTML as PDF
					$dompdf->render();

					// Output the generated PDF to Browser
					//$dompdf->stream(, array("Attachment" => true));
					$fileName = "pdf_filename_".rand(10,1000).".pdf";
					$output = $dompdf->output();
					file_put_contents("tmp/".$fileName, $output);

					
					
					// instantiate and use the dompdf class
					/*$dompdf = new Dompdf();
					//print_r($html);
					$dompdf->loadHtml($html);

					// (Optional) Setup the paper size and orientation
					$dompdf->setPaper('A4', 'landscape');

					// Render the HTML as PDF
					$dompdf->render();

					// Output the generated PDF to Browser
					$dompdf->stream();*/
					
					/*try
					{
						// create the API client instance
						$client = new \Pdfcrowd\HtmlToPdfClient("demo", "ce544b6ea52a5621fb9d55f8b542d14d");

						// run the conversion and write the result to a file
						$client->convertUrlToFile($file_link, "example.pdf");
					}
					catch(\Pdfcrowd\Error $why)
					{
						// report the error
						error_log("Pdfcrowd Error: {$why}\n");

						// rethrow or handle the exception
						throw $why;
					}*/
					
					/*$mpdf = new \Mpdf\Mpdf(); // Create new mPDF Document

					// Beginning Buffer to save PHP variables and HTML tags
					ob_start();

					$day = date('d');
					$year = date('Y');
					$month = date('F');

					echo "Hello World

					Today is $month $day, $year";

					//$html = ob_get_contents();
					ob_end_clean();
					
					//	$html  = "Hello World Today is $month $day, $year";

					// Here convert the encode for UTF-8, if you prefer 
					// the ISO-8859-1 just change for $mpdf->WriteHTML($html);
					$mpdf->WriteHTML($html);
					$content = $mpdf->Output('test.pdf', 'D');*/

					//Create an instance; passing `true` enables exceptions
					$mail = new PHPMailer(true);

					try {
						
						//Server settings
						$mail->SMTPOptions = array(
						'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
						)
						);
						//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
						$mail->isSMTP();                                            //Send using SMTP
						$mail->Host       = 'mail.weknowtech.in';                     //Set the SMTP server to send through
						$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
						$mail->Username   = 'data@weknowtech.in';                     //SMTP username
						$mail->Password   = 'Data@13579';                               //SMTP password
						$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
						$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

						//Recipients
						$mail->setFrom('ugcdknip@gmail.com', 'Mailer');
						$mail->addAddress($_POST['email_'.$i], $_POST['full_name_'.$i]);               //Name is optional
						$mail->addReplyTo('ugcdknip@gmail.com', 'Information');
						$mail->addBCC('ugcdknip@gmail.com');
						
						//Attachments
						$mail->addAttachment("tmp/".$fileName, 'Certificate');         //Add attachments

						//Content
						$mail->isHTML(true);                                  //Set email format to HTML
						$mail->Subject = 'Certificate - KNIPSS';
						$mail->Body    = "Dear ".$_POST['full_name_'.$i].", <br/>
						Please find your certificate attached with this mail.<br/>
						<br/>
						<br/>
						--<br/>
						Thanks & Regards<br/>
						Team WeKnow Technologies";
						$mail->AltBody = "Dear ".$_POST['full_name_'.$i].", \n
						Please find your certificate attached with this mail.\n
						\n
						\n
						--\n
						Thanks & Regards\n
						Team WeKnow Technologies";

						$mail->send();
						$msg .= '<div class="alert alert-info">Message has been sent</div>';
					} catch (Exception $e) {
						$msg .= '<div class="alert alert-danger">Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>';
					}
					unlink("tmp/".$fileName);
					

				}
			}
		}
	}
}

$excel_data = '';

if(isset($_POST['file_upload'])){
	$file = $_FILES['upload_file']['tmp_name'];
	$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
	$spreadsheet = $reader->load($file);
	
	$schdeules = $spreadsheet->getActiveSheet()->toArray();

	$msg .= '
	<form action="'.$_SERVER['PHP_SELF'].'" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" autocomplete="off" >
	<table class="table table-striped table-hover">
	<tr class="text-center">
	<th>S.No.</th>
	<th>Full Name</th>
	<th>E-Mail</th>
	<th>Issue Date</th>
	<th>Generate Certificate</th>
	<th>Send E-Mail</th>
	</tr>';
	$i=1;
	foreach($schdeules as $k=>$v){
		$msg .=  '<tr>
		<td>'.$i.'</td>
		<td>'.$v[0].'<input type="hidden" name="full_name_'.$i.'" value="'.$v[0].'"></td>
		<td>'.$v[1].'<input type="hidden" name="email_'.$i.'" value="'.$v[1].'"></td>
		<td>'.$v[2].'<input type="hidden" name="issue_date_'.$i.'" value="'.$v[2].'"></td>
		<td><input type="checkbox" name="generate_'.$i.'" class="form-control" checked="checked"></td>
		<td><input type="checkbox" name="generate_email_'.$i.'" class="form-control" checked="checked"></td>
		</tr>';
		$i++;
	}
	$msg .= '<tr>
	<td></td>
	<td></td>
	<td colspan="2">
		<button type="submit" class="btn btn-danger" name="confirm_generate">Confirm and Generate Certificates</button>
		<input type="hidden" name="total_cert" value="'.($i-1).'">
	</td>
	<td></td>
	<td></td></tr>
	</table>
	</form>';

}

if (isset($_GET['edit'])) {
	$sql = 'select * from add_new_cirtificate where sno=' . $_GET['edit'];
	$data = mysqli_fetch_assoc(execute_query($db,$sql));
}

if(isset($_GET['del']) and $_GET['del']!='') {
		$sql = 'delete from add_new_cirtificate where sno=' . $_GET['del'];
		$data = execute_query($db, $sql);
		if(mysqli_errno($db)){
			$msg .= '<h6 class="alert alert-danger">Deletion Failed.</h6>';
		}
		else{
			$msg .= '<h6 class="alert alert-danger">Data deleted.</h6>';			
		}
		$_GET['del'] = '';
}




page_header_start();
page_header_end();
page_sidebar();
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
				<?php echo $msg; ?>
					<h3> Add New Cirtificate</h3>
						<div class="col-md-12" >
							<!-- first row -->
							<form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" autocomplete="off" >
							<div class="row">	
								
										
								<div class=" col-md-3 ">							
									<label>Full Name</label>
									<input type="text" name="full_name" id="full_name" value="<?php  echo isset($_GET['edit'])?  $data['full_name']: ""?>" class="form-control" >
								</div>
								<div class="  col-md-3 ">							
									<label>Email</label><br>
									<input type="text" name="email" id="email" value="<?php  echo isset($_GET['edit'])?  $data['email']: ""?>" class="form-control"  >
								</div>
								<div class="  col-md-3 ">							
									<label>Issue Date</label><br>
									
									<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('issue_date', 'issue_date', true, 'DD-MM-YYYY', '<?php if(isset($_POST['issue_date'])){echo $_POST['issue_date'];}else{echo date("d-m-y"); } ?>', 2));
								</script>
								</div>
								<div class="  col-md-3 ">
									<button type="submit" class="btn btn-primary ms-4" name="save" value="">Submit </button>
								</div>
								<input type = "hidden" name = "edit" value="<?php echo isset($_GET['edit'])? $_GET['edit']: ""?>">	
							</div>
							</form>
							<form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" autocomplete="off" >
							<div class="row">
								<div class="col-3">
									<label>Upload Excel</label>
									<input type="file" name="upload_file" id="upload_file" class="form-control">
								</div>
								<div class="col-3">
									<button type="submit" class="btn btn-success" name="file_upload">Upload File and Generate Certificates</button>
								</div>
							</div>
							
						</div>
					
			</div>
		</div>
	</div>



		<div class="card card-body">
			<table  class="table table-striped table-hover rounded">
				<tr class="bg-primary text-white">
					<td>S.No.</td>
					<td>Full Name</td>
					<td> Email</td>
					<td> Issue Date</td>
					<td>Creation Time</td>
					<td>Get Certificate</td>
					<td>Edit</td>
					<td>Delete</td>
					
				</tr>
				<?php
					$serial_no = 1;
					$temp_id=1;
					//echo $_SESSION['usersno'];
					$sql = 'select * from add_new_cirtificate';
					
					$res = execute_query($db, $sql);
					if($res){
						while($row = mysqli_fetch_assoc($res)){

				?>
				<tr>
					<td><?php echo $serial_no++ ?></td>
					<td><?php echo $row['full_name'] ?></td>
					<td><?php echo $row['email'] ?></td>
					<td><?php echo $row['issue_date'] ?></td>
					<td><?php echo $row['creation_time'] ?></td>
					<td>
						<select class="certificateType" id="certificateType<?php echo $temp_id?>" onchange= "testing(<?php echo $row['sno'] ?>,<?php echo $temp_id?>)">
							<option selected >-- Certificate Type --</option>
							<option value="Yoga">Yoga</option>
							<option value="Workshop">Workshop</option>
							<option value="Training">Training</option>
							<option value="7DayWorkshop">7 Day Workshop</option>
						</select>
						<a class="certificateLink" id="certificateLink<?php echo $temp_id++?>" href="#" target="_blank"  ><span class="far fa-copy" data-toggle="tooltip" title="Certificate"></span></a>
					</td>

			<script>
    // var certificateTypeSelects = document.querySelectorAll('.certificateType');
    // var certificateLinks = document.querySelectorAll('.certificateLink');

    // certificateTypeSelects.forEach(function (certificateTypeSelect, index) {
        // certificateTypeSelect.addEventListener('change', function () {
            // var selectedValue = certificateTypeSelect.value;

            // if (selectedValue === 'Yoga') {
                // certificateLinks[index].href = 'add_yoga_cirtificate_print.php?id=<?php echo $row['sno'] ?>';
                // certificateLinks[index].style.color = 'green';
            // } else if (selectedValue === 'Workshop') {
                // certificateLinks[index].href = 'workshop_certificate_print.php?id=<?php echo $row['sno'] ?>';
                // certificateLinks[index].style.color = 'blue';
            // }
        // });
    // });
	function testing(id,temp_id){
		let certificateTypeSelects = document.getElementById('certificateType'+temp_id).value;
		console.log(certificateTypeSelects);
		console.log(temp_id);
		console.log(id);
		if(certificateTypeSelects =='Yoga'){
			document.getElementById('certificateLink'+temp_id).href = 'add_yoga_cirtificate_print.php?id='+id;
			document.getElementById('certificateLink'+temp_id).style.color = 'green';
		}
		else if(certificateTypeSelects =='Workshop'){
			document.getElementById('certificateLink'+temp_id).href = 'workshop_certificate_print.php?id='+id;
			document.getElementById('certificateLink'+temp_id).style.color = 'blue';
		}
		else if(certificateTypeSelects =='Training'){
			document.getElementById('certificateLink'+temp_id).href = 'training_certificate_print.php?id='+id;
			document.getElementById('certificateLink'+temp_id).style.color = 'blue';
		}
		else if(certificateTypeSelects =='7DayWorkshop'){
			document.getElementById('certificateLink'+temp_id).href = 'certificate_7_day_workshop.php?id='+id;
			document.getElementById('certificateLink'+temp_id).style.color = 'blue';
		}
		
		// if (selectedValue === 'Yoga') {
                // certificateLinks[index].href = 'add_yoga_cirtificate_print.php?id='id;
                // certificateLinks[index].style.color = 'green';
            // } else if (selectedValue === 'Workshop') {
                // certificateLinks[index].href = 'workshop_certificate_print.php?id='id;
                // certificateLinks[index].style.color = 'blue';
            // }
	};
</script>


					
				<!--------
					<td>
						<select>
							<option>Yoga<a href="add_yoga_cirtificate_print.php?id=<?php echo $row['sno'] ?>" target="_blank" style="color:green" alt="Certificate"><span class="far fa-copy" data-toggle="tooltip" title="Certificate"></span></a></option>
							<option>Workshop <a href="workshop_certificate_print.php?id=<?php echo $row['sno'] ?>" target="_blank" style="color:blue" alt="Certificate"><span class="far fa-copy" data-toggle="tooltip" title="Certificate"></span></a></option>
						</select>
					</td>
					<td><a href="add_yoga_cirtificate_print.php?id=<?php echo $row['sno'] ?>" target="_blank" style="color:green" alt="Certificate"><span class="far fa-copy" data-toggle="tooltip" title="Certificate"></span></a>
					<a href="workshop_certificate_print.php?id=<?php echo $row['sno'] ?>" target="_blank" style="color:blue" alt="Certificate"><span class="far fa-copy" data-toggle="tooltip" title="Certificate"></span></a></td> ---->
					<td><a href="<?php echo $_SERVER['PHP_SELF'] . '?edit=' . $row['sno']; ?>" alt="Edit" data-toggle="tooltip" title="Edit"><span class="far fa-edit" aria-hidden="true"></span></a></td>
					<td><a href="<?php echo $_SERVER['PHP_SELF'] . '?del=' . $row['sno']; ?>" onclick="return confirm('Are you sure?');" style="color:#f00" alt="Delete"><span class="far fa-trash-alt" aria-hidden="true" data-toggle="tooltip" title="Delete"></span></a></td>

				</tr>
				
				<?php 
					}
						
				}
				
				?>
			</table>	
		</div>
<?php
page_footer_start();
page_footer_end();
?>