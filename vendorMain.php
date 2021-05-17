<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Vendor Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <?php
    $dsn = 'mysql:dbname=freshxpress;host=localhost';
    $user = 'root';
    $password = '';

    try
    {
    	$db = new PDO($dsn,$user,$password);
    	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
    	echo "PDO error".$e->getMessage();
    	die();
    }

    define('PRODUCT_IMG_URL','assets/product-images/');
    session_start();
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['vname']);
        header("location: index.html ");}

    ?>
    ?>

    <?php
      $vendor=$_SESSION['vname'];
      $sql="SELECT * from vendors where Username='".$vendor."'";
      $handle = $db->prepare($sql);
      $handle->execute();
      $getVendor = $handle->fetchAll(PDO::FETCH_ASSOC);
      $manager=$getVendor[0]['Manager'];
      $vendorID=$getVendor[0]['vendorID'];

      $sql2="SELECT count(DISTINCT o.OrderID) as totalOrders from orders o, orderitems oi,products p where o.OrderID=oi.OrderID and oi.ProductID=p.ProductID and vendorID='".$vendorID."'";
      $handle2 = $db->prepare($sql2);
      $handle2->execute();
      $getOrders = $handle2->fetchAll(PDO::FETCH_ASSOC);
      $orders=$getOrders[0]['totalOrders'];

      $sql4="SELECT count(DISTINCT o.CustomerID) as totalCustomers from orders o, orderitems oi,products p where o.OrderID=oi.OrderID and oi.ProductID=p.ProductID and vendorID='".$vendorID."'";
      $handle4 = $db->prepare($sql4);
      $handle4->execute();
      $getCustomers = $handle4->fetchAll(PDO::FETCH_ASSOC);
      $customers=$getCustomers[0]['totalCustomers'];

      $sql3="SELECT count(DISTINCT o.OrderID) as pendingOrders from orders o, orderitems oi,products p where o.OrderID=oi.OrderID and oi.ProductID=p.ProductID and vendorID='".$vendorID."' and status='pending'";
      $handle3 = $db->prepare($sql3);
      $handle3->execute();
      $getPending = $handle3->fetchAll(PDO::FETCH_ASSOC);
      $pending=$getPending[0]['pendingOrders'];
    ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-success sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="vendorMain.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">FreshXpress</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="vendorMain.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->

            <!-- Nav Item - Pages Collapse Menu -->

            <li class="nav-item">
                <a class="nav-link" href="manageOrders.php">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Manage Orders</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Products</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="manageProducts.php">Manage Products</a>
                        <a class="collapse-item" href="AddNewProduct.php">Add New Products</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="AccountSetting.php">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Account Settings</span></a>
            </li>

            <!-- Divider -->
            <!-- Heading -->
            <!-- Nav Item - Pages Collapse Menu -->

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->

<span class=" "><strong>Thank you for using FreshXpress!</strong></span>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->




                        <!-- Nav Item - Alerts -->

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $manager;?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="vendorMain.php?logout=1" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Orders</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $orders; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                New Orders</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $pending; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-bullhorn fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Customers</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $customers; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-bullhorn fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
</div>
                        <!-- Earnings (Monthly) Card Example -->
                      <!--  <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      -->

                        <!-- Pending Requests Card Example -->

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Popular Products</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <div >
                                  <?php

                                  $dsn = 'mysql:dbname=freshxpress;host=localhost';
                                  $user = 'root';
                                  $password = '';

                                  try
                                  {
                                    $db = new PDO($dsn,$user,$password);
                                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                  }
                                  catch(PDOException $e)
                                  {
                                    echo "PDO error".$e->getMessage();
                                    die();
                                  }

                                  $sql=" SELECT ProductName,sum(oi.Quantity) as Sales from products p,orderitems oi where p.ProductID=oi.ProductID and vendorID='v0001' group by ProductName order by sum(oi.Quantity) desc limit 10";
                                  $handle = $db->prepare($sql);
                                  $handle->execute();
                                  $getProductSales = $handle->fetchAll(PDO::FETCH_ASSOC);

                                  $datapoint=array();
                                  foreach($getProductSales as $sale){
                                    $salepoint=array("label"=>$sale['ProductName'],"y"=>intval($sale['Sales']));
                                    array_push($datapoint,$salepoint);
                                  };
                                  ?>
                                  <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                                  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                                </div>
                              </div>
</div>



<!-- Pie Chart -->
<div class="col-xl-6 col-lg-6">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Monthly Sales</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Dropdown Header:</div>
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>
        <!-- Card Body -->
        <?php
        $sql5="SELECT sum(OrderTotal) as monthProfit,month(OrderDate) as month from orders o, orderitems oi, products p where o.OrderID=oi.OrderID and oi.ProductID=p.ProductID and vendorID='".$vendorID."' and year(OrderDate)=2021 group by month(OrderDate) ";
        $handle5 = $db->prepare($sql5);
        $handle5->execute();
        $getMonthlySales = $handle5->fetchAll(PDO::FETCH_ASSOC);
        $datapoint1=array();
        foreach($getMonthlySales as $sale1){
          $salepoint1=array("label"=>$sale1['month'],"y"=>intval($sale1['monthProfit']));
          array_push($datapoint1,$salepoint1);
        };

        ?>
        <div class="card-body">
          <script>
          window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
              animationEnabled: true,
              exportEnabled: true,
              theme: "light1", // "light1", "light2", "dark1", "dark2"
              title:{
                text: "Most Popular Items"
              },
              axisY:{
                includeZero: true
              },
              axisX:{
                labelPlacement: "outside", //Change it to "outside"
                labelAutoFit: true,
                valueFormatString:"####",
                labelWrap: true
              },
              data: [{
                type: "column", //change type to bar, line, area, pie, etc
                indexLabel: "{y}", //Shows y value on all Data Points
                indexLabelFontColor: "#5A5757",
                indexLabelPlacement: "outside",
                dataPoints: <?php echo json_encode($datapoint, JSON_NUMERIC_CHECK); ?>
              }]
            });
            chart.render();
          var chart1 = new CanvasJS.Chart("chartContainer1", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light1", // "light1", "light2", "dark1", "dark2"
            title:{
              text: "Monthly Sales in $"
            },
            axisY:{
              includeZero: true
            },
            axisX:{
              labelPlacement: "outside", //Change it to "outside"
              labelAutoFit: true,
              valueFormatString:"####",
              labelWrap: true
            },
            data: [{
              type: "line", //change type to bar, line, area, pie, etc
              indexLabel: "{label}", //Shows y value on all Data Points
              indexLabelFontColor: "#5A5757",
              indexLabelPlacement: "outside",
              dataPoints: <?php echo json_encode($datapoint1, JSON_NUMERIC_CHECK); ?>
            }]
          });
          chart1.render();

          }
          </script>
          <div id="chartContainer1" style="height: 330px; width: 100%;"></div>
          <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        </div>
        </div>
    </div>
</div>
</div>
</div>




                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->

            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="destroy.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
  </div>

</div>



    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>
