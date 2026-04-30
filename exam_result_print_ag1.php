<?php 
include("scripts/settings.php");
$msg='';


	
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    
    <!-- Bootstrap CSS -->
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous"
    />
    
    <title>Result</title>

    <!-- css  -->
    <style>
      body {
        font-family: "Roboto", sans-serif;
        font-size: .8rem;
		margin:5px!important;
        /* line-height: 0.9; */
      }
      h1{
        font-size: 1.8rem !important;
      }
      h2{
        font-size: 1.5rem !important;
      }
      h3{
        font-size: 1.3rem !important;
      }
      h4{
        font-size: 1rem !important;
      }
      p{
        font-size: .8rem !important;
      }
      td{
        font-size: .8rem !important;
      }
      th{
        font-size: .8rem !important;
      }
		@media print {
			
			td{
				font-size: 12px!important;
				padding: 2px!important;
				}
			th{
				
				font-size: 12px!important;
				padding: 2px!important;
			}
			.watermark {
				color: #ececec; 
				opacity: 0.5 !important;
				top: 30% !important;
				left: 10% !important;
				font-size: 3rem; 
			  }
			  table td{
			border:1px solid black!important;
			}
			.abc{
				border:1px solid black!important;
			}
			

			.marksheet-container {
				width: 100%;
				height: 100%;
				margin: 15px;
				 /* Ensure each container starts on a new page */
			}
			  #printButton {
				display: none;
			 }
			 #overlays1{
			width:60%!important;
			margin-bottom:!important;
			filter:grayscale(100%);
			margin-top:20px!important;
			}
			.pp{
			padding-top:20px!important;
			}
			 
			  
			
		}
		
		.look{
			padding:3px!important;
			margin:0px!important;
			font-size:11px;
		}
			
		
	  
		@page{
        size: A4;
        margin:10px;
        margin-right:25px!important;
		}
		.watermark {
		  position: absolute;
		  top: 50%;
		  left: 20%;
		  opacity: 0.8;
		  z-index: -100;
		  color: #aeabab ;
		  font-size: 6.1rem;
		  transform: rotate(-45deg);
		  font-weight: normal;
		  user-select: none;
		}
		

		.merge_column1 {
			position: absolute;
			top: 2%;
			left: 50%;
			-ms-transform: translate(-50%, -50%);
			transform: translate(-50%, -50%);
			background-color: white;
			padding-top: 0.1rem; padding-inline:0.1rem;
			/*padding-left : 20px;
			padding-right : 20px;*/
		}
		.look{
			padding-left:10px!important;
		}
		table td{
			border:1px solid black;
		}
		.abc{
			border:1px solid black;
		}
		#overlays1{
			width:40%;
			margin-top:200px;
			margin-right:50px!important;
			filter:grayscale(100%);
			
		}
	
		#main{
			margin:10px!important;
			padding:5px;
		}
		
    </style>
    <!-- <link rel="stylesheet" href="style.css" media="print"> -->
    <!-- googlefont -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,700&display=swap"
      rel="stylesheet"
    />
	<script>
		function printAndRemoveButton() {
		  // Trigger the print action
		  window.print();

		  // Remove the print button
		  var printButton = document.getElementById('printButton');
		  printButton.parentNode.removeChild(printButton);
		}
    </script>
  </head>

  <body class="w-100 m-auto" id="main">
	<div style="text-align:center">
		<button id="printButton" onclick="printAndRemoveButton()" class=" btn btn-danger btn-sm text-center" >Print</button>
	</div>

   <!-- <div class="" style="display:flex ; justify-content: center ;">
      <button class="btn btn-secondary btn-print" style="width: 5%;" onclick="print()">Print</button>
    </div>-->
	<img src="images/kni_logo.png"  id="overlays" style=" z-index:-2;opacity:0.0;position: absolute;top: 50%;left: 50%;-ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%); width:30%;" alt="overlay image" >
	 <img src="images/logo_bg.png"  id="overlays1" style=" z-index:0;opacity:0.15;position: absolute;top: 40%;left: 50%;-ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%); width:30%; " alt="overlay image" >
    <div  style="">
        <div class="container-fluid">
			
            <table width="100%" style="margin:0px;">
			<div class="watermark">Internet Copy</div>
			<tr>
				<th width="12%" rowspan="2"><img style="padding:15px; height:65px; width:65px; " src="images/kni_logo.png" alt="logo" class="img-fluid d-block m-auto" /> </th>
				<th width="88%">
					<h4 class="" style="text-align: center; margin:0px; " ><span style="font-size:17px;white-space:nowrap;" class="head-name"><b>Kamla Nehru Institute Of Physical & Social Sciences,Sultanpur, Uttar Pradesh</b></span> <br>An Autonomous Institute And Accredited "A" Grade by NAAC<br><span style="font-size:14px;">(Affiliated to Dr. Rammanohar Lohia Avadh University, Ayodhya U.P.)</span></h4>
				</th>
			</tr>
		</table>
            <table class="table table-borderless" width="100%">
				<tr>
					<th class="text-center" colspan="5"><span style="font-size:12px;">PROVISIONAL MARKSHEET<br>2023-2024</span></th>
				</tr>
                <tr>
					<th  class="look">Name </th>
					<th width="25%" class="look">:	ANHAY RAJ	</th >
					<th  class="look">Roll NO.</th>
					<th width="25%" class="look">: 23020010157</th >
					<th width="20%" rowspan="5">
					<?php
						// if(fileExists("PHOTO/".$row['photo_id'])){
							// $photo = fileExists("PHOTO/".$row['photo_id']);
						// }
						// else{
							// $photo = $row['photo_id'];
						// }
					?>
					<?php //echo $photo; ?>
					<img style="width:80px; height:65px; " src="<?php// echo $photo; ?>" alt="Student Image"></th>
				</tr>
				<tr>
					<th class="look">Father's Name</th>
					<th class="look">: RAJ LALAN SINGH<?php //echo strtoupper($row['father_name']); ?></th >
					<th class="look">Class</th>
					<th class="look">: B.Sc AG <?php
							// $sql_class = 'select * from class_detail where sno = "'.$row['course_name'].'"';
							// $row_class = mysqli_fetch_assoc(mysqli_query($db,$sql_class));
							// echo $row_class['class_description']; 
						// ?>
					</th >
				</tr>
				<tr>
					<th class="look">Mother's Name</th>
					<th class="look">:RAJ LALAN SINGH <?php //echo strtoupper($row['mother_name']); ?></th >
					<th class="look">UIN NO.</th>
					<th class="look">: KNI20231041<?php //echo $row['uin_no']; ?></th >
				</tr>
				<tr>
					<th class="look">College</th>
					<th colspan="3" class="look">: K.N.I.P.S.S. Sultanpur</th >
				
				</tr>
			</table>	
            <table class="table text-center" width="100%" style="border:1px solid black; ">
                <tr style="border:1px solid black; ">
                    <th width="50%" class="abc pp" style="padding-top:20px;">SUBJECT</th>
                    <th width="14%" class="abc pp"style="padding-top:20px;">CREDIT HOURS</th>
                    <th  width="12%" class="abc ">TOTAL OBT MARKS<br> (TH.+PR.)</th>
                    <th  width="12%" class="abc pp" style="padding-top:20px;">  GRADE </th>
                    <th  width="12%" class="abc " style="padding-top:20px;">CREDIT GRADE POINTS</th>
                </tr>
				<tr style="border:1px solid black; ">
                    <td  class="abc">Fundamental of agronomy</td>
                    <td    class="abc">3(2+1)</td>
                    <td   class="abc">78</td>
                    <td   class="abc">7.8</td>
                    <td   class="abc">22.4</td>
				<tr style="border:1px solid black; ">
                    <td  class="abc">Fundamental of agronomy</td>
                    <td    class="abc">3(2+1)</td>
                    <td   class="abc">78</td>
                    <td   class="abc">7.8</td>
                    <td   class="abc">22.4</td>
                </tr>
				<tr style="border:1px solid black; ">
                    <td  class="abc">Fundamental of agronomy</td>
                    <td    class="abc">3(2+1)</td>
                    <td   class="abc">78</td>
                    <td   class="abc">7.8</td>
                    <td   class="abc">22.4</td>
                </tr>
				<tr style="border:1px solid black; ">
					<td  class="abc">Fundamental of agronomy</td>
					<td    class="abc">3(2+1)</td>
                    <td   class="abc">78</td>
                    <td   class="abc">7.8</td>
                    <td   class="abc">22.4</td>
                </tr> 
				<tr style="border:1px solid black; ">
                    <td  class="abc">Fundamental of agronomy</td>
                    <td    class="abc">3(2+1)</td>
                    <td   class="abc">78</td>
                    <td   class="abc">7.8</td>
                    <td   class="abc">22.4</td>
                </tr>
				<tr style="border:1px solid black; ">
                    <td  class="abc">Fundamental of agronomy</td>
                    <td    class="abc">3(2+1)</td>
                    <td   class="abc">78</td>
                    <td   class="abc">7.8</td>
                    <td   class="abc">22.4</td>
                </tr>
				<tr style="border:1px solid black; ">
                    <td  class="abc">Fundamental of agronomy</td>
                    <td    class="abc">3(2+1)</td>
                    <td   class="abc">78</td>
                    <td   class="abc">7.8</td>
                    <td   class="abc">22.4</td>
                </tr>
				<tr style="border:1px solid black; ">
                    <td  class="abc">Fundamental of agronomy</td>
                    <td    class="abc">3(2+1)</td>
                    <td   class="abc">78</td>
                    <td   class="abc">7.8</td>
                    <td   class="abc">22.4</td>
                </tr>
				<tr style="border:1px solid black; ">
                    <td  class="abc">Fundamental of agronomy</td>
                    <td    class="abc">3(2+1)</td>
                    <td   class="abc">78</td>
                    <td   class="abc">7.8</td>
                    <td   class="abc">22.4</td>
                </tr>
				<tr style="border:1px solid black; ">
                    <td  class="abc">Fundamental of agronomy</td>
                    <td    class="abc">3(2+1)</td>
                    <td   class="abc">78</td>
                    <td   class="abc">7.8</td>
                    <td   class="abc">22.4</td>
                </tr>
				<tr style="border:1px solid black; ">
                    <td  class="abc">Fundamental of agronomy</td>
                    <td    class="abc">3(2+1)</td>
                    <td   class="abc">78</td>
                    <td   class="abc">7.8</td>
                    <td   class="abc">22.4</td>
                </tr>
				<tr style="border:1px solid black; ">
                    <td  class="abc">Fundamental of agronomy</td>
                    <td    class="abc">3(2+1)</td>
                    <td   class="abc">78</td>
                    <td   class="abc">7.8</td>
                    <td   class="abc">22.4</td>
                </tr>
				<tr style="border:1px solid black; ">
                    <td  class="abc">NSS/PHYSICAL EDUCATION & YAGA PRACTICES</td>
                    <td    class="abc">3(2+1)</td>
                    <td   class="abc">78</td>
                    <td   class="abc" colspan="2">SATISFACTORY</td>
                </tr>
				<tr style="border:1px solid black; ">
                    <td  class="abc">Total</td>
                    <td    class="abc">3(2+1)</td>
                    <td   class="abc">78</td>
                    <td   class="abc">7.8</td>
                    <td   class="abc">22.4</td>
                </tr>
            </table>
			
			<table width="100%" class="table  " style="border:1px solid black; ">
				<tr  style="border:1px solid black; ">
                    <th  class="text-center" width="25%">TOTAL CREDIT POINT</th>
                    <th  class="text-center"  width="25%"  style="border:1px solid black; ">184.9</th>
                    <th  class="text-center" rowspan="2" width="14%">Grand Total <br>7.396</th>
                    <th  class="text-center" rowspan="2" width="36%">Result/Division<br>PASSED/</th>
                </tr>
				<tr>
                    <th  class="text-center">TOTAL CREDIT POINT</th>
                    <th  class="text-center"  style="border:1px solid black; ">184.9/25</th>
                </tr>
			</table>
			

			<table width="100%">
				<tr>
					<td  style="text-align:center;font-size:1.2rem;font-weight:bold;">INSTRUCTIONS FOR B.Sc(AG) & M.Sc(AG)</td>
				</tr>
				<tr>
					<td>1.To pass a candidate in particular paper must obtain a minimum of 50% marks in U.G. course (aggregate of theory, mid-term, and practical marks)and in P.G. course it will be 60% marks.</td>
				</tr>
				<tr>
					<td>2.Grade obtained=Marks obtained in particular course divided by 10.</td>
				</tr>
				<tr>
					<td>3. Total Grade Point = Numerical value of the grade obtained in particular course/paper multiplied by the number of credits of same course.</td>
				</tr>
				<tr>
					<td>4.GPA = Total Grade Point earned divided by total number of credits offered.</td>
				</tr>
				<tr>
					<td>5. To passing a semester minimum grade point average (GPA) should must be 5.0 in U.G. course, in P.G. course 6.0.</td>
				</tr>
				<tr>
					<td>6.% of marks = GPA x 10.</td>
				</tr>
			</table>
			
        </div>
		</div>
    <div>
  </body>
</html>
