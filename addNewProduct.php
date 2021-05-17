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
      $vendorid=$getVendor[0]['vendorID'];

      $sql2="SELECT count(DISTINCT o.OrderID) as totalOrders from orders o, orderitems oi,products p where o.OrderID=oi.OrderID and oi.ProductID=p.ProductID";
      $handle2 = $db->prepare($sql2);
      $handle2->execute();
      $getOrders = $handle2->fetchAll(PDO::FETCH_ASSOC);
      $orders=$getOrders[0]['totalOrders'];

      $sql3="SELECT count(DISTINCT o.OrderID) as pendingOrders from orders o, orderitems oi,products p where o.OrderID=oi.OrderID and oi.ProductID=p.ProductID and status='pending'";
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
<div class='container'>
  <?php
  if(isset($_GET['submit'])){

      $sql1="SELECT ProductID from products order by ProductID desc limit 1";
      $handle1 = $db->prepare($sql1);
      $handle1->execute();
      $getProductID = $handle1->fetch(PDO::FETCH_ASSOC);
      $pid=$getProductID['ProductID'];
      $pn=intval(substr($pid,-4))+1;
      $pn=sprintf("%04d", $pn);
      $newpid='p'.$pn;
      $pname=$_GET['ProductName'];
      $categoryid=$_GET['category'];
      $description=$_GET['Description'];
      $price=$_GET['price'];
      $qty=$_GET['Quantity'];
      include 'db_connection.php';
      $conn=openCon();
      $sql2="INSERT INTO products values('$newpid','$pname','$categoryid','$vendorid','$description',$price,$qty)";
      if ($conn->query($sql2) === TRUE) {
          echo "<h3>Successfully Added!</h3>";
          //header('Location: php-shopping-cart/php-shopping-cart/Home.php');
        } else {
          echo "Error: " . $sql2 . "<br>" . $conn->error;
          }
          closeCon($conn);
  }

  ?>

  <form class="row g-3" method='get'>
<div class="col-md-6">
  <label for="ProductName" class="form-label">Product Name</label>
  <input type="text" id="ProductName" class="form-control" name='ProductName' required>
</div>
<div class="col-md-6">
  <label for="Category" class="form-label">Category</label>
  <select class='form-control' id='Category' name='category'>
    <?php
    $sql2="SELECT * from categories";
    $handle2 = $db->prepare($sql2);
    $handle2->execute();
    $getCategory = $handle2->fetchAll(PDO::FETCH_ASSOC);
    print_r($getCategory);
    foreach($getCategory as $category){
      echo "<option value='".$category['CategoryID']."'>".$category['CategoryName']."</option>";
    }
    ?>
  </select>
</div>
<div class="col-12">
  <label for="Description" class="form-label">Description</label>
  <input type="text" class="form-control" id="Description" placeholder="Description for the product" name='Description'>
</div>
<div class="col-md-6">
  <label for="price" class="form-label">Single Product Price($)</label>
  <input type="number" type="number" step="0.01" class="form-control" id="price" name='price' required>
</div>
<div class="col-md-6">
  <label for="Quantity" class="form-label">Quantity</label>
  <input type="number" class="form-control" id="quantity" placeholder="number of items in stock" name='Quantity' required>
</div>
<div class='row col-12 mt-3'>
<div class="col-2">
  <button type="submit" class="btn btn-primary" name='submit'>Save</button>
</div>

</div>
</form>
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
