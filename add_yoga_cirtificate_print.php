<?php 
include("scripts/settings.php");

if(isset($_GET['id'])){
	$sql = 'select * from add_new_cirtificate where sno=' . $_GET['id'];
	$row = mysqli_fetch_assoc(execute_query($db,$sql));

	// echo $row;
	
}
?>
<script>
function printPage() {
  window.print();
}
</script>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Yoga Certificate</title>
    <!-- google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=PT+Serif&display=swap"
      rel="stylesheet"
    />
    <!-- css -->
    <link rel="stylesheet" href="css1/yoga_certificate.css" />
  </head>
  <body>
	</br>
	<div class="controls-container no-print">
		<button onclick="printPage()">Print</button>
	</div>
    <div class="wrap" src="image/temp1.png" alt="bgimage">
      <span class="clg_name"
        >Kamla Nehru Institute of Physical and Social Sciences, Sultanpur</span
      >
      <span class="naac"> Accredited by NAAC 'A' Grade </span>

      <img class="logo" src="image/logo.png" />

      <span class="autono"> An Autonomous Institute</span>
      <span class="certificate">E-Certificate</span>
      <span class="yoga">Yoga Training Session</span>
      <span class="recog">of Recognition</span>
      <span class="this">This certificate is awarded to Dr./Mr./Ms.</span>
      <span class="name"><?php echo $row['full_name']; ?></span>
      <span class="for">for attending the Yogic Practices Session on the</span>
      <span class="occasion">Occasion of International Yoga Day</span>
      <span class="date"><?php echo $row['issue_date']; ?>.</span>
      <span class="firstSig">Prof. Praveen Kumar Singh</span>
	  
	  <span class="first-sig-span"><img class="firstSig-sig-img" src="image/praveen_sir_sign.png" alt="Praveen-sir-sign"></span>
	  	   
	  
      <span class="firstSig_degis">Director,IQAC/HOD, Physical Education</span>
	  
      <span class="secondSig">Prof. Alok Kumar Singh</span>
	  
<span class="second-sig-span"><img class="secondSig-sig-img" src="image/alok_sir_sign.png" alt="Alok-sir-sign"></span>
	  
      <span class="secondSig_degis">Principal</span>
      <hr class="hr1" />
      <hr class="hr2" />
    </div>
  </body>
</html>
