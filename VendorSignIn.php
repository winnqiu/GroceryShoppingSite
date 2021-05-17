<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.83.1">
    <title>Signin Template · Bootstrap v5.0</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">



    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

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
    <link href="VendorSignIn.css" rel="stylesheet">
    <link href="index.css" rel="stylesheet">
  </head>
  <body class="text-center">


  <header class="site-header sticky-top py-1  bg-success">
    <nav class="container d-flex flex-column flex-md-row justify-content-between">
      <div class="container text-align-center"><img src="img/logo_green.png" class="mx-auto d-block"></div>
    </nav>
  </header>
  <br>
  <br>

<main class="form-signin">
  <form method='post' action="">
    <h1 class="h3 mb-3 fw-normal">Vendors sign in</h1>

    <div class="form-floating">
      <input type="text" class="form-control" id="floatingInput" name="txt_uname" placeholder="Username">
      <label for="floatingInput">UserName</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" name="txt_pwd" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit" name="but_submit" id="but_submit" value="Submit">Sign in</button>
    <div style="margin-top: 10px;">
    <p> New to FreshXpress? <a href="V_Register.php" style="color:#198754"> Register Now!</a></p>

  </div>
  </form>
  <?php
  include 'db_connection.php';
  session_start();
  $con = OpenCon();

  if(isset($_POST['but_submit'])){
    $uname = mysqli_real_escape_string($con,$_POST['txt_uname']);
    $password = mysqli_real_escape_string($con,$_POST['txt_pwd']);



    if ($uname != "" && $password != ""){

        $sql_query = "select count(*) as 'cntUser' from vendors where Username='".$uname."' and Password='$password'";
        $result = mysqli_query($con,$sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['cntUser'];

        if($count > 0){
            $_SESSION['vname'] = $uname;
            header('Location: vendorMain.php');
        }else{
            echo "Invalid username and password";
        }

    }

}
CloseCon($con)

  ?>

</main>



  </body>
</html>
