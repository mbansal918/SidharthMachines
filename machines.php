<?php session_start(); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/constants.php"); ?>
<?php include("includes/checksession.php"); ?>

<?php
if(isset($_GET['mid']) && $_SESSION['role']!='SAE'){
	$mid = $_GET['mid'];
    $query = mysqli_query($connection, "DELETE FROM machines WHERE machineid='$mid'");
}

?>

<?php
if(isset($_POST['editsubmit'])){
    $machine = mysql_prep($_POST['Machine'], $connection);
    $category = mysql_prep($_POST['category'], $connection);
    $description = mysql_prep($_POST['description'], $connection);
    $active = mysql_prep($_POST['active'], $connection);
    $machineid = intval($_POST['machineid']);
    
    $prequery = mysqli_query($connection, "DELETE FROM machines WHERE machineid='$machineid'");
    $query = mysqli_query($connection, "INSERT INTO machines VALUES ('$machineid','$machine', '$category', '$description', '$active')");  
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

    <title>Machines</title>

    <!--Core CSS -->
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />

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
            for(var i = 0; i < 4; i++) {
                values[i] = document.getElementById("row"+id).cells[i].innerHTML; 
            }
            document.getElementById("MachineName").value = values[0];
            document.getElementById("category").value = values[1];
            document.getElementById("mdes").value = values[2];
            document.getElementById("active").value = values[3];
            document.getElementById("machineid").value = id;
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
                <section class="panel">
                    <header class="panel-heading" style="min-width: 1024px;">
                        Machines
                    </header>
                    <div class="panel-body">
                    <div class="adv-table">
                    <div class="btn-group">
                    <?php if($_SESSION['role'] != 'SAE'){ ?>
					<a href="newmachine.php">
                        <button id="editable-sample_new" class="btn btn-primary">
                            Add New Machine <i class="fa fa-plus"></i>
                        </button>
                    </a>
					<?php } ?>
                    </div>
                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                    <thead>
                    <tr>
                        <th>Machine Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Active</th>
                        <?php if($_SESSION['role'] != 'SAE'){ ?>
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
                        <?php if($_SESSION['role'] != 'SAE'){ ?>
                        <td></td>
                        <td></td>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
					<?php
						$query = mysqli_query($connection, "SELECT * FROM machines");
						$rows = mysqli_num_rows($query);
						for($i=0 ; $i<$rows ; $i++){
							$result = mysqli_fetch_array($query);
					?>
                    <tr class="gradeX"  id="<?php echo "row".$result[0]; ?>">
                        <td><?php echo $result[1]; ?></td>
                        <td><?php echo $result[2]; ?></td>
                        <td><?php echo $result[3]; ?></td>
                        <td><?php echo $result[4]; ?></td>
                        <?php if($_SESSION['role'] != 'SAE'){ ?>
                        <td><a class="edit" href="#myModal-1" data-toggle="modal"  id="<?php echo $result[0]; ?>" onclick="populateForm(this.id)">Edit</a></td>
                        <td><a class="delete" href="machines.php?mid=<?php echo $result[0] ; ?>" onclick="return confirm('Delete Machine?')">Delete</a></td>
                        <?php } ?>
                    </tr>
					<?php } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Machine Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Active</th>
                        <?php if($_SESSION['role'] != 'SAE'){ ?>
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
                                        <h4 class="modal-title">Edit Machine</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form class="form-horizontal" method="post" role="form">
                                            <div class="form-group ">
                                        <label for="MachineName" class="control-label col-lg-3">Machine Name</label>
                                        <div class="col-lg-6">
                                            <input class="form-control " id="MachineName" type="text" name="Machine" required/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="category" class="control-label col-lg-3">Category</label>
                                        <div class="col-lg-6">
                                            <input class="form-control " id="category" type="text" name="category"/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="mdes" class="control-label col-lg-3">Description</label>
                                        <div class="col-lg-6">
                                            <textarea class="form-control " id="mdes" name="description"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="active" class="control-label col-lg-3">Active</label>
                                        <div class="col-lg-6">
                                            <select class="form-control"  id="active" name="active" required>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <input class="form-control" id="machineid" type="hidden" name="machineid" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-6">
                                            <button class="btn btn-primary" name="editsubmit" type="submit">Save</button>
                                            <button class="btn btn-default" type="button">Cancel</button>
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
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->

<script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
<!--common script init for all pages-->
<script src="js/scripts.js"></script>

<!--dynamic table initialization -->
<script src="js/dynamic_table_init.js"></script>
</body>

<!-- Mirrored from bucketadmin.themebucket.net/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 31 Jul 2014 11:12:48 GMT -->
</html>
<?php require_once("includes/footer.php"); ?>