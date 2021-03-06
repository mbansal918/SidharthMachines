<?php session_start(); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/constants.php"); ?>
<?php include("includes/checksession.php"); ?>

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from bucketadmin.themebucket.net/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 31 Jul 2014 11:12:06 GMT -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.html">

    <title>Welcome  </title>

    <!--Core CSS -->
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="js/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="js/jvector-map/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <link href="css/clndr.css" rel="stylesheet">
    <link href="js/css3clock/css/style.css" rel="stylesheet">
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="js/morris-chart/morris.css">
    <!--dynamic table-->
    <link href="js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/data-tables/DT_bootstrap.css" />

    <!-- Custom styles for this template -->
    <link href="css/style1.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
    <?php
        $exec = "SELECT * FROM opportunities ";
        if($_SESSION['role'] == 'BRH')
            {
                $mybranch = getbranchbyid($_SESSION['user'], $connection);
                $exec = $exec."WHERE branch='$mybranch'";
            }
        if($_SESSION['role'] == 'SAE')
            {
                $mybranch = getbranchbyid($_SESSION['user'], $connection);
                $me = $_SESSION['user'];
                $exec = $exec."WHERE branch='$mybranch' AND assignedto='$me'";
            }
        $q0 = mysqli_query($connection, $exec);
        $r0 = mysqli_num_rows($q0);
    ?> 
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>


    <?php
        $e1 = "SELECT * FROM opportunities WHERE status='Initial' ";
        if($_SESSION['role'] == 'BRH')
            {
                $mybranch = getbranchbyid($_SESSION['user'], $connection);
                $e1 = $e1."AND branch='$mybranch'";
            }
        if($_SESSION['role'] == 'SAE')
            {
                $mybranch = getbranchbyid($_SESSION['user'], $connection);
                $me = $_SESSION['user'];
                $e1 = $e1."AND branch='$mybranch' AND assignedto='$me'";
            }
        $q1 = mysqli_query($connection, $e1);
        $r1 = mysqli_num_rows($q1);
        $e2 = "SELECT * FROM opportunities WHERE status='Negotiation' ";
        if($_SESSION['role'] == 'BRH')
            {
                $mybranch = getbranchbyid($_SESSION['user'], $connection);
                $e2 = $e2."AND branch='$mybranch'";
            }
        if($_SESSION['role'] == 'SAE')
            {
                $mybranch = getbranchbyid($_SESSION['user'], $connection);
                $me = $_SESSION['user'];
                $e2 = $e2."AND branch='$mybranch' AND assignedto='$me'";
            }
        $q2 = mysqli_query($connection, $e2);
        $r2 = mysqli_num_rows($q2);
        $e3 = "SELECT * FROM opportunities WHERE status='Quoted' ";
        if($_SESSION['role'] == 'BRH')
            {
                $mybranch = getbranchbyid($_SESSION['user'], $connection);
                $exec = $exec."AND branch='$mybranch'";
            }
        if($_SESSION['role'] == 'SAE')
            {
                $mybranch = getbranchbyid($_SESSION['user'], $connection);
                $me = $_SESSION['user'];
                $e3 = $e3."AND branch='$mybranch' AND assignedto='$me'";
            }
        $q3 = mysqli_query($connection, $e3);
        $r3 = mysqli_num_rows($q3);
        $e4 = "SELECT * FROM opportunities WHERE status='Order Received' ";
        if($_SESSION['role'] == 'BRH')
            {
                $mybranch = getbranchbyid($_SESSION['user'], $connection);
                $e4 = $e4."AND branch='$mybranch'";
            }
        if($_SESSION['role'] == 'SAE')
            {
                $mybranch = getbranchbyid($_SESSION['user'], $connection);
                $me = $_SESSION['user'];
                $e4 = $e4."AND branch='$mybranch' AND assignedto='$me'";
            }
        $q4 = mysqli_query($connection, $e4);
        $r4 = mysqli_num_rows($q4);    
        ?>

        <script type="text/javascript">var n1 = Number("<?php echo $r1; ?>");</script>
        <script type="text/javascript">var n2 = Number("<?php echo $r2; ?>");</script>
        <script type="text/javascript">var n3 = Number("<?php echo $r3; ?>");</script>
        <script type="text/javascript">var n4 = Number("<?php echo $r4; ?>");</script>


