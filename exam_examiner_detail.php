<?php
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
$msg='';
page_header_start();
page_header_end();
page_sidebar();

//delete commadn
if(isset($_GET['delid'])){
    
    // $delres=mysqli_query($db,$delsql);
    // if($delres){
    //     $msg.="<p class='alert alert-danger'>Data Deleted successfully</p>";
    // }else{
    //     $msg.="Could Not delete";
    // }

    if (file_exists($_GET['delpic'])) {
		if (unlink($_GET['delpic'])) {
			$msg .= '<h6 class="alert  alert-danger">Photo deleted. </h6>';
		}else{
			$msg .= '<h6 class="alert  alert-warning">Could not find Photo.</h6> ';
		}
	}
    if (file_exists($_GET['delsign'])) {
		if (unlink($_GET['delsign'])) {
			$msg .= '<h6 class="alert  alert-danger">Signature deleted. </h6>';
		}else{
			$msg .= '<h6 class="alert  alert-warning">Could not find signature.</h6> ';
		}
	}
		// Perform the file deletion
	
		$delsql="DELETE FROM exam_examiner_info WHERE sno='".$_GET['delid']."'";
		$data = mysqli_query($db,$delsql);
		if(mysqli_errno($db)){
			$msg .= '<h6 class="alert alert-warning">Deletion Failed.</h6>';
		}
		else{
			$msg .= '<h6 class="alert alert-danger">Data deleted.</h6>';			
		}
	
}
?>

<body id="public">
	<div id="wrapper">	
		<div id="content" class="card card-body ">    
        	<div id="container" class="row d-flex my-auto">    	
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" enctype="multipart/form-data" method="POST"  >
					<h2><img style="width:40px;" src="images/add.png" />Examiner Profile Details<span class="orange"></span></h2>
					<?php echo $msg;?>
					<div class="table-responsive">
                    <table class="table table-bordered tabel-hover ">
                        <tr>
							<td>Sno</td>
                            <td>Examiner Name</td>
                            <td>Designation</td>
                            <td>Contact No.</td>
                            <td>Pan Card</td>
                            <td>Subject Name (examiner type)</td>
                            <td>Examiner Photo</td>
                            <td>Examiner Signature</td>
                            <td>View</td>
                            <td>Edit</td>
                            <td>Delete</td>
                        </tr>
                        <?php
                            $fetchsql="SELECT * from exam_examiner_info";
                            $fetchres=mysqli_query($db,$fetchsql);
                            if($fetchres){
								$i = 1;
                                while($fetchRow=mysqli_fetch_assoc($fetchres)){
                                    ?>
                                        <tr>
											<td><?php echo $i++; ?></td>
                                            <td><?php echo $fetchRow['name']?></td>
                                            <td><?php echo $fetchRow['desig']?></td>
                                            <td><?php echo $fetchRow['mob_num']?></td>
                                            <td><?php echo $fetchRow['pan_num']?></td>
                                            <td><?php echo $fetchRow['teach_sub']?> (<?php echo $fetchRow['examiner_type'];?>)</td>
                                            <td><img src="<?php echo $fetchRow['pic']?>" alt="<?php $fetchRow['pic']?>" height="100"></td>
                                            <td><img src="<?php echo $fetchRow['sign']?>" alt="<?php $fetchRow['sign']?>" width="100"></td>
                                        <td><a href="exam_examiner_registration.php?view=<?php echo $fetchRow['sno'];?>" style="color:green;" target="_blank"><span class="fa fa-eye" aria-hidden="true" data-toggle="tooltip"></span></a></td>    
                                            <td><a href="exam_examiner_registration.php?editid=<?php echo $fetchRow['sno'];?>" target="_blank"><span class="far fa-edit" aria-hidden="true"></span></a></td>
                                            <td><a href="exam_examiner_detail.php?delid=<?php echo $fetchRow['sno'];?>&delpic=<?php echo $fetchRow['pic']?>&delsign=<?php echo $fetchRow['sign']?>" style="color:#f00" alt="Delete" ><span class="far fa-trash-alt" aria-hidden="true" data-toggle="tooltip" title="Delete"></span></a></td>
                                        </tr>
                                    <?php
                                }
                            }
                        
                        ?>
                    </table>

                    </div>
				</form>
			</div>
			
		</div>
	</div>

	<?php
	page_footer_start();
	page_footer_end();
	?>




</body>