<?php session_start(); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/constants.php"); ?>
<?php include("includes/checksession.php"); ?>

<?php
if(isset($_GET['cid'])){
	$cid = $_GET['cid'];
    $query = mysqli_query($connection, "DELETE FROM calls WHERE callid='$cid'");
}

?>

<?php

if(isset($_POST['editsubmit'])){
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
    $callid = intval($_POST['callid']);
    $followedup = mysql_prep($_POST['followedup'], $connection);

    $prequery = mysqli_query($connection, "DELETE FROM calls WHERE callid='$callid'");
    $query = mysqli_query($connection, "INSERT INTO calls VALUES ('$callid', STR_TO_DATE('$calldate', '%m-%d-%Y'), '$mode', '$user', '$for', '$company', '$lead', '$opportunity', '$notes', STR_TO_DATE('$followup', '%m-%d-%Y'),'$followedup','$branch')");
    echo mysqli_error($connection);
}

?>

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from bucketadmin.themebucket.net/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 31 Jul 2014 11:12:06 GMT -->
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.html">

    <title>Calls</title>

    <!--Core CSS -->
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
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

    <!--dynamic table-->
    <link href="js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />

    <!-- Custom styles for this template -->
    <link href="css/style1.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
    <script type="text/javascript">
        function populateForm(id) {
            var values = [];
            for(var i = 0; i < 16; i++) {
                values[i] = document.getElementById("row"+id).cells[i].innerHTML; 
            }
            var yyyy = values[0].substring(0,4);                                    
            var mm = values[0].substring(5,7); // getMonth() is zero-based         
            var dd  = values[0].substring(8,10);             
                            
            var calldate =  mm + '-' + dd + '-' + yyyy;
            document.getElementById("calldate").value =  calldate;
            document.getElementById("callMode").value = values[13];
            document.getElementById("callfor").value = values[2];
            document.getElementById("contactCompany").value = values[11];
            document.getElementById("opportunity").value = values[14];
            document.getElementById("suser").value = values[12];
            document.getElementById("callNotes").value = values[6];
            var yyyy = values[8].substring(0,4);                                    
            var mm = values[8].substring(5,7); // getMonth() is zero-based         
            var dd  = values[8].substring(8,10);             
                            
            var followdate =  mm + '-' + dd + '-' + yyyy;
            document.getElementById("followup").value = followdate;
            document.getElementById("lead").value = values[10];
            document.getElementById("followedup").value = values[15];
            document.getElementById("callid").value = id;


            }
        function searchRows(tblId) {
            var tbl = document.getElementById(tblId);
            var headRow = tbl.rows[1];
            var arrayOfHTxt = new Array();
            var arrayOfHtxtCellIndex = new Array();

            for (var v = 0; v < headRow.cells.length-2; v++) {
             if (headRow.cells[v].getElementsByTagName('input')[0]) {
             var Htxtbox = headRow.cells[v].getElementsByTagName('input')[0];
              if (Htxtbox.value.replace(/^\s+|\s+$/g, '') != '') {
                arrayOfHTxt.push(Htxtbox.value.replace(/^\s+|\s+$/g, ''));
                arrayOfHtxtCellIndex.push(v);
              }
             }
            }

            for (var i = 2; i < tbl.rows.length; i++) {             
                tbl.rows[i].style.display = 'table-row';
                for (var v = 0; v < arrayOfHTxt.length; v++) {
                    var CurCell = tbl.rows[i].cells[arrayOfHtxtCellIndex[v]];
                    var CurCont = CurCell.innerHTML.replace(/<[^>]+>/g, "");
                    var reg = new RegExp(arrayOfHTxt[v] + ".*", "i");
                    if (CurCont.match(reg) == null) {
                        tbl.rows[i].style.display = 'none';
                    }
                }
            }
        } 
    </script>
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
            <div class="col-sm-12">
                <section class="panel" style="min-width: 1024px;">
                    <header class="panel-heading">
                        Calls
                    </header>
                    <div class="panel-body">
                    <div class="adv-table">
                    <div class="btn-group">
					<a href="newcall.php">
                        <button id="editable-sample_new" class="btn btn-primary">
                            Add Call <i class="fa fa-plus"></i>
                        </button>
                    </a>
					</div>
                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                    <thead>
                    <tr>
                        <th>Date</th> 
                        <th>Mode</th>
                        <th>For</th>
                        <th>Company</th>
                        <th>Opportunity Name</th>
                        <th>By</th>
                        <th>Notes</th>
                        <th>Branch</th>
                        <th>Next Follow Up</th>
                        <th>Followed Up</th> 
                        <th hidden></th> 
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th> 
                        <th hidden></th> 
                        <th>Follow Up/Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <thead>
                        <tr class="gradeX">
                        <td><input class="form-control input-sm m-bot15" type="text" style="width: 100%" onkeyup="searchRows('dynamic-table')"></td>
                        <td><input class="form-control input-sm m-bot15" type="text" style="width: 100%" onkeyup="searchRows('dynamic-table')"></td>
                        <td><input class="form-control input-sm m-bot15" type="text" style="width: 100%" onkeyup="searchRows('dynamic-table')"></td>
                        <td><input class="form-control input-sm m-bot15" type="text" style="width: 100%" onkeyup="searchRows('dynamic-table')"></td>
                        <td><input class="form-control input-sm m-bot15" type="text" style="width: 100%" onkeyup="searchRows('dynamic-table')"></td>
                        <td><input class="form-control input-sm m-bot15" type="text" style="width: 100%" onkeyup="searchRows('dynamic-table')"></td>
                        <td><input class="form-control input-sm m-bot15" type="text" style="width: 100%" onkeyup="searchRows('dynamic-table')"></td>
                        <td><input class="form-control input-sm m-bot15" type="text" style="width: 100%" onkeyup="searchRows('dynamic-table')"></td>
                        <td><input class="form-control input-sm m-bot15" type="text" style="width: 100%" onkeyup="searchRows('dynamic-table')"></td>
                        <td><input class="form-control input-sm m-bot15" type="text" style="width: 100%" onkeyup="searchRows('dynamic-table')"></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
					<?php
						$query = mysqli_query($connection, "SELECT * FROM calls");
						$rows = mysqli_num_rows($query);
						for($i=0 ; $i<$rows ; $i++){
								$result = mysqli_fetch_array($query);
                                $q2 = mysqli_query($connection, "SELECT companyname FROM companies WHERE companyid='$result[5]'");
                                $r2 = mysqli_fetch_array($q2);
                                $q3 = mysqli_query($connection, "SELECT value FROM callmodes WHERE modeid='$result[2]'");
                                $r3 = mysqli_fetch_array($q3);
                                $q4 = mysqli_query($connection, "SELECT opportunityname FROM opportunities WHERE opportunityid='$result[7]'");
                                $r4 = mysqli_fetch_array($q4);
					?>
                    <tr class="gradeX"  id="<?php echo "row".$result[0] ?>">
                        <td><?php echo $result[1]; ?></td>
                        <td><?php echo $r3[0]; ?></td>
                        <td><?php echo $result[4]; ?></td>
                        <td><?php echo $r2[0]; ?></td>
                        <td><?php echo $r4[0]; ?></td>
                        <td><?php echo getnamebyid($result[3], $connection); ?></td>
                        <td><?php echo $result[8]; ?></td>
                        <td><?php echo $result[11]; ?></td>
                        <td><?php echo $result[9]; ?></td>
						<?php if($result[10] == "Yes") {?>
						<td><span class="label label-success">Yes</span></td>
						<?php } else if($result[10] == "No"){ ?>
                        <td><span class="label label-danger">No</span></td>
						<?php } ?>
                        <td hidden><?php echo $result[6]; ?></td>
                        <td hidden><?php echo $result[5]; ?></td>
                        <td hidden><?php echo $result[3]; ?></td>
                        <td hidden><?php echo $result[2]; ?></td>
                        <td hidden><?php echo $result[7]; ?></td>
                        <td hidden><?php echo $result[10]; ?></td>
						<td><a class="edit" href="newcall.php?cid=<?php echo $result[0] ; ?>" href="">Follow Up</a><br><a class="edit" href="#myModal-1" data-toggle="modal"  id="<?php echo $result[0]; ?>" onclick="populateForm(this.id)">Edit</a></td>
                        <td><a class="delete" href="calls.php?cid=<?php echo $result[0] ; ?>" onclick="return confirm('Delete Call?')">Delete</a></td>
                    </tr>
					<?php  } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Date</th> 
                        <th>Mode</th>
                        <th>For</th>
                        <th>Company</th>
                        <th>Opportunity Name</th>
                        <th>By</th>
                        <th>Notes</th>
                        <th>Branch</th>
                        <th>Next Follow Up</th>  
                        <th>Followed Up</th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th>Follow Up/Edit</th>
                        <th>Delete</th>
                    </tr>
                    </tfoot>
                    </table>
                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-1" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Edit Call</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form class="form-horizontal" method="post" role="form">
                                            <div class="form-group">
                                        <label class="control-label col-md-3">Call Date</label>
                                        <div class="col-md-6 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker" id="calldate" name="calldate"  size="16" type="text" value="" required/>
                                            <!-- <span class="help-block">Select date</span> -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Next Follow Up Call</label>
                                        <div class="col-md-6 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker" id="followup" name="followup" size="16" type="text" value="" />
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
                                            <select class="form-control" name="user" id="suser" required>
                                                <?php
                                                    $query = mysqli_query($connection, "SELECT * FROM users");
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
                                            <select class="form-control" name="for" id="callfor" required>
                                                <option value="Customer">Customer</option>
                                                <option value="Opportunity">Opportunity</option>
                                                <option value="Lead">Lead</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="contactCompany" class="control-label col-lg-3">Company</label>
                                        <div class="col-lg-6">
                                            <select class="form-control" name="company" id="contactCompany" onchange="show(this.value)" required>
                                                <?php
                                                    $query = mysqli_query($connection, "SELECT * FROM companies");
                                                    $rows = mysqli_num_rows($query);
                                                    for($i = 0; $i < $rows ; $i++){
                                                        $result = mysqli_fetch_array($query);
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
                                            <select class="form-control" id="lead" name="lead" required>
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
                                        <div class="col-lg-3">
                                            <input class="form-control" id="callid" type="hidden" name="callid" />
                                        </div>
                                        <div class="col-lg-3">
                                            <input class="form-control" id="followedup" type="hidden" name="followedup" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-6">
                                            <button class="btn btn-primary" name="editsubmit" type="submit">Save</button>
                                        </div>
                                    </div>
                                        </form>

                                    </div>

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
<script src="js/jquery.js"></script>
<script src="js/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
<script src="bs3/js/bootstrap.min.js"></script>
<script src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="js/bootstrap-switch.js"></script>

<script type="text/javascript" src="js/fuelux/js/spinner.min.js"></script>
<script type="text/javascript" src="js/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="js/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="js/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>

<script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
<!--common script init for all pages-->
<script src="js/scripts.js"></script>
<script src="js/iCheck/jquery.icheck.js"></script>

<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script> 

<!--dynamic table initialization -->
<script src="js/dynamic_table_init.js"></script>
<script src="js/toggle-init.js"></script>

<script src="js/advanced-form.js"></script>
</body>

<!-- Mirrored from bucketadmin.themebucket.net/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 31 Jul 2014 11:12:48 GMT -->
</html>
<?php require_once("includes/footer.php"); ?>