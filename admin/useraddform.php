






<?php
  require '../config/config.php';
  session_start();

  if(!empty($_POST)){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($_POST['role'])){
      $role=0;
    } else {
      $role = 1;
    }
      if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || strlen($_POST['password']) < 4){

          if (empty($_POST['name'])){
            $nameError = 'Please fill account name';
          }
          if (empty($_POST['email'])){
            $emailError = 'Please fill account email';
          }
          if (empty($_POST['password'])){
            $passwordError = 'Please fill account password';
          }
          if (strlen($_POST['password']) < 4 ) {
            $passwordError = 'Password must be at least 4 character to be strong...';
          }



      } else {
        $pdo_statement = $pdo->prepare(" SELECT * FROM users WHERE email = :email ");
        $pdo_statement->execute(
          array(
            ':email'=> $email
          )
        );
        $emailResult = $pdo_statement->fetchAll();
        if ($emailResult){
          echo"<script>alert('Your email is already Registered.')</script>";
        }else {
          $pdo_stmt = $pdo->prepare (" INSERT INTO users(name,email,password,role) VALUES (:name,:email,:password,:role) ");
          $insertResult = $pdo_stmt -> execute(
            array(
              ':name' => $name,
              ':email' => $email,
              ':password' => $password,
              ':role' => $role
            )
          );
          echo"<script>alert('Sucessfully Registered.');window.location.href='useradd.php'</script>";
        }

      }
    // print"<pre>";
    // print_r($result);exit();
    // echo"<script>alert('Wrong email or password')</script>";
  }


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Blogs | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href=""><b>Login </b> Account Creation</a>
  </div>
  <!-- /.login-logo -->
  <div class="card card-info">
    <div class="card-header">
      <h3 class="card-title">User Add Form</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal" action="useraddform.php" method="post" enctype="multipart/form-data">
      <div class="card-body">
        <div class="form-group ">
          <label for="inputEmail3" class="col-form-label">Name</label>
          <p style="color:blue;"><?php echo empty($nameError) ? '' : $nameError ?></p>
            <input type="text" name="name" class="form-control"  placeholder="Name" >
          </div>
          <div class="form-group ">
            <label for="inputEmail3" class="col-form-label">Email</label>
            <p style="color:blue;"><?php echo empty($emailError) ? '' : $emailError ?></p>
              <input type="email" name="email" class="form-control"   placeholder="Email">
          </div>
          <div class="form-group ">
            <label for="inputPassword3" class="col-form-label">Password</label>
            <p style="color:blue;"><?php echo empty($passwordError) ? '' : $passwordError ?></p>
              <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password" >
          </div>
          <div class="form-group ">
              <div class="form-check" style="padding-left:0px !important;">
                <input type="checkbox" class="" name="role" >
                <label class="form-check-label" for="exampleCheck2"> <b>Create Admin Account</b> </label>
              </div>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-info">Create</button>
          <a href="useradd.php" type="button" class="btn btn-success" style="float:right;" >Back</a>
        </div>
      </div>
      <!-- /.card-body -->

      <!-- /.card-footer -->
    </form>
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>

</body>
</html>
