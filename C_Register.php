<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.83.1">
    <title>Customer Register</title>

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
      $vendor=$_GET['vendor'];
      $conn=openCon();
      if(isset($_POST['submit'])){
        if($_POST['password']!=$_POST['password2']){
          echo "Password not match! Please try again!";
        }else{
          $sql1="SELECT CustomerID from customers order by CustomerID desc limit 1";
          $result=$conn->query($sql1);
          $row=$result->fetch_assoc();
          $cid=$row['CustomerID'];
          $cn=intval(substr($cid,-4))+1;
          $cn=sprintf("%04d", $cn);
          $newcid='c'.$cn;
          $fname=$_POST['fname'];
          $lname=$_POST['lname'];
          $dob=$_POST['dob'];
          $email=$_POST['email'];
          $phone=$_POST['phone'];
          $gender=$_POST['gender'];
          $password=$_POST['password'];
          $sql="INSERT INTO customers values('$newcid','$fname','$lname','$email','$dob','$gender','','$password')";
          if ($conn->query($sql) === TRUE) {
              echo "<h3>Successfully Registered!</h3>";
              session_start();
              $_SESSION['uname']=$email;
              $_SESSION['vendor']=$vendor;
              echo "<a style='color:red;' href='php-shopping-cart/php-shopping-cart/Home.php?vendor=".$vendor."'>Start shopping!</a>";
              //header('Location: php-shopping-cart/php-shopping-cart/Home.php');
            } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
              }
        }
      }


      closeCon($conn);
     ?>


  <div class="wrapper d-flex justify-content-center h-100">
      <form action="C_Register.php?vendor=<?php echo $vendor; ?>" method='post'>
          <div class="h5 font-weight-bold text-center mb-3">Customer Register</div>
          <div class="form-group d-flex align-items-center">
              <div class="icon"><span class="far fa-user"></span></div> <input autocomplete="off" type="text" class="form-control" placeholder="First Name" name='fname' required>
          </div>
          <div class="form-group d-flex align-items-center">
              <div class="icon"><span class="far fa-user"></span></div> <input autocomplete="off" type="text" class="form-control" placeholder="Last Name" name='lname' required>
          </div>
          <p style="color:white; text-align:left;">Date of Birth</p>
          <div class="form-group d-flex align-items-center">
              <div class="icon"><span class="far fa-user"></span></div> <input autocomplete="off" type="date" class="form-control" placeholder="Date of Birth" name='dob' required>
          </div>
          <div class="form-group d-flex align-items-center">
              <div class="icon"><span class="far fa-envelope"></span></div> <input autocomplete="off" type="email" class="form-control" placeholder="Email" name='email' required>
          </div>
          <div class="form-group d-flex align-items-center">
              <div class="icon"><span class="fas fa-phone"></span></div> <input autocomplete="off" type="tel" class="form-control" placeholder="Phone" name='phone' required>
          </div>
          <div class="form-group d-flex align-items-center">
              <div class="icon"><span class="fas fa-map-marker-alt"></span></div> <select style='background-color: transparent; color:white;'class="form-select" aria-label="Default select example" name='gender' required>
      <option selected>Please select your gender</option>
      <option style='background-color: transparent;' value="F">Female</option>
      <option style='background-color: transparent;' value="M">Male</option>
    </select>
          </div>
          <div class="form-group d-flex align-items-center">
              <div class="icon"><span class="fas fa-key"></span></div> <input autocomplete="off" type="password" class="form-control" placeholder="Password" name='password' required>
              <div class="icon btn"><span class="fas fa-eye-slash"></span></div>
          </div>
          <div class="form-group d-flex align-items-center">
              <div class="icon"><span class="fas fa-key"></span></div> <input autocomplete="off" type="password" class="form-control" placeholder="Password" name='password2' required>
              <div class="icon btn"><span class="fas fa-eye-slash"></span></div>
          </div>
          <div class="terms mb-2"> By clicking "Signup", you acknowledge that you have read the <a href="#">Privacy Policy</a> and agree to the <a href="#">Terms of Service</a>. </div>
          <button type='submit' name='submit' class="btn btn-primary mb-3">Signup</button>
              </form>
  </div>




  </body>
</html>