<script type="text/javascript">

$(function () {
    $('#chart1').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Total Opportunities '.concat(Number("<?php echo $r0; ?>"))
        },
        xAxis: {
            categories: [
                'Initial',
                'Quoted',
                'Negotiation',
                'Order Received'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.0f} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Opportunities',
            data: [n1, n2, n3, n4]

        }]
    });
});
        </script>

        <?php
                $exec = "SELECT * FROM leads ";
                if($_SESSION['role'] == 'BRH'){
                    $bname = getbranchbyid($_SESSION['user'], $connection);
                    $exec = $exec."WHERE branch='$bname'";
                }
                if($_SESSION['role'] == 'SAE'){
                    $bname = getbranchbyid($_SESSION['user'], $connection);
                    $me = $_SESSION['user'];
                    $exec = $exec."WHERE branch='$bname' AND assignedto='$me'";
                }
                $query = mysqli_query($connection, $exec);
                $rows = 0;
                if($query != false)
                    $rows = mysqli_num_rows($query);


                $exec2 = "SELECT * FROM leads WHERE status='Converted' ";
                if($_SESSION['role'] == 'BRH'){
                    $bname = getbranchbyid($_SESSION['user'], $connection);
                    $exec2 = $exec2."AND branch='$bname'";
                }
                if($_SESSION['role'] == 'SAE'){
                    $bname = getbranchbyid($_SESSION['user'], $connection);
                    $me = $_SESSION['user'];
                    $exec2 = $exec2."AND branch='$bname' AND assignedto='$me'";
                }
                $query2 = mysqli_query($connection, $exec2);
                $rows2 = 0;
                if($query2 != false){
                    $rows2 = mysqli_num_rows($query2);
                }

                ?>

                 <script type="text/javascript">var totalleads = Number("<?php echo $rows; ?>");</script>
                 <script type="text/javascript">var conleads = Number("<?php echo $rows2; ?>");</script>
</head>
<?php include("includes/sidebar.php"); ?>

