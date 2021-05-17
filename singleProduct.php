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
              <button class="bg-success" href="cartNew.php" style="color:white">
                  <i class="bi bi-cart4" style="font-size:30px; color:white"></i>
                  <?php
                      echo (isset($_SESSION['cart_items']) && count($_SESSION['cart_items'])) > 0 ? count($_SESSION['cart_items']):'';
                  ?>
              </button>
            </div>
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline" type="submit">Search</button>

            </form>
        </div>
    </div>
</nav>

<?php
    if(isset($_GET['product']) && !empty($_GET['product']))
    {
        $sql = "SELECT p.*,pdi.img from products p
            INNER JOIN product_images pdi ON pdi.product_id = p.ProductID AND p.ProductID =:productID";
        $handle = $db->prepare($sql);
        $params = [
                ':productID' =>$_GET['product'],
            ];
        $handle->execute($params);
        if($handle->rowCount() == 1 )
        {
            $getProductData = $handle->fetch(PDO::FETCH_ASSOC);
            $imgUrl = PRODUCT_IMG_URL.str_replace(' ','-',strtolower($getProductData ['ProductName']))."/".$getProductData ['img'];
        }
        else
        {
            $error = '404! No record found';
        }

    }
    else
    {
        $error = '404! No record found';
    }

    if(isset($_POST['add_to_cart']) && $_POST['add_to_cart'] == 'add to cart')
    {
        $productID = $_POST['product_id'];
        $productQty = intval($_POST['product_qty']);

        $sql = "SELECT p.*,pdi.img from products p
            INNER JOIN product_images pdi ON pdi.product_id = p.ProductID WHERE p.ProductID =:productID";

        $prepare = $db->prepare($sql);

        $params = [
                ':productID' =>$productID,
            ];

        $prepare->execute($params);
        $fetchProduct = $prepare->fetch(PDO::FETCH_ASSOC);

        $calculateTotalPrice = number_format($productQty * $fetchProduct['Price'],2);

        $cartArray = [
            'product_id' =>$productID,
            'qty' => $productQty,
            'ProductName' =>$fetchProduct['ProductName'],
            'product_price' => $fetchProduct['Price'],
            'total_price' => $calculateTotalPrice,
            'product_img' =>$fetchProduct['img']
        ];

        if(isset($_SESSION['cart_items']) && !empty($_SESSION['cart_items']))
        {
            $productIDs = [];
            foreach($_SESSION['cart_items'] as $cartKey => $cartItem)
            {
                $productIDs[] = $cartItem['product_id'];
                if($cartItem['product_id'] == $productID)
                {
                    $_SESSION['cart_items'][$cartKey]['qty'] = $productQty;
                    $_SESSION['cart_items'][$cartKey]['total_price'] = $calculateTotalPrice;
                    break;
                }
            }

            if(!in_array($productID,$productIDs))
            {
                $_SESSION['cart_items'][]= $cartArray;
            }

            $successMsg = true;

        }
        else
        {
            $_SESSION['cart_items'][]= $cartArray;
            $successMsg = true;
        }

    }



?>

    <?php if(isset($getProductData) && is_array($getProductData)){?>
        <?php if(isset($successMsg) && $successMsg == true){?>
          <div class="container">
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible">
                         <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <img src="<?php echo $imgUrl ?>" class="rounded img-thumbnail mr-2" style="width:40px;"><?php echo $getProductData['ProductName']?> is added to cart. <a href="cartNew.php" class="alert-link">View Cart</a>
                    </div>
                </div>
            </div>
         <?php }?>

        <div class="container row">
            <div class="col">
                <img src="<?php echo $imgUrl;?>">
            </div>
            <div class="col-md-7">
                <h1><?php echo $getProductData['ProductName']?></h1>
                <p><?php echo $getProductData['Description']?></p>
                <h4>$<?php echo $getProductData['Price']?></h4>

                <form class="form-inline" method="POST">
                    <div class="form-group mb-2">
                        <input type="number" name="product_qty" id="productQty" class="form-control" placeholder="Quantity" min="1" max="1000" value="1">
                        <input type="hidden" name="product_id" value="<?php echo $getProductData['ProductID']?>">
                    </div>
                    <div class="form-group mb-2 ml-2">
                        <button type="submit" class="btn btn-primary" name="add_to_cart" value="add to cart">Add to Cart</button>
                    </div>
                </form>

            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <?php echo $getProductData['Description']?>
            </div>
        </div>
      </div>
    <?php
    }
    ?>

<?php include('layouts/footer.php');?>

</body>
</html>
