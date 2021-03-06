<?php session_start(); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/constants.php"); ?>
<?php include("includes/checksession.php"); ?>

<?php
if(isset($_GET['siid']) && ($_SESSION['role']=='COH'||$_SESSION['role']=='ADM'||$_SESSION['role']=='BRH')){
	$siid = $_GET['siid'];
    $pre = mysqli_query($connection, "SELECT branch FROM setupinformation WHERE setupinfoid='$siid'");
    $r = mysqli_fetch_array($pre);
    if($r['branch'] == getbranchbyid($_SESSION['user'], $connection) && $_SESSION['role']=='BRH')
        $query = mysqli_query($connection, "DELETE FROM setupinformation WHERE setupinfoid='$siid'");
    if($_SESSION['role']=='COH'||$_SESSION['role']=='ADM')
        $query = mysqli_query($connection, "DELETE FROM setupinformation WHERE setupinfoid='$siid'");
}

?>

<?php
if(isset($_POST['editsubmit'])){
    $company = mysql_prep($_POST['company'], $connection);
    $manufacturer = mysql_prep($_POST['manufacturer'], $connection);
    $place = mysql_prep($_POST['place'], $connection);
    $date = mysql_prep($_POST['date'], $connection);
    $machine = mysql_prep($_POST['machine'], $connection);
    $model = mysql_prep($_POST['model'], $connection);
    $size = mysql_prep($_POST['size'], $connection);
    $head = mysql_prep($_POST['head'], $connection);
    $mnumber = mysql_prep($_POST['mnumber'], $connection);
    $warranty = mysql_prep($_POST['warranty'], $connection);
    $ink = mysql_prep($_POST['ink'], $connection);
    $software = mysql_prep($_POST['software'], $connection);
    $mremarks = mysql_prep($_POST['mremarks'], $connection);
    $branch = getbranchbyid($_SESSION['user'], $connection);
    $setupid = intval($_POST['setupid']);
        
    $prequery = mysqli_query($connection, "DELETE FROM setupinformation WHERE setupinfoid='$setupid'");
    $query = mysqli_query($connection, "INSERT INTO setupinformation VALUES ('$setupid','$company', '$manufacturer', STR_TO_DATE('$date', '%Y-%m-%d'), '$place', '$machine', '$model', '$size', '$head', '$mnumber', '$warranty', '$ink', '$software', '$mremarks', '$branch')");   
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

    <title>Setup Information</title>

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
            for(var i = 0; i < 15; i++) {
                values[i] = document.getElementById("row"+id).cells[i].innerHTML; 
            }
            document.getElementById("date").value = values[0];
            document.getElementById("company").value = values[14];
            document.getElementById("manufacturer").value = values[2];
            document.getElementById("machine").value = values[3];
            document.getElementById("mnumber").value = values[4];
            document.getElementById("ink").value = values[5];
            document.getElementById("place").value = values[7];
            document.getElementById("mremarks").value = values[8];
            document.getElementById("model").value = values[9];
            document.getElementById("size").value = values[10];
            document.getElementById("head").value = values[11];
            document.getElementById("warranty").value = values[12];
            document.getElementById("software").value = values[13];
            document.getElementById("setupid").value = id;
            
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
</head>
<?php include("includes/sidebar.php"); ?>
<section id="main-content">
        <section class="wrapper">
            <!-- page start-->
            <div class="row">
            <div class="col-sm-12">
                <section class="panel" style="min-width: 1024px;">
                    <header class="panel-heading">
                        Setup Information
                    </header>
                    <div class="panel-body">
                    <div class="adv-table">
                    <div class="btn-group">
					<?php if($_SESSION['role']!='SAE'){ 
                    ?>
                    <a href="newsetupinfo.php">
                        <button id="editable-sample_new" class="btn btn-primary">
                            Add New Setup<i class="fa fa-plus"></i>
                        </button>
                    </a>
                    <?php } ?>
					</div>
                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                    <thead>
                    <tr>
                        <th>Installation Date</th>
                        <th>Company</th>
                        <th>Manufacturer</th>
                        <th>Machine Name</th>
                        <th>Machine Number</th>
                        <th>Ink</th>
                        <th>Branch</th>
                        <th>City</th>
                        <th>Remarks</th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <?php if($_SESSION['role']!='SAE'){  ?>
                        <th>Edit</th>
                        <th>Delete</th>
                        <?php } ?>
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
                        <?php if($_SESSION['role']!='SAE'){ ?>
                        <td></td>
                        <td></td>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
					<?php
                        $exec = "SELECT * FROM setupinformation ";
                        if($_SESSION['role']=='BRH'||$_SESSION['role']=='SAE'){
                            $branch = getbranchbyid($_SESSION['user'], $connection);
                            $exec = $exec."WHERE branch='$branch'";
                        }
						$query = mysqli_query($connection, $exec);
						$rows = mysqli_num_rows($query);
						for($i=0 ; $i<$rows ; $i++){
							$result = mysqli_fetch_array($query);
                            $q2 = mysqli_query($connection, "SELECT companyname FROM companies WHERE companyid='$result[1]'");
                            $r2 = mysqli_fetch_array($q2);
					?>
                    <tr class="gradeX"  id = "<?php echo "row".$result[0] ?>">
                        <td><?php echo $result[3] ; ?></td>
                        <td><?php echo $r2[0] ; ?></td>
                        <td><?php echo $result[2] ; ?></td>
                        <td><?php echo $result[5] ; ?></td>
                        <td><?php echo $result[9] ; ?></td>
                        <td><?php echo $result[11] ; ?></td>
                        <td><?php echo $result[14] ; ?></td>
                        <td><?php echo $result[4] ; ?></td>
                        <td><?php echo $result[13] ; ?></td>
                        <td hidden><?php echo $result[6] ; ?></td>
                        <td hidden><?php echo $result[7] ; ?></td>
                        <td hidden><?php echo $result[8] ; ?></td>
                        <td hidden><?php echo $result[10] ; ?></td>
                        <td hidden><?php echo $result[12] ; ?></td>
                        <td hidden><?php echo $result[1] ; ?></td>
                        <?php if($_SESSION['role']!='SAE'){ ?>
                        <td><a class="edit" href="#myModal-1"  id="<?php echo $result[0] ?>" onclick="populateForm(this.id)" data-toggle="modal">Edit</a></td>
                        <td><a class="delete" href="setupinfo.php?siid=<?php echo $result[0] ; ?>" onclick="return confirm('Delete Setup Info?')">Delete</a></td>
                        <?php } ?>
                    </tr>
                    <?php } ?>
					</tbody>
                    <tfoot>
                    <tr>
                        <th>Installation Date</th>
                        <th>Company</th>
                        <th>Manufacturer</th>
                        <th>Machine Name</th>
                        <th>Machine Number</th>
                        <th>Ink</th>
                        <th>Branch</th>
                        <th>City</th>
                        <th>Remarks</th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <?php if($_SESSION['role']!='SAE'){ ?>
                        <th>Edit</th>
                        <th>Delete</th>
                        <?php } ?>
                    </tr>
                    </tfoot>
                    </table>
                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-1" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Edit Setup</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form class="form-horizontal" method="post" role="form">
                                            <div class="form-group ">
                                        <label for="contactCompany" class="control-label col-lg-3">Company</label>
                                        <div class="col-lg-6">
                                            <select class="form-control" name="company" id="company" required>
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
                                    <div class="form-group ">
                                        <label for="manufacturer" class="control-label col-lg-3">Manufacturer</label>
                                        <div class="col-lg-6">
                                            <input class="form-control " id="manufacturer" type="text" name="manufacturer" required/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="place" class="control-label col-lg-3">Place</label>
                                        <div class="col-lg-6">
                                            <input class="form-control " id="place" type="text" name="place" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Installation Date</label>
                                        <div class="col-md-6 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker" id="date" name="date"  size="16" type="text" value="" />
                                            <!-- <span class="help-block">Select date</span> -->
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="mname" class="control-label col-lg-3">Machine Name</label>
                                        <div class="col-lg-6">
                                            <input class="form-control " id="machine" type="text" name="machine" required />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="mmodel" class="control-label col-lg-3">Model</label>
                                        <div class="col-lg-6">
                                            <input class="form-control " id="model" type="text" name="model"/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="msize" class="control-label col-lg-3">Size</label>
                                        <div class="col-lg-6">
                                            <input class="form-control " id="size" type="text" name="size"/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="mhead" class="control-label col-lg-3">Head</label>
                                        <div class="col-lg-6">
                                            <input class="form-control " id="head" type="text" name="head"/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="mno" class="control-label col-lg-3">Machine Number</label>
                                        <div class="col-lg-6">
                                            <input class="form-control " id="mnumber" type="text" name="mnumber"/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="warranty" class="control-label col-lg-3">Warranty Status</label>
                                        <div class="col-lg-6">
                                            <input class="form-control " id="warranty" type="text" name="warranty"/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="mink" class="control-label col-lg-3">Ink</label>
                                        <div class="col-lg-6">
                                            <input class="form-control " id="ink" type="text" name="ink"/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="msoftware" class="control-label col-lg-3">Software</label>
                                        <div class="col-lg-6">
                                            <input class="form-control " id="software" type="text" name="software"/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="mremarks" class="control-label col-lg-3">Remarks</label>
                                        <div class="col-lg-6">
                                            <textarea class="form-control " id="mremarks" name="mremarks"></textarea>
                                        </div>
                                        <div class="col-lg-3">
                                            <input class="form-control" id="setupid" type="hidden" name="setupid" />
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
<script src="js/bootstrap-switch.js"></script>

<script type="text/javascript" src="js/fuelux/js/spinner.min.js"></script>
<script type="text/javascript" src="js/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="js/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="js/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>

<script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->

<script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
<!--common script init for all pages-->
<script src="js/scripts.js"></script>

<!--dynamic table initialization -->
<script src="js/dynamic_table_init.js"></script>
<script src="js/toggle-init.js"></script>

<script src="js/advanced-form.js"></script>
</body>

<!-- Mirrored from bucketadmin.themebucket.net/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 31 Jul 2014 11:12:48 GMT -->
</html>
<?php require_once("includes/footer.php"); ?>