<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.83.1">
    <title>Vendor Selection</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/product/">



    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>


    <!-- Custom styles for this template -->
    <link href="index.css" rel="stylesheet">
  </head>
  <body>

<header class="site-header sticky-top py-1  bg-success">
  <nav class="container d-flex flex-column flex-md-row justify-content-between">
    <div class="container text-align-center"><img src="img/logo_green.png" class="mx-auto d-block"></div>
  </nav>
</header>

<main>
  <div
          class="p-5 text-center bg-image"
          style="
      background-image: url('img/bg.jpg');
      height: 700px;
      background-repeat: no-repeat;
      background-position: center;
    "
  >
  <div class="container" style="background-color: rgba(0, 0, 0, 0.6);">
    <br>
          <table class='container'>
          <?php
          include 'db_connection.php';
          $conn=OpenCon();
          $sql="SELECT * from vendors";
          $result = mysqli_query($conn,$sql);
          $row = $result->fetch_all();
          $i=0;
          foreach($row as $vendor){
            $j=$i%5;
            if($i%5===0){
              echo "<tr>";
            };
            $path="php-shopping-cart\\php-shopping-cart\\assets\\vendor-images\\".$vendor[1].".png";
            $path2="php-shopping-cart\\php-shopping-cart\\assets\\vendor-images\\".$vendor[1].".jpg";

          if(file_exists($path)){
            $path = str_replace(' ', '%20', $path);
            $imgsrc=$path;
            $show=true;
          }elseif(file_exists($path2)){
              $path2 = str_replace(' ', '%20', $path2);
            $imgsrc=$path2;
            $show=true;
          }else {
            $show=false;
          };
          if($show){
            $i+=1;
          echo "
          <td style:' height:80px;width:50px; margin:10px 10px 10px 10px; text-align:center;'>
  <img style='width:50px;height:50px;margin-bottom:5px;' src=".$imgsrc." class='' alt='".$vendor[1]."'>
  <br><form method='post' action='php-shopping-cart\\php-shopping-cart\\Home.php?vendor=".$vendor[0]."'>
  <button type='submit' name='vendor' value='".$vendor[0]."'  class='btn btn-success'style='margin-bottom:5px;' >".$vendor[1]."</button></form></td>";
};

            if($j!=0&$j%5==0){
              echo "</tr>";
            };

        };
          closeCon($conn);
          ?>
        </table>
<div>
    </div>
  </div>


</main>

<footer class="container py-5">
  <div class="row">
    <div class="col-12 col-md">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="d-block mb-2" role="img" viewBox="0 0 24 24"><title>Product</title><circle cx="12" cy="12" r="10"/><path d="M14.31 8l5.74 9.94M9.69 8h11.48M7.38 12l5.74-9.94M9.69 16L3.95 6.06M14.31 16H2.83m13.79-4l-5.74 9.94"/></svg>
      <small class="d-block mb-3 text-muted">&copy; 2017–2021</small>
    </div>
    <div class="col-6 col-md">
      <h5>Features</h5>
      <ul class="list-unstyled text-small">
        <li><a class="link-secondary" href="#">Cool stuff</a></li>
        <li><a class="link-secondary" href="#">Random feature</a></li>
        <li><a class="link-secondary" href="#">Team feature</a></li>
        <li><a class="link-secondary" href="#">Stuff for developers</a></li>
        <li><a class="link-secondary" href="#">Another one</a></li>
        <li><a class="link-secondary" href="#">Last time</a></li>
      </ul>
    </div>
    <div class="col-6 col-md">
      <h5>Resources</h5>
      <ul class="list-unstyled text-small">
        <li><a class="link-secondary" href="#">Resource name</a></li>
        <li><a class="link-secondary" href="#">Resource</a></li>
        <li><a class="link-secondary" href="#">Another resource</a></li>
        <li><a class="link-secondary" href="#">Final resource</a></li>
      </ul>
    </div>
    <div class="col-6 col-md">
      <h5>Resources</h5>
      <ul class="list-unstyled text-small">
        <li><a class="link-secondary" href="#">Business</a></li>
        <li><a class="link-secondary" href="#">Education</a></li>
        <li><a class="link-secondary" href="#">Government</a></li>
        <li><a class="link-secondary" href="#">Gaming</a></li>
      </ul>
    </div>
    <div class="col-6 col-md">
      <h5>About</h5>
      <ul class="list-unstyled text-small">
        <li><a class="link-secondary" href="#">Team</a></li>
        <li><a class="link-secondary" href="#">Locations</a></li>
        <li><a class="link-secondary" href="#">Privacy</a></li>
        <li><a class="link-secondary" href="#">Terms</a></li>
      </ul>
    </div>
  </div>
</footer>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>


  </body>
</html>
