<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
$response=1;
page_header_store();
$msg='';
//print_r($_POST);
if(isset($_POST['submit'])) {
	if($_POST['s_name']==''){
		$msg .= '<li>Please enter student name.</li>';
	}
	if($_POST['form_no']==''){
		$msg .= '<li>Please enter Form No.</li>';
	}
	if($_POST['f_name']==''){
		$msg .= '<li>Please enter Father Name.</li>';
	}
	if($_POST['s_class']==''){
		$msg .= '<li>Please enter Class.</li>';
	}
	if($_POST['opt_minor']==''){
		$msg .= '<li>Please select Minority.</li>';
	}
	/*if($_POST['sub1']==$_POST['sub2']){
		$msg .= '<li>Invalid Subjects.</li>';
	}
	if($_POST['sub2']==$_POST['sub3']){
		$msg .= '<li>Invalid Subjects.</li>';
	}
	if($_POST['sub3']==$_POST['sub1']){
		$msg .= '<li>Invalid Subjects.</li>';
	}*/
	if($_SESSION['username']!='sadmin'){
		$_POST['doa'] = date("Y-m-d");
	}
    if($msg=='') {
		$sql= "select * from add_subject";
		$subid=mysqli_fetch_array(execute_query(connect(), $sql));
		$subid=$subid['sno'];
		if($_POST['dob']==''){
			$_POST['dob']='2012-01-01';
		}
		$sql = 'select * from student_info where form_no="'.$_POST['form_no'].'"';
		$test = execute_query(connect(), $sql);
		if(mysqli_num_rows($test)!=0){
			$msg .= '<li>Invalid Form No.</li>';
		}
		if($msg==''){
			if(isset($_POST['confirm_submit'])){
				$sql='insert into student_info(stu_name, father_name, mother_name, class, dob, date_of_admission, gender, photo_id,
				form_no, category, sub1, sub2, sub3, status, income_certificate, acc_no,counselling_date,annual_income,other_univ, p_mobile , user_id, minority)
				VALUES("'.strtoupper($_POST['s_name']).'","'.strtoupper($_POST['f_name']).'","'.strtoupper($_POST['m_name']).'", "'.$_POST['s_class'].'", "'.$_POST['dob'].'", "'.$_POST['doa'].'","'.$_POST['gen'].'", "'.$_POST['form_no'].'.jpg", "'.$_POST['form_no'].'","'.$_POST['opt_cat'].'",
				"'.$_POST['sub1'].'","'.$_POST['sub2'].'","'.$_POST['sub3'].'",2, "'.$_POST['income_cert'].'",
				"'.$_POST['account_no'].'" ,"'.$_POST['doa'].'","'.$_POST['income'].'" ,"'.$_POST['prev_univ'].'", "'.$_POST['p_mobile'].'", "'.$_SESSION['username'].'", "'.$_POST['opt_minor'].'") ';
				execute_query(connect(), $sql);
				$sno = mysqli_insert_id(connect());
				$sql= "select * from student_info where sno=".$sno;
				$stu_id=mysqli_fetch_array(execute_query(connect(), $sql));
				if($stu_id['annual_income']>1){
					$_POST['opt_cat']='GEN';
				}
				$_POST['fees_amount'] = calc_fees($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'], $_POST['opt_cat']);
				$sql="select * from class_detail where sno=".$stu_id['class'];
				$class_id = mysqli_fetch_array(execute_query(connect(), $sql));
				if($class_id['type']=='aided' || $class_id['category']=='PG' || $class_id['type']=='PG'){
					if($_POST['prev_univ']=='awadh'){
						if($_POST['opt_cat']=='GEN' || $_POST['opt_cat']=='OBC'){
						$sql = 'select * from fees_detail where head_id=9 and class_id='.$class_id['sno'];
						$nom = mysqli_fetch_array(execute_query(connect(), $sql));
						$_POST['fees_amount'] = $_POST['fees_amount']-$nom['fee_amount'];
					}
					else if($_POST['opt_cat']=='SC' || $_POST['opt_cat']=='ST'){
						if($_POST['income']>1){
							$sql = 'select * from fees_detail where head_id=9 and class_id='.$_POST['s_class'];
							$nom = mysqli_fetch_array(execute_query(connect(), $sql));
							$_POST['fees_amount'] = $_POST['fees_amount']-$nom['fee_amount'];
						}
					}
				}
				if($_POST['prev_univ']=='other')
					{
						if($_POST['opt_cat']=='SC' || $_POST['opt_cat']=='ST'){
							if($_POST['income']==1){
								$sql = 'select * from fees_detail where head_id=9 and class_id='.$_POST['s_class'];
								$nom = mysqli_fetch_array(execute_query(connect(), $sql));
								$_POST['fees_amount'] = $_POST['fees_amount']+$nom['fee_amount'];
							}
						}
					}
				}
				//echo $sql;
				$class=$class_id['sno'];
				while('1'=='1'){
					$epin = gen_epin_alpha().gen_epin_number();
					$sql = "select * from fee_invoice where e_pin = '".$epin."'";
					$epin_result = execute_query(connect(), $sql);
					if(mysqli_num_rows($epin_result)==0){
						break;
					}
				}
			
				 /*if($_POST['income_cert']!='' && $_POST['account_no']!='' && $_POST['opt_cat']=='SC'){
					 $_POST['fees_amount']=100;
				 }*/
				  if(isset($_POST['computer'])){
					$sql='select * from fees_detail where class_id="'.$class.'" and head_id="computer"';
					$computer=mysqli_fetch_array(execute_query(connect(), $sql));
					$sql='insert into fee_invoice(class_id,student_id,tot_amount,amount_paid,approval_date,e_pin,tc,marksheet,addmission_form,
				 character_certificate,status,timestamp,user_id,type) values("'.$class.'", "'.$stu_id['sno'].'", "'.$computer['fee_amount'].'", "'.$computer['fee_amount'].'", "'.$_POST['doa'].'", "'.$epin.'","1","1","1","1","1","'.strtotime($_POST['doa']).'","'.$_SESSION['username'].'","computer")';
					 execute_query(connect(), $sql); 
					 
				 }
				 if(isset($_POST['self'])){
					$sql='select * from fees_detail where class_id="'.$class.'" and head_id="self"';
					$self=mysqli_fetch_array(execute_query(connect(), $sql));
					$sql='insert into fee_invoice(class_id,student_id,tot_amount,amount_paid,approval_date,e_pin,tc,marksheet,addmission_form,
				 character_certificate,status,timestamp,user_id,type) values("'.$class.'","'.$stu_id['sno'].'","'.$self['fee_amount'].'", "'.$self['fee_amount'].'","'.$_POST['doa'].'", "'.$epin.'","1","1","1","1","1","'.strtotime($_POST['doa']).'","'.$_SESSION['username'].'","self")';
					 execute_query(connect(), $sql);
				 }
				 if(isset($_POST['tour'])){
					$sql='select * from fees_detail where class_id="'.$class.'" and head_id="tour"';
					$tour=mysqli_fetch_array(execute_query(connect(), $sql));
					$sql='insert into fee_invoice(class_id,student_id,tot_amount,amount_paid,approval_date,e_pin,tc,marksheet,addmission_form,
				 character_certificate,status,timestamp,user_id,type) values("'.$class.'", "'.$stu_id['sno'].'", "'.$tour['fee_amount'].'", "'.$tour['fee_amount'].'", "'.$_POST['doa'].'", "'.$epin.'","1","1","1","1","1","'.strtotime($_POST['doa']).'","'.$_SESSION['username'].'","tour")';
					 execute_query(connect(), $sql); 
				 }
				 $sql = 'insert into fee_invoice(class_id,student_id,tot_amount,amount_paid,approval_date,e_pin,tc,marksheet,addmission_form,
				 character_certificate,status,timestamp,user_id,type)
				 values("'.$class.'","'.$stu_id['sno'].'","'.$_POST['fees_amount'].'", "'.$_POST['fees_amount'].'","'.$_POST['doa'].'",
				 "'.$epin.'","1","1","1","1","1","'.strtotime($_POST['doa']).'","'.$_SESSION['username'].'","fees")';
				 execute_query(connect(), $sql);
				 $fee_id = mysqli_insert_id(connect());
				 
				 $sql='insert into bank_transaction(e_pin,paid_amount,date_of_payment) 
				 values("'.$epin.'", "'.$_POST['fees_amount'].'", "'.time().'")';
				 execute_query(connect(), $sql);
				
				 $sql = "select * from roll_no where class='".$stu_id['class']."' and form_no is null order by sno limit 1";
				 //echo $sql;
				 $roll_no = mysqli_fetch_array(execute_query(connect(), $sql));
				 
				 $sql = "update student_info set roll_no = '".$roll_no['roll_no']."' where sno=".$stu_id['sno'];
				 execute_query(connect(), $sql);
				 
				 $sql = "update roll_no set form_no = '".$stu_id['form_no']."', class='".$stu_id['class']."', category='".$stu_id['category']."', gender='".$stu_id['gender']."', stu_name='".$stu_id['stu_name']."', father_name='".$stu_id['father_name']."', date_of_admission='".$stu_id['date_of_admission']."', stu_id='".$stu_id['sno']."' where sno=".$roll_no['sno'];
				 execute_query(connect(), $sql);
				 if(isset($_POST['computer'])){
					 $_POST['fees_amount'] += $computer['fee_amount'];
				 }
				 if(isset($_POST['self'])){
					  $_POST['fees_amount'] += $self['fee_amount'];
				 }
				 if(isset($_POST['tour'])){
					  $_POST['fees_amount'] += $tour['fee_amount'];
				 }
				 
				 $msg .= '<li>Student Approved</li>';
				 $msg .= '<li>Fees: '.$_POST['fees_amount'].'</li>';
				 $msg .= '<li>Admission Successful. Id : "'.$stu_id['form_no'].'". Name : "'.$stu_id['stu_name'].'"</li>';
				 $msg .= '<li><b><a href="printing.php?inv='.$fee_id.'" target="_blank">Click Here to Print</a></b></li>';
				 $msg .= '<script>window.open("printing.php?inv='.$fee_id.'");</script>';
				 unset($_POST);
				 $response=1;
			}
			elseif(isset($_POST['Submit3'])){
				$response=1;
			}
			else{
				$response=3;
				$comp_fees=0;
				$self_fees=0;
				  if(isset($_POST['computer'])){
					$sql='select * from fees_detail where class_id="'.$_POST['s_class'].'" and head_id="computer"';
					//echo $sql;
					$computer=mysqli_fetch_array(execute_query(connect(), $sql));
					$comp_fees = $computer['fee_amount'];
				 }
				 if(isset($_POST['self'])){
					$sql='select * from fees_detail where class_id="'.$_POST['s_class'].'" and head_id="self"';
					$self=mysqli_fetch_array(execute_query(connect(), $sql));
					$self_fees = $self['fee_amount'];
				 }
				 if(isset($_POST['tour'])){
					$sql='select * from fees_detail where class_id="'.$_POST['s_class'].'" and head_id="tour"';
					$tour=mysqli_fetch_array(execute_query(connect(), $sql));
					$tour_fees = $tour['fee_amount'];
				}
				$msg .= '<li>Please verify form.</li>';
			}
		}
	}
	else{
		$response=1;
	}
	
}
else{
	$sql = 'select * from fee_invoice where user_id="'.$_SESSION['username'].'" order by timestamp desc limit 1';
	$res_comp = execute_query(connect(), $sql);
	if(mysqli_num_rows($res_comp)==1){
		$row_comp = mysqli_fetch_array($res_comp);
		$sql = 'select * from fee_invoice where type="computer" and user_id="'.$_SESSION['username'].'" and epin="'.$row_comp['epin'].'" order by timestamp desc limit 1';
		$result_comp = execute_query(connect(), $sql);
		if(mysqli_num_rows($result_comp)==1){
			$comp_sel = "checked";
		}
		else{
			$comp_sel = "";
		}


		$row_comp = mysqli_fetch_array($res_comp);
		$sql = 'select * from fee_invoice where type="self" and user_id="'.$_SESSION['username'].'" and epin="'.$row_comp['epin'].'" order by timestamp desc limit 1';
		$result_self = execute_query(connect(), $sql);
		if(mysqli_num_rows($result_self)==1){
			$self_sel = "checked";
		}
		else{
			$self_sel = "";
		}
	}
	else{
		$comp_sel = "";
		$self_sel = "";
	}
}
if(isset($_POST['print'])) {
	$response=3;
}
$sql_fee = "select * from fee_invoice order by sno desc limit 1";
$fee_print = mysqli_fetch_array(execute_query(connect(), $sql_fee));
?>