<section id="main-content">
        <section class="wrapper">
             <div class="row">
                <div class="col-md-3">
                    <section class="panel">
                        <div class="panel-body" > 
                            <div id="chart1" style="height:250px"></div>   
                        </div>
                    </section>
                </div>
                <div class="col-md-3">
                <section class="panel1" style="max-height: 280px;">
                    <div class="panel-body" style="margin-bottom: inherit;">
                        <div class="top-stats-panel">
                            <div class="gauge-canvas">
                                <h4 class="widget-h">Leads Converted to Opportunities</h4>
                                <div align="center">
                                    <canvas width=160 height=100 id="gauge" style="margin-top: 26px;margin-bottom: 26px;"></canvas>
                                </div>
                            </div>
                            <?php
                                        $exec = "SELECT * FROM leads ";
                                        if($_SESSION['role'] == 'BRH'){
                                            $bname = getbranchbyid($_SESSION['user'], $connection);
                                            $exec = $exec."WHERE branch='$bname'";
                                        }
                                        if($_SESSION['role'] == 'SAE'){
                                            $bname = getbranchbyid($_SESSION['user'], $connection);
                                            $me = $_SESSION['user'];
                                            $exec = $exec."WHERE branch='$bname' AND assignedto='$me'";
                                        }
                                        $query = mysqli_query($connection, $exec);
                                        $rows = 0;
                                        if($query != false)
                                            $rows = mysqli_num_rows($query);
                                    ?>
                            <ul class="gauge-meta clearfix">
                                <li id="gauge-textfield" class="pull-left gauge-value"></li>
                                <li class="pull-right gauge-title">Out of <?php echo $rows ; ?></li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>
            <?php
                                        $ae = "SELECT COUNT(*) FROM leads WHERE status='Active' ";
                                        if($_SESSION['role'] == 'BRH')
                                            {
                                                $mybranch = getbranchbyid($_SESSION['user'], $connection);
                                                $ae = $ae."AND branch='$mybranch'";
                                            }
                                        if($_SESSION['role'] == 'SAE')
                                            {
                                                $mybranch = getbranchbyid($_SESSION['user'], $connection);
                                                $me = $_SESSION['user'];
                                                $ae = $ae."AND branch='$mybranch' AND assignedto='$me'";
                                            }
                                        $actleads = mysqli_query($connection, $ae);
                                        $aleads = 0;
                                        if($actleads != false)
                                            $aleads = mysqli_fetch_array($actleads);
                                    ?>
            <div class="col-md-3">
                    <section class="panel" >
                        <div class="panel-body" style="margin-bottom: inherit;">
                        <div class="row" style="margin-bottom: 10px;max-height:120px;"> 
                            <!-- <div class="col-md-5" style="width:50%">                -->
                            <div class="mini-stat clearfix">
                                <span class="mini-stat-icon" style="background:crimson"><i class="fa fa-chevron-up"></i></span>
                                <div class="mini-stat-info">
                                    <span><?php echo $aleads['COUNT(*)'] ?></span>
                                    Hot Leads
                                </div>
                            </div>
                            <!-- </div> -->
                        </div>
                        <div class="row" style="max-height:120px;">
                        <!-- <div class="col-md-5" style="width:50%">                -->
                            <div class="mini-stat clearfix">
                                <span class="mini-stat-icon tar"><i class="fa fa-chevron-down"></i></span>
                                <div class="mini-stat-info">
                                    <?php
                                        $ie = "SELECT COUNT(*) FROM leads WHERE status='Closed' ";
                                        if($_SESSION['role'] == 'BRH')
                                            {
                                                $mybranch = getbranchbyid($_SESSION['user'], $connection);
                                                $ie = $ie."AND branch='$mybranch'";
                                            }
                                        if($_SESSION['role'] == 'SAE')
                                            {
                                                $mybranch = getbranchbyid($_SESSION['user'], $connection);
                                                $me = $_SESSION['user'];
                                                $ie = $ie."AND branch='$mybranch' AND assignedto='$me'";
                                            }
                                        $inactleads = mysqli_query($connection, $ie);
                                        $inaleads = 0;
                                        if($inactleads == true)
                                            $inaleads = mysqli_fetch_array($inactleads);
                                    ?>
                                    <span><?php echo $inaleads['COUNT(*)'] ?></span>
                                    Cold Leads
                                </div>
                            </div>
                        <!-- </div>    -->
                        </div>
                    </div>
                    </section>
                </div>
                <?php
                                $e = "SELECT SUM(totalamount) FROM opportunities WHERE status='Order Received' ";
                                if($_SESSION['role'] == 'BRH')
                                {
                                    $mybranch = getbranchbyid($_SESSION['user'], $connection);
                                    $e = $e."AND branch='$mybranch'";
                                }
                                if($_SESSION['role'] == 'SAE')
                                {
                                    $mybranch = getbranchbyid($_SESSION['user'], $connection);
                                    $me = $_SESSION['user'];
                                    $e = $e."AND branch='$mybranch' AND assignedto='$me'";
                                }
                                $sales = mysqli_query($connection, $e);
                                $tsale = 0;
                                if($sales != false){
                                    $totalsale = mysqli_fetch_array($sales);
                                    $tsale = $totalsale['SUM(totalamount)'];
                                    if($tsale == 0) $tsale = 0;
                                }
                            ?>
                <div class="col-md-3">
                    <section class="panel" >
                        <div class="panel-body" style="margin-bottom: inherit;">
                        <div class="row" style="margin-bottom: 10px;max-height:120px;"> 
                            <!-- <div class="col-md-5" style="width:50%">                -->
                            <div class="mini-stat clearfix">
                                <span class="mini-stat-icon" style="background:#A9D86E;"><i class="fa fa-rupee"></i></span>
                            <div class="mini-stat-info">
                                <span>Rs. <?php echo $tsale ?></span>
                                Total Sales
                            </div>
                            </div>
                            <!-- </div> -->
                        </div>
                        <?php
                        $userid = $_SESSION['user'];
                        $query = mysqli_query($connection, "SELECT COUNT(*) FROM calls WHERE callby='$userid' AND 'calldate' >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
                        $result = mysqli_fetch_array($query);
                        ?>
                        <div class="row" style="max-height:120px;">
                        <!-- <div class="col-md-5" style="width:50%">                -->
                            <div class="mini-stat clearfix">
                                <span class="mini-stat-icon tar" style="background:#302C2A !important"><i class="fa fa-phone"></i></span>
                                <div class="mini-stat-info">
                                    <span><?php echo $result['COUNT(*)']; ?></span>
                                    Calls this week
                                </div>
                            </div>
                        <!-- </div>    -->
                        </div>
                    </div>
                    </section>
                </div>
            </div>
            <!-- page start-->
            <!-- <div class="row">
                <div class="col-md-3">
                    <section class="panel">
                        <div class="panel-body"> -->
                            <!-- <div class="top-stats-panel"> -->
                                              
                            <!-- </div> -->
                        <!-- </div>
                    </section>
                </div> -->
                <!-- <div class="col-md-3">
                    <section class="panel1">
                        <div class="panel-body">
                            <div class="top-stats-panel">
                                <div class="gauge-canvas">
                                    <h4 class="widget-h">Leads Converted to Opportunities</h4>
                                    <div align="center">
                                        <canvas width=210 height=150 id="gauge" ></canvas>
                                    </div>
                                </div>
                                <ul class="gauge-meta clearfix">
                                    <li id="gauge-textfield" class="pull-left gauge-value"></li>
                                    <li class="pull-right gauge-title">Out of 25</li>
                                </ul>
                            </div>
                        </div>
                    </section>
                </div> -->
                <!-- <div class="col-md-3">
                    <section class="panel1" style="margin-left:0px;margin-right:-70px" >
                        <div class="panel-body">
                            <div class="top-stats-panel">
                                <h4 class="widget-h">Total Opportunities: 50</h4>
                                <div class="span6 chart">
                                    <div id="hero-bar" style="height:150px;"></div>
                                    <ul class="list-inline">
                                        <li>
                                            1. IN: Initial
                                        </li>
                                        <li>
                                            2. NG: Negotiation
                                        </li>
                                        <li>
                                            3. QT: Quoted
                                        </li>
                                        <li>
                                            4. OR: Order Received
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>      
                </div> -->
                <!-- <div class="col-md-6" style="margin-left:84px;width:42%">
                    <div class="row" style="margin-right: 0px;">
                        <div class="mini-stat clearfix" style="padding-top: 36px;">
                        <span class="mini-stat-icon" style="background:#A9D86E;"><i class="fa fa-rupee"></i></span>
                            <div class="mini-stat-info" style="margin-bottom: 27px;">
                                <span>Rs.68990</span>
                                Total Sales
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-left: -29px;padding-top: 0px;"> 
                        <div class="col-md-5" style="width:50%">               
                            <div class="mini-stat clearfix">
                                <span class="mini-stat-icon" style="background:crimson"><i class="fa fa-chevron-up"></i></span>
                                <div class="mini-stat-info">
                                    <span>75</span>
                                    Hot Leads
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5" style="width:50%">               
                            <div class="mini-stat clearfix">
                                <span class="mini-stat-icon tar"><i class="fa fa-chevron-down"></i></span>
                                <div class="mini-stat-info">
                                    <span>34</span>
                                    Cold Leads
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            <!-- </div> -->
            <div class="row">
            <div class="col-sm-12">
                <section class="panel" style="min-width: 1024px;>"
                    <header class="panel-heading">
                        Calls Due Since last 15 days
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                    </header>
                    <div class="panel-body">
                    <div class="adv-table">
                    <!-- <div class="btn-group">
                        <button id="editable-sample_new" class="btn btn-primary">
                            Add Call <i class="fa fa-plus"></i>
                        </button>
                    </div> -->
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
                        <th>Follow Up</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                            $exec = "SELECT * FROM calls WHERE followed='No' AND nextfollowup > DATE_ADD(CURDATE(), INTERVAL -15 DAY) AND nextfollowup < DATE_ADD(CURDATE(), INTERVAL 1 DAY) ";
                            if($_SESSION['role'] == 'SAE'){
                                $id = $_SESSION['user'];
                                $exec = $exec."AND callby=$id";
                            }
                            if($_SESSION['role'] == 'BRH'){
                                $branch = getbranchbyid($_SESSION['user'], $connection);
                                $exec = $exec."AND branch='$branch'";
                            }
                            $query = mysqli_query($connection, $exec);
                            $rows = 0;
                            if($query != false)
                                $rows = mysqli_num_rows($query);
                            for($i=0 ; $i<$rows ; $i++){
                                $result = mysqli_fetch_array($query);
                                $q1 = mysqli_query($connection, "SELECT * FROM callmodes WHERE modeid='$result[2]'");
                                $mode = mysqli_fetch_array($q1);
                                $q2 = mysqli_query($connection, "SELECT * FROM companies WHERE companyid='$result[5]'");
                                $company = mysqli_fetch_array($q2);
                                $q3 = mysqli_query($connection, "SELECT * FROM opportunities WHERE opportunityid='$result[7]'");
                                $opportunity = mysqli_fetch_array($q3);
                                $q4 = mysqli_query($connection, "SELECT * FROM users WHERE userid='$result[3]'");
                                $user = mysqli_fetch_array($q4);

                    ?>
                    <tr class="gradeX">
                        <td><?php echo $result[1]; ?></td>
                        <td><?php echo $mode[1]; ?></td>
                        <td><?php echo $result[4]; ?></td>
                        <td><?php echo $company[1]; ?></td>
                        <td><?php echo $opportunity[1]; ?></td>
                        <td><?php echo $user['fullname']; ?></td>
                        <td><?php echo $result[8]; ?></td>
                        <td><?php echo $result[11]; ?></td>
                        <td><?php echo $result[9]; ?></td>
                        <?php if($result[10] == "Yes") {?>
                        <td><span class="label label-success">Yes</span></td>
                        <?php } else if($result[10] == "No"){ ?>
                        <td><span class="label label-danger">No</span></td>
                        <?php } ?>
                        <td><a class="edit" href="newcall.php?cid=<?php echo $result[0]; ?>">Follow Up</a></td>
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
                        <th>Follow Up</th>
                    </tr>
                    </tfoot>
                    </table>
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
<script src="js/skycons/skycons.js"></script>
<script src="js/jquery.scrollTo/jquery.scrollTo.js"></script>

<script src="js/jvector-map/jquery-jvectormap-1.2.2.min.js"></script>
<script src="js/jvector-map/jquery-jvectormap-us-lcc-en.js"></script>
<script src="js/gauge/gauge.js"></script>
<!--clock init-->
<script src="js/css3clock/js/css3clock.js"></script>
<script src="js/dashboard.js"></script>
<!--common script init for all pages-->
<script src="js/jquery.js"></script>
<script src="js/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
<script src="bs3/js/bootstrap.min.js"></script>
<script src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jquery.nicescroll.js"></script>
 <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif] -->

<script type="text/javascript" language="javascript" src="js/advanced-datatable/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="js/data-tables/DT_bootstrap.js"></script>
<!-- <!common script init for all pages--> -->
<script src="js/scripts.js"></script>

<!--dynamic table initialization -->
<script src="js/dynamic_table_init.js"></script>
<script src="js/toggle-init.js"></script>
<script src="js/highcharts.js"></script>
<script src="js/exporting.js"></script>


       
</body>

<!-- Mirrored from bucketadmin.themebucket.net/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 31 Jul 2014 11:12:48 GMT -->
</html>
<?php require_once("includes/footer.php"); ?>