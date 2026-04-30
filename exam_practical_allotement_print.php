<?php
include("scripts/settings.php");
	$query = 'SELECT * from exam_practical_allotment_invoice WHERE sno ="'.$_GET['letter_id'].'"';
	//echo $query;
	$result =execute_query($db,$query);
	$row=mysqli_fetch_assoc($result);
		$sql_paper = 'select * from add_subject_details WHERE paper_code = "'.$row['paper'].'"';
		$res_paper = mysqli_fetch_assoc(mysqli_query($db, $sql_paper));
		
		$sql_subject = 'select * from add_subject WHERE sno = "'.$res_paper['subject_id'].'"';
		$res_subject = mysqli_fetch_assoc(mysqli_query($db, $sql_subject));
		
		$sql_class = 'select * from class_detail WHERE sno = "'.$res_paper['class_id'].'"';
		$res_class = mysqli_fetch_assoc(mysqli_query($db, $sql_class));
		
		$sql_examiner_ext = 'select * from exam_examiner_info WHERE sno = "'.$row['ext_examiner'].'"';
		$res_examiner_ext = mysqli_fetch_assoc(mysqli_query($db, $sql_examiner_ext));
		
		$sql_examiner_int = 'select * from exam_examiner_info WHERE sno = "'.$row['int_examiner'].'"';
		$res_examiner_int = mysqli_fetch_assoc(mysqli_query($db, $sql_examiner_int));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title></title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="description" content="" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="icon" href="favicon.png">
  <style>
	*{

	}
	@media print{
		.wrap{
			font-size:13px;
		}
	}
  </style>
