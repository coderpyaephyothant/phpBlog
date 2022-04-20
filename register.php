<?php
  session_start();
  require 'config/config.php';
  require 'config/common.php';

  if(!empty($_POST)){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || !empty($_POST['password'])&& strlen($_POST['password'])<4){
        if (empty($_POST['name'])){
          $nameError = '*** Please fill account name ***';
        }
        if (empty($_POST['email'])){
          $emailError = ' *** Please fill account email *** ';
        }
        if (empty($_POST['password'])){
          $passwordError = ' *** Please fill account password *** ';
        }
        if (!empty($_POST['password']) && strlen($_POST['password'])<4) {
            $passwordError = '*** Password should be at least 4 characters ***';
        }
    }
    else{
      $pdostatement = $pdo->prepare( " SELECT * FROM  users WHERE email=:email" );
      $pdostatement->bindValue(':email',$email);
      $pdostatement->execute();
      $result = $pdostatement->fetch(PDO::FETCH_ASSOC);
      if($result){
        echo"<script>alert('Email has already registered...');</script>";
      }else{
        $pdo_statement = $pdo->prepare( " INSERT INTO users (name,email,password) VALUES (:name,:email,:password) " );
        $result2 = $pdo_statement->execute(
          array(
            ':name' =>$name,
            ':email' => $email,
            ':password' => $password
          )
        );
        if ($result2) {
          echo "<script>alert('Successfully Registered.Please Login..' );window.location.href='login.php';</script>";
        };
      }
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>User Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>User Login </b> Blog</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <h4 class="login-box-msg">Register</h4>

      <form action="register.php" method="post">
        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
        <p style="color:red;font-size:13px;"><b><?php echo  empty($nameError) ? '' : $nameError;?></b></p>
        <div class="input-group mb-3">
          <input type="text" name="name" class="form-control" placeholder="Name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <p style="color:red;font-size:13px;"><b><?php echo empty($emailError) ? '' : $emailError; ?></b></p>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <p style="color:red;font-size:13px;"><b><?php echo empty($passwordError) ? '' : $passwordError;  ?></b></p>
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
            <button class="btn btn-primary btn-block" type="submit" >Register</button><br>
            <a href="login.php" type="button" class="btn btn-success" style="Width:100%">Back</a>
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
