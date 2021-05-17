<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="sidebars.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
<style>
    i{
      color:#198754;
    }
</style>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
<nav class="navbar navbar-expand-lg navbar-light bg-success text-white">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="img/logo_small.png"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>
                    <?php
                        session_start();
                        require_once('./inc/config.php');
                        require_once('./inc/helpers.php');

                        $sql = "SELECT CategoryName from categories";
                        $handle = $db->prepare($sql);
                        $handle->execute();
                        $getAllCategories = $handle->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <?php
                      foreach($getAllCategories as $category)
                      {
                          echo "<li><a class='dropdown-item' href='home.php?categorySearch=".$category['CategoryName']."'>".$category['CategoryName']."</a></li>";}
                      ?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Past Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">My Profile</a>
                </li>
            </ul>
            <form class="d-flex">
              <div style="margin-right:10px">
              <a class="" href="cart.php" style="color:white">
                  <i class="bi bi-cart4" style="font-size:30px; color:white"></i>
                  <?php
                      echo (isset($_SESSION['cart_items']) && count($_SESSION['cart_items'])) > 0 ? count($_SESSION['cart_items']):'';
                  ?>
              </a>
            </div>
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline" type="submit">Search</button>

            </form>
        </div>
    </div>
</nav>



<div class="col container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-light">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-success min-vh-100">
                <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-success text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">Category</span>
                </a>

                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="home.php" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline text-success">Home</span>
                        </a>
                    </li>
                    <?php
                    foreach($getAllCategories as $category)
                    {
                        echo "
                        <li>
                                                <a href='?categorySearch=".$category['CategoryName']."' class='nav-link px-0 align-middle'>
                                                    <i class='bi bi-lightning'></i> <span class='ms-1 d-none d-sm-inline text-success'>".$category['CategoryName']."</span></a>
                                            </li>";}
                    ?>

                <hr>

            </div>

</div>

<div class="col-10 row container-fluid">
    <?php
    $results_per_page=20;

    if (isset($_GET["categorySearch"])) {
      if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
      $start_from = ($page-1) * $results_per_page;
      $cs=$_GET["categorySearch"];
      $sql3 = "SELECT *
            from products p,product_images pi, categories c
            where p.ProductID=pi.product_id and p.CategoryID=c.CategoryID and categoryName='".$cs."'
                ORDER BY ProductID ASC";
      $sql2 = "SELECT *
            from products p,product_images pi, categories c
            where p.ProductID=pi.product_id and p.CategoryID=c.CategoryID and categoryName='".$cs."'
                ORDER BY ProductID ASC LIMIT ".$start_from.",".$results_per_page;
              }
    else {
      if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
      $start_from = ($page-1) * $results_per_page;
      $sql3 = "SELECT ProductID,ProductName,Price,Description FROM products p
                ORDER BY ProductID ASC";
      $sql2 = "SELECT ProductID,ProductName,Price,Description FROM products
                ORDER BY ProductID ASC LIMIT ".$start_from.",". $results_per_page;
              };

    $handle2 = $db->prepare($sql2);
    $handle2->execute();
    $getAllProducts = $handle2->fetchAll(PDO::FETCH_ASSOC);
    $handle3 = $db->prepare($sql3);
    $handle3->execute();
    $getcount = $handle3->fetchAll(PDO::FETCH_ASSOC);
    $total_items=count($getcount);

    foreach($getAllProducts as $products)
    {
      if (isset($products['img'])){
        $imgUrl = PRODUCT_IMG_URL.str_replace(' ','-',strtolower($products['ProductName']))."/".$products['img'];
      }else{
        $imgUrl = PRODUCT_IMG_URL.str_replace(' ','-',strtolower("default"))."/default.jpg";
      }
    ?>
      <div class="col-sm-3  mt-2">
            <div class="card">
                 <a href="singleProduct.php?product=<?php echo $products['ProductID']?>">
                    <img class="card-img-top" src="<?php echo $imgUrl ?>" alt="<?php echo $products['ProductName'] ?>">
                </a>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="singleProduct.php?product=<?php echo $products['ProductID'] ?>">
                            <?php echo $products['ProductName']; ?>
                        </a>
                    </h5>
                    <strong>$ <?php echo $products['Price']?></strong>

                    <p class="card-t">
                        <?php echo substr($products['Description'],0,50) ?>'...
                    </p>
                    <p class="card-text">
                        <a href="singleProduct.php?product=<?php echo $products['ProductID']?>" class="btn btn-primary btn-sm">
                            View
                        </a>
                    </p>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <hr>
    <div class="col-md-6 offset-md-3">
      <label>pages</label>
    <?php
    if (isset($cs)){
      $catehold="categorySearch=".$cs."&";
    }
    else{
      $catehold='';
    }
    $total_pages = ceil($total_items / $results_per_page);
    for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
                echo "<a href='home.php?".$catehold."page=".$i."'";
                if ($i==$page)  echo " class='curPage'";
                echo ">".$i."</a> ";
    };
    ?>
    </div>
</div>

</body>
</html>
