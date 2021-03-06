<?php session_start(); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/constants.php"); ?>
<?php include("includes/checksession.php"); ?>

<?php

if(isset($_GET['cid'])){
    $cid = $_GET['cid'];
    $query = mysqli_query($connection, "SELECT * FROM calls WHERE callid='$cid'");
    $populate = mysqli_fetch_array($query);
}

if(isset($_POST['submit'])){
	$calldate = mysql_prep($_POST['calldate'], $connection);
	$mode = mysql_prep($_POST['mode'], $connection);
	$user = mysql_prep($_POST['user'], $connection);
	$for = mysql_prep($_POST['for'], $connection);
	$company = mysql_prep($_POST['company'], $connection);
	$lead = mysql_prep($_POST['lead'], $connection);
	$opportunity = mysql_prep($_POST['opportunity'], $connection);
	$notes = mysql_prep($_POST['Notes'], $connection);
	$followup = mysql_prep($_POST['followup'], $connection);
	$branch = getbranchbyid($user, $connection);

	$query = mysqli_query($connection, "INSERT INTO calls VALUES ('', STR_TO_DATE('$calldate', '%m-%d-%Y'), '$mode', '$user', '$for', '$company', '$lead', '$opportunity', '$notes', STR_TO_DATE('$followup', '%m-%d-%Y'),'No','$branch')");
    if(isset($_GET['cid'])){
        $cid = $_GET['cid'];
        $q = mysqli_query($connection, "UPDATE calls SET followed='Yes' WHERE callid=$cid");
    }
    
    redirect_to("calls.php");
}

?>
<script type="text/javascript">
    var populate = <?php echo json_encode($populate); ?>;
</script>

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from bucketadmin.themebucket.net/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 31 Jul 2014 11:12:06 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Sidharth Machinaries">
    <link rel="shortcut icon" href="images/favicon.html">
    <title>Calls</title>
    <!--Core CSS -->
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--clock css-->
    <link href="js/css3clock/css/style.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="css/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />

    <link rel="stylesheet" type="text/css" href="js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-timepicker/css/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datetimepicker/css/datetimepicker.css" />

    <link rel="stylesheet" type="text/css" href="js/jquery-multi-select/css/multi-select.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery-tags-input/jquery.tagsinput.css" />

    <link rel="stylesheet" type="text/css" href="js/select2/select2.css" />
    <link href="css/style1.css" rel="stylesheet">
    <link href="css/style1.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet"/>
    <script>
        function show(str) {
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else { 
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("targetid").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET","getcallcompany.php?q="+str,true);
                xmlhttp.send();
            }
        }
    </script>
