<?php
//include("scripts/settings.php");
include("lib_setting.php");
$msg = '';
$rdate = date("d/m/Y", strtotime("+30 days"));
// page_header_start();
// page_header_end();
// page_sidebar();
//header_lib();
$conn = $db;
if(isset($_GET['id'])){
  $sql = 'select * from bba_lib_id_card where sno = '.$_GET['id'];
  //echo $sql;
$res= '';
  $r = mysqli_query($conn, $sql);
  // echo $_GET['id'];
  if($r){
    $res=mysqli_fetch_assoc($r);
  }
}
$sql_course = 'SELECT * FROM class_detail where sno = "'.$res['course'].'"';
$course = mysqli_fetch_assoc(mysqli_query($db, $sql_course));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Card Front</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            min-height: 100vh;
            padding:3rem 0;
        }
        .cont{
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap:1rem;
        }
        .wrap{
            height: 300px;
            width: 468px;
            background-color: lightcyan;
            padding:15px;
            border-radius: 7px;
            border:1px solid #333;
        }
        .head{
            display: flex;

        }
        .logo>img{
            width: 80px;

        }
        .clg{
            text-align: center;
            align-self: center;
        }
        .clg_name{
            font-size: 1.3rem;
            font-weight: bolder;
        }
        .clg_address{
        }
        .clg_contact{
            font-size: 0.8rem;
        }
        .stu_info{
            margin-top: 0.5rem;
            display: flex;
            justify-content: space-evenly;
            gap:1rem;
        }
        .stu_img>img{
            width: 100px;
            border-radius: 6px;
            border:1px solid #222;
        }

        .authorization{
            margin-top: 0.5rem;
            display: flex;
            justify-content: space-between;
			
        }
		.lib_deg{
			padding-right:1rem;
		}
        .wrap-back{
            padding:1.4rem;
            border: 1px solid #222;
        }
        .instruction{
            padding:0 1rem;
        }
        .instruction>h3{
			margin-block:0;
            font-size: 1.2rem;
            text-align: center;
        }
		.instruction>ul{
			margin:0;
			margin-left:-0.5rem;
		}
		.instruction>ul>li{
			font-size:0.85rem;
		}
        .stu_bar_img>img{
            width: 100px;
        }

        .qr_code_img{
			margin-top:1rem;
            width: 100px;
        }

        @media print {
            body{
                height: 100vh;
            }
            
        }
		.stu_info_col>div{
			width:112px;
		}

		.stu_detail>div{
			width: 177px;
		   /*  overflow-y: hidden;
			white-space: nowrap;
			text-overflow: clip;
			text-overflow: ellipsis; */
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
			
		}
    </style>
</head>
<body>
    <div class="cont">
        <div class="wrap" >
            <div class="head">
                <div class="logo">
                    <img src="lib_card_images/logo.png" alt="KNIPSS logo">
                </div>
                <div class="clg">
                    <div class="clg_name">
                        KNIPSS (CENTRAL LIBRARY)
                    </div>
                    <div class="clg_address">
                        Faizabad Raod Sultanpur-228118
                    </div>
                    <div class="clg_contact">
                        Ph: 9415968003,Email:centrallibrarykni72Egmail.com
                    </div>
                </div>
            </div>
            <div class="stu_info">
                <div class="stu_info_col">
                    <div class="stu_lib_card_no_col">
                        Lib. Card NO.
                    </div>
					<div class="stu_lib_card_no_col">
                        Roll NO.
                    </div>
                    <div class="stu_name_col">
                        Name
                    </div>
                    <div class="stu_course_col">
                        Course
                    </div>
                    <div class="stu_session_col">
                        Session
                    </div>
                    <div class="stu_date_of_issue_col">
                        Issue Date
                    </div>
                    <div class="stu_valid_upto_col">
                        Valid Upto
                </div>
                </div>
                <div class="stu_detail">
                     <div class="stu_lib_card_no">
                        <?php echo $res['lib_no']; ?>
                    </div>
					<div class="stu_lib_card_no">
                        <?php echo $res['lib_card_no']; ?>
                    </div>
                    <div class="stu_name">
                        <?php echo $res['name']; ?>
                    </div>
                    <div class="stu_course">
					
                        <?php 
if (is_int($res['course'])) {
    echo $course['class_description'];
} else {
    echo $res['course'];
}
?>


                    </div>
                    <div class="stu_session">
                        <?php echo $res['course_session']; ?>
                    </div>
                    <div class="stu_date_of_issue">
                        <?php echo $res['date_of_issue']; ?>

                    </div>
                    <div class="stu_valid_upto">
                    <?php echo $res['valid_upto']; ?>
                        
                    </div>
                </div>
                <div class="stu_img">
                            <img class="profile"
                            src="<?php echo $res['profile']; ?>"
                            alt="Student_image"
                            title="Student_image"
                            width=""
                            height="">
                </div>
            </div>
            <div class="authorization">
                <div class="stu_sig">
                    <div class="stu_deg">
                        Student
                    </div>
                </div>
                <div class="stu_bar">

                    <div class="stu_bar_img">
                  <!--   <img src="<?php echo 'lib_card_qr_image/'.$res['qr_code']; ?>" />; -->
                       <!--  <img src="images/bar.png" alt=""> -->

                    </div>
                </div>
                <div class="lib_info">
                    <div class="lib_deg">
                        Librarian
                    </div>
                </div>
            </div>

          
        </div>


          <!-- back -->
          <div class="wrap wrap-back">
            <div class="instruction">
                <h3>Instrauction</h3>
                <ul>
                    <li>This Card is property of KNIPSS Sultanpur</li>
                    <li>This Card should always carried by the student in the library</li>
                </ul>
            </div>
            
            <div class="stu_info ">
                <div class="stu_info_col">
                    <!--<div class="stu_lib_card_no_col">
                       Enrollment No.
                    </div>-->
                    <div class="stu_name_col">
                        Address
                    </div>
                    <div class="stu_course_col">
                        DOB
                    </div>
                    <div class="stu_session_col">
                        Email ID
                    </div>
                    <div class="stu_date_of_issue_col">
                        Mobile NO.
                    </div>
                    <div class="stu_valid_upto_col">
                        Fathers Name
                    </div>
                    <div class="stu_perma_add_col">
                        Permanent Address
                    </div>
                </div>
                <div class="stu_detail">
					<!--
						<div class="stu_lib_card_no">
                        <?php // echo "1"; ?>
                    </div>-->
                    
                    <div class="stu_name overflowx">
                        <?php echo $res['address']; ?>
                    </div>
                    <div class="stu_course">
                        <?php echo $res['dob']; ?>

                    </div>
                    <div class="stu_session">
                        <?php echo $res['email']; ?>
                    </div>
                    <div class="stu_date_of_issue">
                        <?php echo $res['mobile']; ?>
                    </div>
                    <div class="stu_valid_upto">
                        <?php echo $res['father_name']; ?>
                    </div>
                    <div class="stu_valid_upto" style="position:absolute;">
                        <?php echo $res['address_perma']; ?>
                    </div>
                </div>
                <div class="stu_bar">
                    <img class="qr_code_img" src="<?php echo 'lib_card_qr_image/'.$res['qr_code']; ?>"  />
                </div>
            </div>
            
        </div>
    

    </div>
        
   

</body>
</html>
<?php
// page_footer_start();
// page_footer_end();
//footer_lib();
?>