<script language="javascript">
function printinvoice() {
	window.open("printing.php?inv=<?php echo $fee_print['sno'];?>");
}
function get_subject(class_name){
	if(class_name==26 || class_name==43){
				document.getElementById('tour').style.display = 'block';
			}
			else{
				document.getElementById('tour').style.display = 'none';
			}
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var v = xmlhttp.responseText;
			//alert(v);
			var v = v.split('#');
			if(v[1]=='PG' || v[2]=='aided' || v[2]=='PG'){
				document.getElementById('prev_univ_li').style.display = 'block';
			}
			else{
				document.getElementById('prev_univ_li').style.display = 'none';
			}
			document.getElementById('sub1').innerHTML=v[0];
			<?php 
			if(isset($_POST['sub1'])){
				echo "document.getElementById('sub1').value = '".$_POST['sub1']."';";
			}
			?>
			//alert(v[2]);
			if(v[1]!='PG' && v[2]!='self'){
				document.getElementById('sub2').innerHTML=v[0];
				<?php 
				if(isset($_POST['sub2'])){
					echo "document.getElementById('sub2').value = '".$_POST['sub2']."';";
				}
				?>
				if(class_name == 3|| class_name == 6 || class_name == 38){
					document.getElementById('sub3').innerHTML='';
				}
				else {
					document.getElementById('sub3').innerHTML=v[0];
					<?php 
					if(isset($_POST['sub3'])){
						echo "document.getElementById('sub3').value = '".$_POST['sub3']."';";
					}
					?>
				}
			}
			else{
				document.getElementById('sub2').innerHTML='';
				document.getElementById('sub3').innerHTML='';
			}
		}
	}
	xmlhttp.open("GET","get_subject.php?q="+class_name,true);
	xmlhttp.send();
}
function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
	function fnTXTFocus(id)
    {

        var objTXT = document.getElementById(id)
        objTXT.style.borderColor = "Red";

    }

    function fnTXTLostFocus(id)
    {
        var objTXT = document.getElementById(id)
        objTXT.style.borderColor = "green";
    }