</head>
<?php include("includes/sidebar.php"); ?>
<section id="main-content">
        <section class="wrapper">
            <!-- page start-->
            
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <h4><b>Add Call</b></h4>
                        </header>
                        <div class="panel-body">
                            <div class=" form">
                                <form class="cmxform form-horizontal " id="commentForm" method="post" action="#" onsubmit = "return checkDate()">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Call Date</label>
                                        <div class="col-md-6 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" name="calldate" id = "calldate" type="text" value="" required/>
                                            <!-- <span class="help-block">Select date</span> -->
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="callMode" class="control-label col-lg-3">Mode</label>
                                        <div class="col-lg-6">
                                            <select class="form-control" id="callMode" name="mode" required>
                                                <?php
													$query = mysqli_query($connection, "SELECT * FROM callmodes");
													$rows = mysqli_num_rows($query);
													for($i = 0; $i < $rows ; $i++){
														$result = mysqli_fetch_array($query);
												?>
                                                	<option value="<?php echo $result[0] ; ?>"> <?php echo $result[1] ; ?></option>
												<?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="callBy" class="control-label col-lg-3">Call By</label>
                                        <div class="col-lg-6">
                                            <select class="form-control" id="suser" name="user" required>
                                                <?php
                                                    $exec = "SELECT * FROM users ";
                                                    if($_SESSION['role'] == 'BRH' || $_SESSION['role'] == 'SAE'){
                                                        $id = $_SESSION['user'];
                                                        $exec = $exec."WHERE userid='$id'";
                                                    }
                                                    $query = mysqli_query($connection, $exec);
													$rows = mysqli_num_rows($query);
													for($i = 0; $i < $rows ; $i++){
														$result = mysqli_fetch_array($query);
												?>
                                                	<option value="<?php echo $result['userid'] ; ?>"> <?php echo $result['fullname'] ; ?></option>
												<?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="callfor" class="control-label col-lg-3">For</label>
                                        <div class="col-lg-6">
                                            <select class="form-control"  id="callfor" name="for" required>
                                                <option value="Customer">Customer</option>
                                                <option value="Opportunity">Opportunity</option>
                                                <option value="Lead">Lead</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="contactCompany" class="control-label col-lg-3">Company</label>
                                        <div class="col-lg-6">
                                            <select class="form-control" id="contactCompany" name="company" onchange="show(this.value)" required>
												<?php
													$exec = "SELECT * FROM companies ";
                                                    if($_SESSION['role'] == 'BRH'||$_SESSION['role'] == 'SAE'){
                                                        $branch = getbranchbyid($_SESSION['user'], $connection);
                                                        $exec = $exec."WHERE branch='$branch'";
                                                    }
                                                    $query = mysqli_query($connection, $exec);
													$rows = mysqli_num_rows($query);
													for($i = 0; $i < $rows ; $i++){
														$result = mysqli_fetch_array($query);
                                                        if($i == 0)
                                                            $req_company = $result[0];
												?>
                                                	<option value="<?php echo $result[0] ; ?>"> <?php echo $result[1] ; ?></option>
												<?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="targetid">
									<div class="form-group ">
                                        <label for="clead" class="control-label col-lg-3">Lead</label>
                                        <div class="col-lg-6">
                                            <select class="form-control" name="lead" id="lead" required>
                                                <?php
													$query = mysqli_query($connection, "SELECT * FROM leads");
													$rows = mysqli_num_rows($query);
													for($i = 0; $i < $rows ; $i++){
														$result = mysqli_fetch_array($query);
												?>
                                                	<option value="<?php echo $result[0] ; ?>"><?php echo $result[7] ; ?></option>
                                            	<?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="copp" class="control-label col-lg-3">Opportunity</label>
                                        <div class="col-lg-6">
                                            <select class="form-control" id="opportunity" name="opportunity" required>
                                                <?php
													$query = mysqli_query($connection, "SELECT * FROM opportunities");
													$rows = mysqli_num_rows($query);
													for($i = 0; $i < $rows ; $i++){
														$result = mysqli_fetch_array($query);
												?>
                                                	<option value="<?php echo $result[0] ; ?>"><?php echo $result[1] ; ?></option>
                                            	<?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="callNotes" class="control-label col-lg-3">Call Notes</label>
                                        <div class="col-lg-6">
                                            <textarea class="form-control " id="callNotes" name="Notes"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Next Follow Up Call</label>
                                        <div class="col-md-6 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker" name="followup" size="16" id="fdate" type="text" value="" />
                                            <!-- <span class="help-block">Select date</span> -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-6">
                                            <button class="btn btn-primary" type="submit" name="submit">Save</button>
                                            <a href="calls.php"><button class="btn btn-default" type="button">Cancel</button></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title">Wrong Input!!!</h4>
                                        </div>
                                        <div class="modal-body" >
                                        <h4><b><i><div  id = "modaltext">Follow date cannot be before Call Date!!!</div></h4>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>
                </div>
            </div>
        </section>
    </section>
</section>
<!-- Placed js at the end of the document so the pages load faster -->
<!--Core js-->
<script type="text/javascript">
    function checkDate() {
        var fdate = document.getElementById("fdate").value.split("-");
        var cdate = document.getElementById("calldate").value.split("-");
        var f = new Date(fdate[2],fdate[0]-1,fdate[1]);
        var c = new Date(cdate[2],cdate[0]-1,cdate[1]);
        if(f < c) {
            $('#myModal3').modal('show'); 
            return false;
        }
        return true;    
    }
    

</script>
<script type="text/javascript">
Date.prototype.yyyymmdd = function() {
   var yyyy = this.getFullYear().toString();
   var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
   var dd  = this.getDate().toString();
   return yyyy +"-"+ (mm[1]?mm:"0"+mm[0]) +"-"+ (dd[1]?dd:"0"+dd[0]); // padding
  };

d = new Date();

    //alert();
    document.getElementById("suser").value = populate[3];
    document.getElementById("callfor").value = populate[4];
    document.getElementById("contactCompany").value = populate[5];
    document.getElementById("lead").value = populate[6];
    document.getElementById("opportunity").value = populate[7];
</script>
<script src="js/jquery.js"></script>
<script src="js/jquery-1.8.3.min.js"></script>
<script src="bs3/js/bootstrap.min.js"></script>
<script src="js/jquery-ui-1.9.2.custom.min.js"></script>
<script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/easypiechart/jquery.easypiechart.js"></script>
<script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<script src="js/jquery.nicescroll.js"></script>

<script src="js/bootstrap-switch.js"></script>

<script type="text/javascript" src="js/fuelux/js/spinner.min.js"></script>
<script type="text/javascript" src="js/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="js/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="js/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>

<script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->

<!--clock init-->
<!--common script init for all pages-->
<script src="js/scripts.js"></script>
<script src="js/toggle-init.js"></script>

<script src="js/advanced-form.js"></script>
</body>

<!-- Mirrored from bucketadmin.themebucket.net/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 31 Jul 2014 11:12:48 GMT -->
</html>
<?php require_once("includes/footer.php"); ?>