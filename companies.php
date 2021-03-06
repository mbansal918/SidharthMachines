<?php session_start(); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/constants.php"); ?>
<?php include("includes/checksession.php"); ?>
<?php include("MailChimp.php"); ?>


<?php
if(isset($_GET['cid']) && ($_SESSION['role']=='ADM' || $_SESSION['role']=='COH' || $_SESSION['role']=='BRH')){
	$cid = $_GET['cid'];
    $prequery = mysqli_query($connection, "SELECT * FROM companies WHERE companyid='$cid'");
    $r = mysqli_fetch_array($prequery);
    if($_SESSION['role'] == 'BRH' && $r['branch'] == getbranchbyid($_SESSION['role'], $connection))
        $query = mysqli_query($connection, "DELETE FROM companies WHERE companyid='$cid'");
    if($_SESSION['role']=='ADM' || $_SESSION['role']=='COH')
        $query = mysqli_query($connection, "DELETE FROM companies WHERE companyid='$cid'");

    $email = $r['email'];
    $api = '834fa0f70901971dedfc9919ecedb094-us10';
    $MailChimp = new \Drewm\MailChimp($api);
    $result = $MailChimp->call('lists/unsubscribe', array(
                    'id'                => 'f2131d3e92',
                    'email'             => array('email'=>$email),
                    //'merge_vars'        => array('FNAME'=>'Davy', 'LNAME'=>'Jones'),
                    'delete_member'      => true
                
                ));
}

?>

<?php