window.onload = function(){
	<?php
	if(isset($_POST['s_class'])){
		echo "get_subject(".$_POST['s_class'].");";
	}
	?>
};
</script>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<style>
body
{
font-family:arial;
}
.preview
{
border:solid 1px #dedede;
padding:10px;
}
#photo{
}
#preview
{
color:#cc0000;
font-size:12px;2
border:1px solid #3F0;
}
input{
	text-transform:uppercase;
}
</style>

<?php 
switch($response) {
	case 1:{
?>
<?php
$sql= 'select * from general_settings where description= "session"';
$session_val= mysqli_fetch_array(execute_query(connect(), $sql)); 
?> 
	
<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">   
	<form action="new_admission.php" class="wufoo leftLabel page1" name="admission" enctype="multipart/form-data" method="post">
	<div class="header1" style="height:40px;"><img src="images/clogo.gif" style="height:90px;"></div>	
    <h2 align="center">Application Form For <span class="orange">Admission (<?php echo $session_val['value']?>)</span></h2><hr />
            <span style="color:#F00; font-size:16px; line-height:10px;">
            
            	<ul>
            	<?php echo $msg; ?> 	
                </ul>
             </span>
             <?php
			 if($_SESSION['username']=='sadmin'){
			?>
                <li class="notranslate"><label  class="desc" for="dob">Date of Admission<span class="name">*</span></label>
                <div>
           		 <script type="text/javascript" language="javascript">
	  				DateInput('doa', false, 'YYYY-MM-DD', '<?php if(isset($_POST['doa'])){echo $_POST['doa'];}else{echo date("Y-m-d");} ?>')
      			</script></div></li>
              <?php } ?>  <li class="notranslate"><label  class="desc" for="s_class">Select class <span class="alert">*</span></label>
                 <div><select name="s_class" class="listmenu" id="s_class"  value="<?php if(isset($_POST['s_class'])){echo $_POST['s_class'];} ?>" onChange="get_subject(this.value)" onFocus="fnTXTFocus(this.id)" >
                    <option value="" selected="selected"></option>
                    <?php
                    $sql = 'select * from class_detail order by sort_no, class_description';
                    $res = execute_query(connect(), $sql);
                    while($row = mysqli_fetch_array($res)) {
						$count = get_admission_count($row['sno']);
						if($count['total']<$row['total_seat']){
							echo '<option value="'.$row['sno'].'" ';
							if(isset($_POST['s_class'])){
								if($_POST['s_class']==$row['sno']){
									echo ' selected';
								}
							}
							echo '>'.$row['class_description'].'</option> ';
						}
                    }
                    ?>
                 </select></div></li>
                          
                 <li class="notranslate"><label  class="desc" for="m_name">Select subjects <span class="alert">*</span></label>
                1).&nbsp;<select name="sub1"   class="listmenu" id="sub1"  value="<?php if(isset($_POST['sub1'])){echo $_POST['sub1'];} ?>" onFocus="fnTXTFocus(this.id)"><option value=""></option></select>
                2).&nbsp;<select name="sub2"   class="listmenu" id="sub2"  value="<?php if(isset($_POST['sub2'])){echo $_POST['sub2'];} ?>" onFocus="fnTXTFocus(this.id)"><option value=""></option></select>					
                	3).&nbsp;<select name="sub3"  class="listmenu" id="sub3"  value="<?php if(isset($_POST['sub3'])){echo $_POST['sub3'];} ?>" onFocus="fnTXTFocus(this.id)"><option value=""></option></select></li>
               <li class="notranslate"><label  class="desc" for="form_no">Form Number<span class="alert">*</span></label>
                <div><input class="fieldtextmedium"  type="text" id="tax11" maxlength="10" size="10" name="form_no" value="<?php if(isset($_POST['form_no'])){echo $_POST['form_no'];} ?>" onFocus="fnTXTFocus(this.id)" />
             </div></li>
            
            <li class="notranslate"><label  class="desc" for="s_name">Candidate's Full Name <span class="alert">*</span></label>
                <div><input class="fieldtextmedium"  id="s_name" maxlength="45" size="40" value="<?php if(isset($_POST['s_name'])){echo $_POST['s_name'];} ?>"  name="s_name" onFocus="fnTXTFocus(this.id)" >
            </div></li>
            
            
           <li class="notranslate"><label  class="desc" for="f_name">Father's Name<span class="alert">*</span></label>
                <div><input class="fieldtextmedium" id="f_name" maxlength="35" size="40" name="f_name" value="<?php if(isset($_POST['f_name'])){echo $_POST['f_name'];} ?>" onFocus="fnTXTFocus(this.id)" >
            </div></li>
            
               
           <li class="notranslate"><label  class="desc" for="m_name">Mother's Name <span class="alert">*</span></label>
                <div><input class="fieldtextmedium" id="m_name" maxlength="35" size="40" name="m_name"  value="<?php if(isset($_POST['m_name'])){echo $_POST['m_name'];} ?>" onFocus="fnTXTFocus(this.id)" >
            </div></li>
            
			
                <li class="notranslate"><label  class="desc" for="dob">Date of Birth<span class="name">*</span></label>
                <div>
           		 <script type="text/javascript" language="javascript">
	  				DateInput('dob', false, 'YYYY-MM-DD', '<?php if(isset($_POST['dob'])){echo $_POST['dob'];}else{echo date("Y-m-d");} ?>')
      			</script></div></li>
            
               
                 <li class="notranslate"><label  class="desc" for="gen">Gender <span class="alert">*</span></label>
                 <div><select class="listMenu" name="gen" id="gen" value="<?php if(isset($_POST['gen'])){echo $_POST['gen'];} ?>" onFocus="fnTXTFocus(this.id)">
                    <option value="M" <?php if(isset($_POST['gen'])){if($_POST['gen']=='M'){echo ' selected';}}?>>Male</option>
                    <option value="F" <?php if(isset($_POST['gen'])){if($_POST['gen']=='F'){echo ' selected';}}?>>Female</option> 
                </select></div></li>
       
                 <li class="notranslate"><label  class="desc" for="opt_cat">Category <span class="alert">*</span></label>
                 <div><select class="listMenu" name="opt_cat" id="opt_cat" value="<?php if(isset($_POST['opt_cat'])){echo $_POST['opt_cat'];} ?>" onChange="changefees1(this.value)" onFocus="fnTXTFocus(this.id)">
                    <option value="GEN" <?php if(isset($_POST['opt_cat'])){if($_POST['opt_cat']=='GEN'){echo ' selected';}}?>>GENERAL</option>
                    <option value="OBC" <?php if(isset($_POST['opt_cat'])){if($_POST['opt_cat']=='OBC'){echo ' selected';}}?>>OBC</option>
                    <option value="SC" <?php if(isset($_POST['opt_cat'])){if($_POST['opt_cat']=='SC'){echo ' selected';}}?>>SC</option>
                    <option value="ST" <?php if(isset($_POST['opt_cat'])){if($_POST['opt_cat']=='ST'){echo ' selected';}}?>>ST</option> 
              	 </select></div></li>
                
                 <li class="notranslate"><label  class="desc" for="opt_minor">Minority <span class="alert">*</span></label>
                 <div><select class="listMenu" name="opt_minor" id="opt_minor"   value="<?php if(isset($_POST['opt_minor'])){echo $_POST['opt_minor'];} ?>" onChange="changefees1(this.value)" onFocus="fnTXTFocus(this.id)">
                    <option value="">Please Select</option>
                    <option value="YES" <?php if(isset($_POST['opt_minor'])){if($_POST['opt_minor']=='YES'){echo ' selected';}}?>>Yes</option>
                    <option value="NO" <?php if(isset($_POST['opt_minor'])){if($_POST['opt_minor']=='NO'){echo ' selected';}}?>>No</option>
              	 </select></div></li>
                 <li class="notranslate"><label  class="desc" for="computer">Computer Fees<span class="alert">*</span></label>
                <div><input class="fieldtextmedium" type="checkbox" <?php echo $comp_sel;?> id="tax11" maxlength="10" size="10" name="computer" onFocus="fnTXTFocus(this.id)" value="<?php if(isset($_POST['computer'])){echo $_POST['computer'];}?>" />
             </div></li>
             <li class="notranslate"><label  class="desc" for="self">Self Fees<span class="alert">*</span></label>
                <div><input class="fieldtextmedium" type="checkbox" <?php echo $self_sel;?> id="tax11" maxlength="10" size="10" name="self" onFocus="fnTXTFocus(this.id)" />
             </div></li>
             <li class="notranslate" style="display:none;" id="tour"><label  class="desc" for="tour">Tour Fees<span class="alert">*</span></label>
                <div><input class="fieldtextmedium" type="checkbox" <?php echo $tour_sel;?> id="tax11" maxlength="10" size="10" name="tour" onFocus="fnTXTFocus(this.id)" checked />
             </div></li>
             <li class="notranslate" id="prev_univ_li"><label  class="desc" for="s_class">Select Prev. University <span class="alert">*</span></label>
                 <div><select name="prev_univ" class="listmenu" id="prev_univ"  value="<?php if(isset($_POST['prev_univ'])){echo $_POST['prev_univ'];} ?>" onFocus="fnTXTFocus(this.id)" >
                 	<option value=""></option>
                    <option value="awadh">Dr.R.M.L.Awadh University</option>
                    <option value="other">Other University</option>
                 </select></div></li>
                <li class="notranslate"><label  class="desc" for="col_no">Income Certificate No.<span class="alert">*</span></label>
                        <div><input type="text"class="fieldtextmedium" name="income_cert" size="15"  value="<?php if(isset($_POST['income_cert'])){echo $_POST['income_cert'];} ?>" onFocus="fnTXTFocus(this.id)"></div>
                </li>
                
            	<li class="notranslate"><label  class="desc" for="name">Please Select Income<span class="name">*</span></label>
                  <div><select name="income" id="income">
                      <option value="1" <?php if(isset($_POST['income'])){if($_POST['income']=="1"){echo ' selected';}} ?>>Below 2 Lakhs</option>
                      <option value="200000" <?php if(isset($_POST['income'])){if($_POST['income']!="1"){echo ' selected';}} ?>>Above 2 Lakhs</option>
                      </select>
                   </div>
                </li>      	
         	
                
              <li class="notranslate"><label  class="desc" for="col_no">Account No.<span class="alert">*</span></label>        
              	<div><input type="text"class="fieldtextmedium" name="account_no" size="15" value="<?php if(isset($_POST['account_no'])){echo $_POST['account_no'];} ?>" onFocus="fnTXTFocus(this.id)">
              </div></li>
         	
             <li class="notranslate"><label  class="desc" for="mobile">Mobile<span class="alert">*</span></label>        
					<div><input name="p_mobile"class="fieldtextmedium" id="p_mobile" size="25" maxlength="10"  value="<?php if(isset($_POST['p_mobile'])){echo $_POST['p_mobile'];} ?>">
               </div></li>
            
              <li class="buttons">
                <div><input class="submit" value="Submit" name="submit"  type="submit"></div>
                <div><input  onClick="javascript:window.close();" value="Close" name="Submit3" class="submit" type="button"></div>
              </li>
              		
