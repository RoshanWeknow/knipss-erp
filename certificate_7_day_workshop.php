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
<html>
<head>
    <style>
        html{
            font-family:arial;
        }
        body{
            display:flex;
            justify-content:center;
            align-items:center;
            background:skyblue;
        }
      /*setting the position relative property to the main container*/
        .gfg {
            margin: 3%;
            position: relative;
        }
/*position absolute property will place the text according to the main .gfg div*/
        
        .absolute{
            position: absolute;
        }
       
        .first-pos {
            top: 170px;
            left: 220px;
            font-weight:600;
            font-size:1.3rem;
        }
        
        .sec-pos {
            top: 210px;
            left: 220px;
            font-size:1.3rem;
        }
        .third-pos{
            top:380px;
            left:133px;

        }
        .four-pos{
			width:100%;
            top: 318px;
            font-size:1.15rem;
            letter-spacing: -0.3px;
            text-align:left;
            margin-left:230px;
            line-height:1.2rem;
        }
        
        .name{
            font-weight:bold;
        }
        .cross{
            text-decoration:solid black 1px line-through;
        }
        .red{
            color:red;
        }
        .big{
            font-size: 1.8rem;
            font-weight:bold;
        }
		@media print {
			body{
				
			background-color:white;
			}
			button{
				display:none;
			}
			
		}
		
    </style>

</head>
 
<body>
	
  <!-- div holding the image, the first text and the second text-->

    <div class="gfg" >
	
        <img src= "certificate/workshop.jpg" alt="Certificate Template" style="width:720px;">
        

        <div class="absolute four-pos">
            

            <span class="name" ><?php echo $row['full_name']; ?></span> 
            <span class="name" style="margin-left:125px; font-size:14px;"><i><?php echo $row['course']; ?></i></span> 
        </div>
		<div class="absolute third-pos">
         <img class="secondSig-sig-img" src="image/alok_sir_sign.png" alt="Alok-sir-sign"  style="width:50px; padding-bottom:15px;">   
		<img class="firstSig-sig-img" src="image/praveen_sir_sign.png" alt="Praveen-sir-sign" style="width:90px; padding-left:130px;padding-bottom:20px;">
		<img class="thirdSig-sig-img" src="image/radhe_shyam_sir.png" alt="radhe_shyam_sir-sign" width="65px;" style=" padding-left:100px;padding-bottom:25px;">
		
			<!--<span class="serial_no" ><?php   $row['sno']; ?></span> -->
        </div>
	  <div class="controls-container no-print">
			<button onclick="printPage()">Print</button>
		</div>
	


    </div>
    
</body>
 
</html>
