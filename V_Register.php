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
<link href="V_Register.css" rel="stylesheet">

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

    <?php
      include 'db_connection.php';
      $conn=openCon();
      if(isset($_POST['submit'])){
        if($_POST['password']!=$_POST['password2']){
          echo "Password not match! Please try again!";
        }else{
          $sql1="SELECT VendorID from vendors order by VendorID desc limit 1";
          $result=$conn->query($sql1);
          $row=$result->fetch_assoc();
          $vid=$row['VendorID'];
          $vn=intval(substr($vid,-4))+1;
          $vn=sprintf("%04d", $vn);
          $newvid='v'.$vn;
          $brand=$_POST['brandName'];
          $email=$_POST['Email'];
          $phone=$_POST['phone'];
          $address=$_POST['Address'];
          $manager=$_POST['Manager'];
          $password=$_POST['password'];
          $username=$_POST['username'];
          $sql="INSERT INTO vendors values('$newvid','$brand','$email','$phone','$address','$manager','$username','$password')";
          if ($conn->query($sql) === TRUE) {
              echo "New record created successfully";
              session_start();
              $_SESSION['vname']=$manager;
              header('Location: vendorMain.php');
            } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
              }
        }
      }


      closeCon($conn);
     ?>
  <div class="wrapper d-flex justify-content-center h-100">
      <form action="V_Register.php" method='post'>
          <div class="h5 font-weight-bold text-center mb-3">Vendor Sign Up</div>
          <div class="form-group d-flex align-items-center">
              <div class="icon"><span class="far fa-user"></span></div> <input autocomplete="off" type="text" name='brandName' class="form-control" placeholder="Brand Name" required>
          </div>
          <div class="form-group d-flex align-items-center">
              <div class="icon"><span class="far fa-envelope"></span></div> <input autocomplete="off" type="email" name='Email' class="form-control" placeholder="Email" required>
          </div>
          <div class="form-group d-flex align-items-center">
              <div class="icon"><span class="fas fa-phone"></span></div> <input autocomplete="off" type="tel" name='phone' class="form-control" placeholder="Phone" required>
          </div>
          <div class="form-group d-flex align-items-center">
              <div class="icon"><span class="fas fa-map-marker-alt"></span></div> <input autocomplete="off" type="text" name='Address' class="form-control" placeholder="Address" required>
          </div>
          <div class="form-group d-flex align-items-center">
              <div class="icon"><span class="fas fa-map-marker-alt"></span></div> <input autocomplete="off" type="text" name='Manager' class="form-control" placeholder="Manager" required>
          </div>
          <div class="form-group d-flex align-items-center">
              <div class="icon"><span class="fas fa-map-marker-alt"></span></div> <input autocomplete="off" type="text" name='username' class="form-control" placeholder="Username" required>
          </div>
          <div class="form-group d-flex align-items-center">
              <div class="icon"><span class="fas fa-key"></span></div> <input autocomplete="off" type="password" class="form-control" name='password' placeholder="Password" required>
              <div class="icon btn"><span class="fas fa-eye-slash"></span></div>
          </div>
          <div class="form-group d-flex align-items-center">
              <div class="icon"><span class="fas fa-key"></span></div> <input autocomplete="off" type="password" class="form-control" name='password2' placeholder="Please enter your password again" required>
              <div class="icon btn"><span class="fas fa-eye-slash"></span></div>
          </div>
          <div class="terms mb-2"> By clicking "Signup", you acknowledge that you have read the <a href="#">Privacy Policy</a> and agree to the <a href="#">Terms of Service</a>. </div>
          <button class="btn btn-primary mb-3" type='submit' name='submit'>Signup</button>
              </form>
  </div>




  </body>
</html>