</form></div></div>

<?php 
 break;
	   }
	  case $response==2: {
   
?>
<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="new_admission.php" class="wufoo leftLabel page1"  id="stocksale" method="post"  name="part_purchase" enctype="multipart/form-data" >
       <input type="hidden" name="invoice_no" value="<?php echo $invoice_no; ?>"  />
    
       <h1><?php echo $msg; ?></h1>
    	
       <ul><li class="buttons">
       		<div style="float:left;"><input class="submit" type="button" name="print" value="Print" title="Print Invoice" onClick="return printinvoice()" /></div>
       		<div style="float:right;"><input class="submit" type="submit" name="continue" value="Continue" title="Continue" /></div></li></ul>
	
    </form></div></div>
<?php 
		break;
	}
	case 3:{
	?>
<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">   
	<form action="new_admission.php" class="wufoo leftLabel page1" name="admission" enctype="multipart/form-data" method="post">
	<div class="header1" style="height:40px;"><img src="images/clogo.gif" style="height:90px;"></div>	
    <h2 align="center">Verify <span class="orange">Application Form</span></h2><hr />
        <span style="color:#F00; font-size:16px; line-height:10px;">
            <ul>
	            <?php echo $msg;
				//print_r($_POST); ?> 	
            </ul>
        </span>
        <table width="100%">
        	<tr style="background:#666;">
            	<th>Date of Admission : <?php echo $_POST['doa']; ?><input type="hidden" name="doa" value="<?php echo $_POST['doa']; ?>"></th>
                <th>Computer Fees : 
					<?php if(isset($_POST['computer'])){
                        echo 'SELECTED (Rs.'.$comp_fees.')
                        <input type="hidden" name="computer" value="'.$_POST['computer'].'">';
                    }
                    else{
                        echo 'NOT SELECTED';
                    }?>
				</th>
                <th>Self Fees : 
				<?php if(isset($_POST['self'])){
                    echo 'SELECTED (Rs.'.$self_fees.')
                    <input type="hidden" name="self" value="'.$_POST['self'].'">';
                }
                else{
                    echo 'NOT SELECTED';
                }?>
                </th>
                <?php if($_POST['s_class']==26 || $_POST['s_class']==43)
				{
					echo '<th> Tour Fees: Rs'.$tour_fees.'</th>
					<input type="hidden" name="tour" value="'.$_POST['tour'].'">';
					} ?>
				<th>Main Fees : <?php 
				if($_POST['income']>1){
					$cat="GEN";
				}
				else{
					$cat=$_POST['opt_cat'];
				}
				$total=calc_fees($_POST['s_class'], $_POST['sub1'], $_POST['sub2'], $_POST['sub3'], $_POST['gen'], $cat);
				if($_POST['prev_univ']=='awadh'){
						if($_POST['opt_cat']=='GEN' || $_POST['opt_cat']=='OBC'){
						$sql = 'select * from fees_detail where head_id=9 and class_id='.$_POST['s_class'];
						$nom = mysqli_fetch_array(execute_query(connect(), $sql));
						$total = $total-$nom['fee_amount'];
					}
					else if($_POST['opt_cat']=='SC' || $_POST['opt_cat']=='ST'){
						if($_POST['income']>1){
							$sql = 'select * from fees_detail where head_id=9 and class_id='.$_POST['s_class'];
							$nom = mysqli_fetch_array(execute_query(connect(), $sql));
							$total = $total-$nom['fee_amount'];
						}
					}
				}
					if($_POST['prev_univ']=='other')
					{
						if($_POST['opt_cat']=='SC' || $_POST['opt_cat']=='ST'){
							if($_POST['income']==1){
								$sql = 'select * from fees_detail where head_id=9 and class_id='.$_POST['s_class'];
								$nom = mysqli_fetch_array(execute_query(connect(), $sql));
								$total = $total+$nom['fee_amount'];
							}
						}
					}
				echo $total;?>
                </th>
                </tr>
                <tr style="background:#666;">
                <th>Total Fees :
                <?php $main_total=$comp_fees+ $self_fees+ $total+ $tour_fees;
				 echo $main_total;?></th>
                <th>Form Number : <?php echo $_POST['form_no']; ?><input type="hidden" name="form_no" value="<?php echo $_POST['form_no']; ?>"/></th>
                <th colspan=2>Name : <?php echo $_POST['s_name']; ?><input type="hidden" value="<?php echo $_POST['s_name']; ?>" name="s_name"></th>
			</tr>
		</table>
        <li class="buttons">
        <input type="hidden" name="submit" value="9">
        <div><input class="submit" value="Continue" name="confirm_submit"  type="submit"></div>
        <div><input  value="Go Back & Edit" name="Submit3" class="submit" type="submit"></div>
        </li>
              		
        <li class="notranslate"><label  class="desc" for="f_name">Father's Name<span class="alert">*</span></label>
        <?php echo $_POST['f_name']; ?>
        <input type="hidden" name="f_name" value="<?php echo $_POST['f_name']; ?>">
        </li>
        <li class="notranslate"><label  class="desc" for="m_name">Mother's Name <span class="alert">*</span></label>
        <?php echo $_POST['m_name']; ?>
        <input type="hidden" name="m_name" value="<?php echo $_POST['m_name']; ?>">
        </li>
        <li class="notranslate"><label  class="desc" for="dob">Date of Birth<span class="name">*</span></label>
        <?php echo $_POST['dob']; ?>
        <input type="hidden" name="dob" value="<?php echo $_POST['dob']; ?>">
        </li> 
        <li class="notranslate"><label  class="desc" for="gen">Gender <span class="alert">*</span></label>
        <?php echo $_POST['gen']; ?>
        <input type="hidden" name="gen" value="<?php echo $_POST['gen']; ?>">
        </li>
        <li class="notranslate"><label  class="desc" for="opt_cat">Category <span class="alert">*</span></label>
        <?php echo $_POST['opt_cat']; ?>
        <input type="hidden" name="opt_cat" value="<?php echo $_POST['opt_cat']; ?>">
        </li>
        <li class="notranslate"><label  class="desc" for="opt_minor">Minority <span class="alert">*</span></label>
        <?php echo $_POST['opt_minor']; ?>
        <input type="hidden" name="opt_minor" value="<?php echo $_POST['opt_minor']; ?>">
        </li>
        <li class="notranslate"><label  class="desc" for="s_class">Select class <span class="alert">*</span></label>
        <?php echo get_class_detail($_POST['s_class']) ['class_description']; ?>
        <input type="hidden" name="s_class" value="<?php echo $_POST['s_class']; ?>">
		</li>        
        <li class="notranslate"><label  class="desc" for="m_name">Select subjects <span class="alert">*</span></label>
            1). <?php echo get_subject_detail($_POST['sub1'])['subject']; ?><input name="sub1" type="hidden" value="<?php echo $_POST['sub1']; ?>">
            2). <?php echo get_subject_detail($_POST['sub2'])['subject']; ?><input name="sub2" type="hidden" value="<?php echo $_POST['sub2']; ?>">
            3). <?php echo get_subject_detail($_POST['sub3'])['subject']; ?><input name="sub3" type="hidden" value="<?php echo $_POST['sub3']; ?>">
		</li>
        <li class="notranslate" id="prev_univ_li"><label  class="desc" for="s_class">Select Prev. University <span class="alert">*</span></label>
        <?php echo $_POST['prev_univ']; ?>
        <input type="hidden" name="prev_univ" value="<?php echo $_POST['prev_univ']; ?>">
        </li>
        <li class="notranslate"><label  class="desc" for="col_no">Income Certificate No.<span class="alert">*</span></label>
        <?php echo $_POST['income_cert']; ?>
        <input type="hidden" name="income_cert" value="<?php echo $_POST['income_cert']; ?>">
        </li>
        <li class="notranslate"><label  class="desc" for="name">Please Select Income<span class="name">*</span></label>
        <?php 
		if($_POST['income']==1){
			echo 'Below 2 Lakhs';
		}
		else{
			echo 'Above 2 Lakhs';
		}?>
        <input type="hidden" name="income" value="<?php echo $_POST['income']; ?>">
        </li>
        <li class="notranslate"><label  class="desc" for="col_no">Account No.<span class="alert">*</span></label>        
        <?php echo $_POST['account_no']; ?>
        <input type="hidden" name="account_no" value="<?php echo $_POST['account_no']; ?>">
        </li>
        <li class="notranslate"><label  class="desc" for="mobile">Mobile<span class="alert">*</span></label>        
        <?php echo $_POST['p_mobile']; ?>
        <input type="hidden" name="p_mobile" value="<?php echo $_POST['p_mobile']; ?>">
        </li>
	</form></div></div>
    <?php	
		break;
	}
}
 ?>
<?php 
page_footer_store(); 
function editable($field){
	if($field!=''){
		echo 'readonly= "readonly"';
	}
}
?>