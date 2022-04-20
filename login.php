<?php
  require 'config/config.php';
  session_start();

  if(!empty($_POST)){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $pdostatement = $pdo->prepare( " SELECT * FROM  users WHERE email=:email" );
    $pdostatement->bindValue(':email',$email);
    $pdostatement->execute();
    $result = $pdostatement->fetch(PDO::FETCH_ASSOC);
    // print"<pre>";
    // print_r($result);exit();
    if($result){
      if (password_verify($password,$result['password'])){
        $_SESSION['user_name'] = $result['name'];
        $_SESSION['role'] = 0;
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['logged_in'] = time();
        header('Location:index.php');
      }
    }

      echo"<script>alert('Incorrect Credential. . . .')</script>";

  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Blogs | User Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>User Login </b> Blog</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="login.php" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

          <!-- /.col -->
          <div class="">
            <button class="btn btn-primary btn-block" type="submit" >Sign In</button><br>
            <a href="register.php" type="button" class="btn btn-info" style="Width:100%">Register</a>
          </div>
          <!-- /.col -->

      </form>


      <!-- /.social-auth-links -->


      <!-- <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