if(isset($_POST['editsubmit'])){
    $companyid = intval($_POST['companyid']);
    $name = mysql_prep($_POST['name'],$connection);
    $type = mysql_prep($_POST['type'],$connection);
    $oname = mysql_prep($_POST['oname'],$connection);
    $branch = mysql_prep($_POST['branch'],$connection);
    $add1 = mysql_prep($_POST['add1'], $connection);
    $email = mysql_prep($_POST['email'],$connection);
    $add2 = mysql_prep($_POST['add2'],$connection);
    $bphone = mysql_prep($_POST['bphone'],$connection);
    $city = mysql_prep($_POST['city'],$connection);
    $mobile = mysql_prep($_POST['mobile'],$connection);
    $pin = intval($_POST['pin']);
    $phone2 = mysql_prep($_POST['phone2'],$connection);
    $state = mysql_prep($_POST['state'],$connection);
    $fax = mysql_prep($_POST['fax'],$connection);
    $country = mysql_prep($_POST['country'],$connection);
    $url = mysql_prep($_POST['url'],$connection);
    $source = mysql_prep($_POST['source'],$connection);
    $segment = mysql_prep($_POST['segment'],$connection);
    $remarks = mysql_prep($_POST['remarks'],$connection);
    $experience = mysql_prep($_POST['experience'],$connection);

    $address = $add1.",".$add2.",".$city.",".$state;
    
    $data_arr = geocode($address);
 
    // if able to geocode the address
    if($data_arr){
         
        $latitude = $data_arr[0];
        $longitude = $data_arr[1];
    }

    $prequery = mysqli_query($connection, "DELETE FROM companies WHERE companyid='$companyid'");
    $query = mysqli_query($connection, "INSERT INTO companies VALUES ('$companyid','$name', '$oname', '$add1', '$add2', '$city', $pin, '$state', '$country', '$source', '$remarks', '$type', '$branch', '$email', '$bphone', '$mobile', '$phone2', '$fax', '$url', '$segment', '$experience', '$latitude', '$longitude')");

    $api = '834fa0f70901971dedfc9919ecedb094-us10';
    $MailChimp = new \Drewm\MailChimp($api);
    $result = $MailChimp->call('lists/subscribe', array(
                    'id'                => 'f2131d3e92',
                    'email'             => array('email'=>$email),
                    //'merge_vars'        => array('FNAME'=>'Davy', 'LNAME'=>'Jones'),
                    'double_optin'      => false,
                    'update_existing'   => true,
                    'replace_interests' => false,
                    'send_welcome'      => false,
                ));
    
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

    <title>Companies</title>

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
            var Company = document.getElementById("row"+id).cells[20].innerHTML;
            var Owner = document.getElementById("row"+id).cells[1].innerHTML;
            var Email = document.getElementById("row"+id).cells[2].innerHTML;
            var Phone = document.getElementById("row"+id).cells[3].innerHTML;
            var Mobile = document.getElementById("row"+id).cells[4].innerHTML;
            var City = document.getElementById("row"+id).cells[5].innerHTML;
            var Type = document.getElementById("row"+id).cells[6].innerHTML;
            var Branch = document.getElementById("row"+id).cells[7].innerHTML;
            var Source = document.getElementById("row"+id).cells[8].innerHTML;
            var Segment = document.getElementById("row"+id).cells[9].innerHTML;
            var add1 = document.getElementById("row"+id).cells[10].innerHTML;
            var add2 = document.getElementById("row"+id).cells[11].innerHTML;
            var pcode = document.getElementById("row"+id).cells[12].innerHTML;
            var state = document.getElementById("row"+id).cells[13].innerHTML;
            var country = document.getElementById("row"+id).cells[14].innerHTML;
            var remarks = document.getElementById("row"+id).cells[15].innerHTML;
            var phone2 = document.getElementById("row"+id).cells[16].innerHTML;
            var fax = document.getElementById("row"+id).cells[17].innerHTML;
            var website = document.getElementById("row"+id).cells[18].innerHTML;
            var experience = document.getElementById("row"+id).cells[19].innerHTML;
            document.getElementById("companyid").value = id;
            document.getElementById("cname").value = Company;
            document.getElementById("coname").value = Owner;
            document.getElementById("cemail").value = Email;
            document.getElementById("cbphone").value = Phone;
            document.getElementById("cmobile").value = Mobile;
            document.getElementById("ccity").value = City;
            document.getElementById("ctype").value = Type;
            document.getElementById("cbranch").value = Branch;
            document.getElementById("csource").value = Source;
            document.getElementById("csegment").value = Segment;
            document.getElementById("cadd1").value = add1;
            document.getElementById("cadd2").value = add2;
            document.getElementById("cpin").value = pcode;
            document.getElementById("cstate").value = state;
            document.getElementById("ccountry").value = country;
            document.getElementById("cremarks").value = remarks;
            document.getElementById("cphone2").value = phone2;
            document.getElementById("cfax").value = fax;
            document.getElementById("curl   ").value = website;
            document.getElementById("cexperience").value = experience;

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
                <section class="panel"  style="min-width: 1024px;">
                    <header class="panel-heading">
                        Companies
                    </header>
                    <div class="panel-body">
                    <div class="adv-table">
                    <div class="btn-group">
                    <?php if($_SESSION['role']=='ADM'||$_SESSION['role']=='COH' || $_SESSION['role']=='BRH'){ ?>
					<a href="newcompany.php">
                        <button id="editable-sample_new" class="btn btn-primary">
                            Add New Company <i class="fa fa-plus"></i>
                        </button>
					<a/>
                    <?php } ?>
                    </div>
                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                    <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Owner Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Mobile</th>
                        <th>City</th>
                        <th>Type</th>
                        <th>Branch</th>
                        <th>Source</th>
                        <th>Segment</th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <?php if($_SESSION['role']=='ADM'||$_SESSION['role']=='COH'||$_SESSION['role']=='BRH'){ ?>
                        <th>Edit</th>
                        <th>Delete</th>
                        <?php } ?>
                        </tr>
                        <thead>
                        <tr class="gradeX" id="row1">
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
                        <?php if($_SESSION['role']=='ADM'||$_SESSION['role']=='COH'||$_SESSION['role']=='BRH'){ ?>
                        <td></td>
                        <td></td>
                        <?php } ?>
                        </tr>                    
                    </thead>
					<tbody>
                    <?php
                        $exec = "SELECT * FROM companies ";
                        if($_SESSION['role']=='BRH' || $_SESSION['role']=='SAE'){
                            $br = getbranchbyid($_SESSION['user'], $connection);
                            $exec = $exec."WHERE branch='$br'";
                        }
                        $query = mysqli_query($connection, $exec);
                        $rows = mysqli_num_rows($query);
                        for($i=0 ; $i<$rows ; $i++){
                            $result = mysqli_fetch_array($query);
                    ?>
                    <tr id="<?php echo "row".$result[0] ; ?>" class="gradeX">
                        <td><a href='companydetails.php?company=<?php echo $result[0]; ?>'><?php echo $result[1] ; ?></a></td>
                        <td><?php echo $result[2] ; ?></td>
                        <td><?php echo $result[13] ; ?></td>
                        <td><?php echo $result[14] ; ?></td>
                        <td><?php echo $result[15] ; ?></td>
                        <td><?php echo $result[5] ; ?></td>
                        <td><?php echo $result[11] ; ?></td>
                        <td><?php echo $result[12] ; ?></td>
                        <td><?php echo $result[9] ; ?></td>
                        <td><?php echo $result[19] ; ?></td>
                        <td hidden><?php echo $result[3] ; ?></td>
                        <td hidden><?php echo $result[4] ; ?></td>
                        <td hidden><?php echo $result[6] ; ?></td>
                        <td hidden><?php echo $result[7] ; ?></td>
                        <td hidden><?php echo $result[8] ; ?></td>
                        <td hidden><?php echo $result[10] ; ?></td>
                        <td hidden><?php echo $result[16] ; ?></td>
                        <td hidden><?php echo $result[17] ; ?></td>
                        <td hidden><?php echo $result[18] ; ?></td>
                        <td hidden><?php echo $result[20] ; ?></td>
                        <td hidden><?php echo $result[1] ; ?></td>
                        <?php if($_SESSION['role']=='ADM'||$_SESSION['role']=='COH'||$_SESSION['role']=='BRH'){ ?>
                        <td><a class="edit" id="<?php echo $result[0] ; ?>" href="#myModal-1" data-toggle="modal" onclick="populateForm(this.id)">Edit</a></td>
                        <td><a class="delete" href="companies.php?cid=<?php echo $result[0] ; ?>" onclick="return confirm('Delete Company?')">Delete</a></td>
                        <?php } ?>
                    </tr>
					
					<?php } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Company Name</th>
                        <th>Owner Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Mobile</th>
                        <th>City</th>
                        <th>Type</th>
                        <th>Branch</th>
                        <th>Source</th>
                        <th>Segment</th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <th hidden></th>
                        <?php if($_SESSION['role']=='ADM'||$_SESSION['role']=='COH'||$_SESSION['role']=='BRH'){ ?>
                        <th>Edit</th>
                        <th>Delete</th>
                        <?php } ?>
                    </tr>
                    </tfoot>
                    </table>
                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-1" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content" style="margin-left: -26.5%;width: 150%;">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Edit Company</h4>
                        </div>
                        <div class="modal-body">

                            <form class="form-horizontal" method="post" role="form">
                                <div class="form-group ">
                                        <label for="cname" class="control-label col-lg-3">Company Name</label>
                                        <div class="col-lg-3">
                                            <input class=" form-control" id="cname" name="name" minlength="2" type="text" required />
                                        </div>
                                        <label for="ctype" class="control-label col-lg-3">Type</label>
                                        <div class="col-lg-3">
                                            <select class="form-control" name="type"  id="ctype" required>
                                                <option value="Our Machine Holder">Our Machine Holder</option>
                                                <option value="Prospect">Prospect</option>
                                                <option value="Lead">Lead</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="coname" class="control-label col-lg-3">Owner Name</label>
                                        <div class="col-lg-3">
                                            <input class="form-control " id="coname" type="text" name="oname" />
                                        </div>
                                        <label for="cbranch" class="control-label col-lg-3">Branch</label>
                                        <div class="col-lg-3">
                                            <select class="form-control" name="branch" id="cbranch" required>
                                                <?php
                                                    $query = mysqli_query($connection, "SELECT branchname FROM branches");
                                                    $rows = mysqli_num_rows($query);
                                                    for($i = 0; $i < $rows ; $i++){
                                                        $result = mysqli_fetch_array($query);
                                                ?>
                                                    <option value="<?php echo $result[0] ; ?>"><?php echo $result[0] ; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="cadd1" class="control-label col-lg-3">Address1</label>
                                        <div class="col-lg-3">
                                            <input class="form-control " id="cadd1" type="text" name="add1" />
                                        </div>
                                        <label for="cemail" class="control-label col-lg-3">Email-Id</label>
                                        <div class="col-lg-3">
                                            <input class="form-control " id="cemail" type="email" name="email" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="cadd2" class="control-label col-lg-3">Address2</label>
                                        <div class="col-lg-3">
                                            <input class="form-control " id="cadd2" type="text" name="add2" />
                                        </div>
                                        <label for="cbphone" class="control-label col-lg-3">Business Phone</label>
                                        <div class="col-lg-3">
                                            <input class="form-control " id="cbphone" type="number" name="bphone" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="ccity" class="control-label col-lg-3">City</label>
                                        <div class="col-lg-3">
                                            <input class="form-control " id="ccity" type="text" name="city" />
                                        </div>
                                        <label for="cmobile" class="control-label col-lg-3">Mobile</label>
                                        <div class="col-lg-3">
                                            <input class="form-control " id="cmobile" type="number" name="mobile" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="cpin" class="control-label col-lg-3">Pincode</label>
                                        <div class="col-lg-3">
                                            <input class="form-control " id="cpin" type="number" name="pin" />
                                        </div>
                                        <label for="cphone2" class="control-label col-lg-3">Phone2</label>
                                        <div class="col-lg-3">
                                            <input class="form-control " id="cphone2" type="number" name="phone2" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="cstate" class="control-label col-lg-3">State</label>
                                        <div class="col-lg-3">
                                            <input class="form-control " id="cstate" type="text" name="state" />
                                        </div>
                                        <label for="cfax" class="control-label col-lg-3">Fax</label>
                                        <div class="col-lg-3">
                                            <input class="form-control " id="cfax" type="number" name="fax" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="ccountry" class="control-label col-lg-3">Country</label>
                                        <div class="col-lg-3">
                                            <input class="form-control " id="ccountry" type="text" name="country" />
                                        </div>
                                         <label for="curl" class="control-label col-lg-3">Website</label>
                                        <div class="col-lg-3">
                                            <input class="form-control " id="curl" type="url" name="url" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="csource" class="control-label col-lg-3">Source</label>
                                        <div class="col-lg-3">
                                            <select class="form-control"  id="csource" name="source" required>
                                                <?php
                                                    $query = mysqli_query($connection, "SELECT value FROM sources");
                                                    $rows = mysqli_num_rows($query);
                                                    for($i = 0; $i < $rows ; $i++){
                                                        $result = mysqli_fetch_array($query);
                                                ?>
                                                    <option value="<?php echo $result[0] ; ?>"><?php echo $result[0] ; ?></option>
                                                <?php }  ?>
                                            </select>
                                        </div>
                                        <label for="csegment" class="control-label col-lg-3">Segment</label>
                                        <div class="col-lg-3">
                                            <select class="form-control"  id="csegment" name="segment" required>
                                                <?php
                                                    $query = mysqli_query($connection, "SELECT segment FROM segments");
                                                    $rows = mysqli_num_rows($query);
                                                    for($i = 0; $i < $rows ; $i++){
                                                        $result = mysqli_fetch_array($query);
                                                ?>
                                                    <option value="<?php echo $result[0] ; ?>"><?php echo $result[0] ; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="cremarks" class="control-label col-lg-3">Remarks</label>
                                        <div class="col-lg-3">
                                            <textarea class="form-control " id="cremarks" name="remarks"></textarea>
                                        </div>
                                        <label for="cexperience" class="control-label col-lg-3">Experience</label>
                                        <div class="col-lg-3">
                                            <textarea class="form-control " id="cexperience" name="experience"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                            <input class="form-control" id="companyid" type="hidden" name="companyid" />
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