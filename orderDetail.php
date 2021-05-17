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

    ?>

    <?php
      session_start();
      $vendor=$_SESSION['vname'];
      $sql="SELECT * from vendors where Username='".$vendor."'";
      $handle = $db->prepare($sql);
      $handle->execute();
      $getVendor = $handle->fetchAll(PDO::FETCH_ASSOC);
      $manager=$getVendor[0]['Manager'];
      $vendorID=$getVendor[0]['vendorID'];

      $orderid=$_GET['orderID'];
      $sql3="SELECT DISTINCT o.OrderID, OrderDate, OrderTotal,FirstName,LastName, PaymentMethod, Delivery, status,Address,CardID from products p,orders o,orderitems oi,addresses a,customers c where p.ProductID=oi.ProductID and oi.OrderID=o.OrderID and o.AddressID= a.AddressID and c.CustomerID = o.CustomerID and VendorID='".$vendorID."'";
      $handle3 = $db->prepare($sql3);
      $handle3->execute();
      $getOrders = $handle3->fetchAll(PDO::FETCH_ASSOC);
      $order=$getOrders[0];

      $sql2="SELECT * from products p,orders o,orderitems oi where p.ProductID=oi.ProductID and oi.OrderID=o.OrderID and o.OrderID='".$orderid."'";
      $handle2 = $db->prepare($sql2);
      $handle2->execute();
      $getOrderItems = $handle2->fetchAll(PDO::FETCH_ASSOC);

    ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

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
                <a class="nav-link" href="charts.html">
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
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!--OrderID, OrderDate, OrderTotal,FirstName,LastName, PaymentMethod, Delivery, status,Address,CreditCardNum-->
                <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Order Detail of <?php echo $orderid; ?></h6>
                    </div>
                    <div class="card-body">
                      <div class='row'>
                        <div class='col'><p>Order ID: <?php echo $order['OrderID'];?></p></div>
                        <div class='col'><p>Order Date: <?php echo $order['OrderDate'];?></p></div>
                      </div>
                      <div class='row'>
                        <div class='col'><p>Customer Name: <?php echo $order['FirstName']." ".$order['LastName'];?></p></div>
                        <div class='col'><p>Address: <?php echo $order['Address'];?></p></div>
                      </div>
                      <div class='row'>
                        <div class='col'><p>Payment Method: <?php echo $order['PaymentMethod'];?>
                        <?php
                           if($order['PaymentMethod']=='card')
                           {

                               $cardid=$order['CardID'];
                               $sql2="SELECT CreditCardNum from cards where CardID='$cardid'";
                               $handle2 = $db->prepare($sql2);
                               $handle2->execute();
                               $getcard = $handle2->fetchAll(PDO::FETCH_ASSOC);
                               $card=$getcard[0]['CreditCardNum'];

                             $card='*'.substr($card, -4);
                             echo $card;
                           }
                         ?>
                         </p></div>
                        <div class='col'><p>Delivery/Pickup: <?php echo $order['Delivery'];?></p></div>
                      </div>
                      <p>Order Status: <?php echo $order['status'];?></p>
                      <table class='table'>
                        <thead>
                          <th>#</th>
                          <th>Order Items</th>
                          <th>Price</th>
                          <th>Quantity</th>
                          <th>Subtotal</th>
                        </thead>
                        <tbody>
                          <?php
                          $i=1;
                          foreach($getOrderItems as $orderitem)
                          {
                            echo "
                            <tr>
                              <td>".$i."</td>
                              <td>".$orderitem['ProductName']."</td>
                              <td>".$orderitem['Price']."</td>
                              <td>".$orderitem['Quantity']."</td>
                              <td>".$orderitem['Price']*$orderitem['Quantity']."</td>
                            </tr>

                            ";
                            $i+=1;
                          }

                          ?>
                        </tbody>
                      </table>

                      <div class='float-right'>
                        <p><strong>Order Total:</strong> <?php echo $order['OrderTotal']?> </p>
                      </div>
                      <hr>
                      <br>
                      <br>
                      <div class='row'>
                      <div class="col">
                        <button class='btn btn-primary' onclick="goBack()">Back to Orders</button>
                      </div>
                      <div class="col">
                        <button class='btn btn-primary'>Change Status</button>
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
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
    $(document).ready( function () {
  $('#productTable').DataTable();
} );

    </script>
    <script src="js/demo/datatables-demo.js"></script>
    <script>
    function goBack() {
      window.history.back();
    }
    </script>
</body>

</html>