</head>
<body>
  <center>
	  <div class="border border-dark  mt-4" style="width:100%">
    <table class="border-dark" width="100%" style="margin:0px;">
                <tr>
                    <th width="12%" rowspan="2"><img style="padding:15px; height:65px; width:65px; "
                            src="images/college_log.png" alt="logo" class="img-fluid d-block m-auto" /> </th>
                    <th width="88%">
                        <h4 class="" style="text-align: center; margin:0px; "><span
                                style="font-size:16px;white-space:nowrap;" class="head-name"><b>Kamla Nehru Institute Of
                                    Physical & Social Sciences,Sultanpur, Uttar Pradesh</b></span> <br><span style="font-size:16px">An Autonomous
                            Institute And Accredited "A" Grade by NAAC</span></h4>
                    </th>
                </tr>
            </table>
			<div class="wrap">
				<div class="mt-2" style="margin-left:10px;margin-right:10px;"></div>
				<div class="d-flex mt-2 ps-2">
					<div class="" style="width:70%; text-align:left;">पत्रांक संख्या- के० एन० आई०/गोंप० वि०/प्रायो०-मौखिक /00<?php echo $_GET['$i']; ?>/2023</div>
					<div class=" " style="margin-right:50px;">
						
						दिनांक: <?php echo date("d/m/Y",strtotime($row['exam_date']))?> </br>
						बैच: <?php echo $row['batch']; ?>
						
					</div>
				</div>
				<div class="ps-2" style="text-align:left;">सेवा में,</div>
				<div class="" style="margin-left:50px;margin-top:20px;text-align:left;">विभागाध्यक्ष, </div>
				<div class="" style="margin-left:50px;text-align:left;">(039) K.N.I. P.S.S. SULTANPUR </div>
				<div class="" style="margin-left:50px;margin-top:10px;text-align:left;">महोदय/महोदया, </div>
				<div class="" style="margin-left:50px;text-align:justify;padding-right:10px;"><?php echo $res_class['class_description']?> <?php echo $res_subject['subject']?> <?php echo $row['paper']?>-<?php echo $res_paper['title_of_paper']?> MID वर्ष -2023 की आयोजित होने वाली प्रायोगिक मौखिक परीक्षा के संपादनार्थ प्राचार्य महोदय के आदेश के अनुपालन में निम्नलिखित विवरणानुसार आंतरिक / बाह्य परीक्षकों की सूची इस आशय से प्रेषित की जा रही है कि नियुक्त परीक्षकों से यथाशीघ्र तिथि निर्धारित करने के उपरान्त प्रायोगिक/मौखिक परीक्षा अधिकतम दिनांक <?php echo date("d/m/Y",strtotime($row['max_allot_date']))?> तक सम्पन्न कराने कि व्यवस्था सुनिचित करने का कष्ट करे।
				</div>
				<table class="table table-bordered border-dark w-75" style="margin-left:50px; margin-top:10px;">
          <tr>
              <td style="padding-left:5px; padding-right:5px;">आंतरिक परीक्षक का नाम</td>
              <td style="padding-left:5px; padding-right:15px;"><?php echo $res_examiner_int['name']?> (<?php echo $res_examiner_int['mob_num']?>) -- KNIPSS SULTANPUR</td>
          </tr>
          <tr>
              <td style="padding-left:5px; padding-right:5px; width:138px;">बाह्य परीक्षक का नाम</td>
              <td style="padding-left:5px; padding-right:5px;"><?php echo $res_examiner_ext['name']?> (<?php echo $res_examiner_ext['mob_num']?>) --KNIPSS SULTANPUR</td>
          </tr>
      </table>

				<div class="" style="margin-left:70px;margin-top:10px;text-align:justify;padding-right:10px;">* नियुक्त वाहय परीक्षको से सम्पर्क कर प्रायोगिक/मौखिक परीक्षा संपन्न करायें। यदि कोई परीक्षक असमर्थता व्यक्त करता है तो परीक्षा नियंत्रक से उसके स्थान पर दूसरा बाह्य परीक्षक नियुक्त कराकर प्रायोगिक/मौखिक परीक्षा सम्पन करायी जाय।
				</div>
				<div class="" style="margin-left:70px;margin-top:10px;text-align:justify;padding-right:10px;">ज्ञातव्य हो कि परीक्षा समिति के निर्णयानुसार प्रायोगिक/मौखिक परीक्षाओं में किसी भी छात्र/छात्रा को 75 प्रतिशत अथवा इससे अधिक अंक प्रदान करने पर उसका औचित्य दर्शाना होगा एवं ऐसी उत्तर-पुस्तिकाओं को अलग से संस्थान में (परीक्षा नियंत्रक के नाम) प्रेषित करना होगा। इस निर्णय की सूचना पूर्व में समस्त प्राचार्य/विभागाध्यक्ष/समन्यवक को प्रेषित की जा चुकी है।
				</div>
				<div class="" style="margin-left:70px;margin-top:10px;text-align:justify;padding-right:10px;">प्राचार्य महोदय के निर्देशानुसार प्रायोगिक/मौखिक परीक्षा सम्बन्धी अंक नियुक्त परीक्षकों के माध्यम से ही उसी दिन ऑनलाइन द्वारा भेजना होगा तथा प्रतिपर्ण (हार्ड कॉपी) संस्थान में अलग से जमा करना होगा ।
				</div>
				<div class="" style="margin-left:70px;margin-top:10px;text-align:justify;padding-right:10px;">उक्त प्रायोगिक/
					मौखिक परीक्षा के सम्पादनार्थ आंतरिक/वाहृय परीक्षकों को नियमानुसार यात्रा-भत्ता एवं पारिश्रमिक का भुगतान देय होगा।
				</div>
				
				<div class="" style="margin-right:90px;margin-top:10px;text-align:right">भवदीय </div>
				<!-- image yaha par rahe ga -->
				<div class="" style="margin-right:50px;margin-top:10px;text-align:right"><img style="width:120px;" src="images/pariksha_niyantrak_sign.png"> </div>
				<div class="" style="margin-right:65px;margin-top:10px;text-align:right">परीक्षा नियंत्रक </div>
				
				<div class="" style="margin-left:50px;margin-top:15px;text-align:left;padding-right:10px;">प्रतिलिपिः निम्नलिखित को सूचनार्थ एवं अग्रेतर कार्यवाही हेतु प्रेषित:- </div>
				<div class="" style="margin-left:50px;margin-top:0px;text-align:left;">1. <?php echo $res_examiner_int['name']?> (<?php echo $res_examiner_int['mob_num']?>) --KNIPS S SULTANPUR को इस आशय के साथ प्रेषित कि उपरोक्तनुसार नियुक्त वाहृय परीक्षक से सम्पर्क कर उक्त परीक्षा यथाशीघ्र संपन्न कराने की व्यवस्था सुनिश्चित करने का कष्ट करें।
				</div>
				<div class="" style="margin-left:50px;margin-top:0px;text-align:justify;padding-right:10px;">2. प्रोग्रामर ई०डी०पी० सेल को इस आशय से प्रेषित कि उपर्युक्त सूचना सम्बंधित महाविद्यालय की लागिंग आई०डी० पर अपलोड करने का कष्ट करें।
				</div>
				<div class="" style="margin-left:50px;margin-bottom:30px;text-align:justify;padding-right:10px;">3. सम्बद्ध समस्त विभागाध्यक्ष
				</div>
			</div>
	  </div>
		
  </center>
</body>
</html>