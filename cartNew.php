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

    if(isset($_GET['action'],$_GET['item']) && $_GET['action'] == 'remove')
    {
        unset($_SESSION['cart_items'][$_GET['item']]);
        header('location:cartNew.php');
        exit();
    }


    //pre($_SESSION);
?>
<div class="row">
    <div class="col-md-12">
        <?php if(empty($_SESSION['cart_items'])){?>
        <table class="table">
            <tr>
                <td>
                    <p>Your cart is empty</p>
                </td>
            </tr>
        </table>
        <?php }?>
        <?php if(isset($_SESSION['cart_items']) && count($_SESSION['cart_items']) > 0){?>
        <table class="table">
           <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $totalCounter = 0;
                    $itemCounter = 0;
                    foreach($_SESSION['cart_items'] as $key => $item){

                     $imgUrl = PRODUCT_IMG_URL.str_replace(' ','-',strtolower($item['ProductName']))."/".$item['product_img'];

                    $total = $item['product_price'] * $item['qty'];
                    $totalCounter+= $total;
                    $itemCounter+=$item['qty'];
                    ?>
                    <tr>
                        <td>
                            <img src="<?php echo $imgUrl; ?>" class="rounded img-thumbnail mr-2" style="width:60px;"><?php echo $item['ProductName'];?>

                            <a href="cartNew.php?action=remove&item=<?php echo $key?>" class="text-danger">
                                <i class="bi bi-trash-fill"></i>
                            </a>

                        </td>
                        <td>
                            $<?php echo $item['product_price'];?>
                        </td>
                        <td>
                            <input type="number" name="" class="cart-qty-single" data-item-id="<?php echo $key?>" value="<?php echo $item['qty'];?>" min="1" max="1000" >
                        </td>
                        <td>
                            <?php echo $total;?>
                        </td>
                    </tr>
                <?php }?>
                <tr class="border-top border-bottom">
                    <td><button class="btn btn-danger btn-sm" id="emptyCart">Clear Cart</button></td>
                    <td></td>
                    <td>
                        <strong>
                            <?php
                                echo ($itemCounter==1)?$itemCounter.' item':$itemCounter.' items'; ?>
                        </strong>
                    </td>
                    <td><strong>$<?php echo $totalCounter;?></strong></td>
                </tr>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col-md-11">
				<a href="checkout.php">
					<button class="btn btn-primary btn-lg float-right">Checkout</button>
				</a>
            </div>
        </div>

        <?php }?>
    </div>
</div>
<?php include('layouts/footer.php');?>

</body>
</html>
