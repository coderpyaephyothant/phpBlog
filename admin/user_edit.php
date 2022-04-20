
<?php
session_start();
  require '../config/config.php';
  require '../config/common.php';

  if( empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) && empty($_SESSION['user_name'])){
    echo "<script>alert('please login first.');window.location.href='login.php'</script>";
  }
  if($_SESSION['role'] != 1 ){
    echo "<script>alert('Must be Admin Account..');window.location.href='login.php'</script>";
  }
  if(!empty($_POST)){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
        $id = $_POST['id'];
        if ( empty($_POST['role']) ){
            $role=0;
          } else {
            $role = 1;
          }
            if (empty($_POST['name']) || empty($_POST['email']) || !empty($_POST['password'])&& strlen($_POST['password'])<4 ) {
                if (empty($_POST['name'])){
                  $nameError = 'Please fill account name...';
                }
                if(empty($_POST['email'])){
                  $emailError = 'Please fill account email...';
                }
                if( !empty($_POST['password']) && strlen($_POST['password']) < 4 ){
                  $passwordError = 'Password shoud be at least 4 character..';
                }
            }
            else {
              $pdo_statement2 = $pdo ->prepare ( " SELECT * FROM users WHERE email=:email AND id!=:id");
              $pdo_statement2 -> execute(
                array (
                  ':email'=> $email,
                  ':id' => $id
                )
              );
              $user_result2 = $pdo_statement2->fetch(PDO::FETCH_ASSOC);
              // print"<pre>";
              // print_r($user_result2);exit();
              if (!empty($user_result2)){
                echo"<script>alert('Your Email is duplicated.');</script>";
              }else{
                if (!empty($_POST['password'])){
                  $pdo_stmt = $pdo->prepare (" UPDATE users SET name='$name', email='$email',password='$password', role='$role' WHERE id=$id");
                }else {
                  $pdo_stmt = $pdo->prepare (" UPDATE users SET name='$name', email='$email', role='$role' WHERE id=$id");
                }
                $updateResult = $pdo_stmt -> execute();
                if($updateResult){
                  echo"<script>alert('Sucessfully Edited.');window.location.href='useradd.php'</script>";
                }
              }
            }
          }
    // print"<pre>";
    // print_r($user_result);
    $pdo_statement = $pdo ->prepare ( " SELECT * FROM users WHERE id=".$_GET['id']);
    $pdo_statement -> execute();
    $user_result = $pdo_statement->fetchAll();
    // print"<pre>";
    // print_r($result);exit();
    // echo"<script>alert('Wrong email or password')</script>";
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Blogs | User Edit</title>
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
    <a href=""><b>User Account </b>Edition</a>
  </div>
  <!-- /.login-logo -->
  <div class="card card-info">
    <div class="card-header">
      <h3 class="card-title">User Edit Form</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
      <div class="card-body">
        <input type="hidden" name="id" value="<?php echo $user_result [0] ['id'] ?>">
        <div class="form-group ">
          <label for="inputEmail3" class="col-form-label">Name</label>
          <p style="color:blue;"><?php echo empty($nameError) ? '' : $nameError ?></p>
            <input type="text" name="name" class="form-control" value="<?php echo $user_result[0] ['name'] ?>"  placeholder="Name" >
          </div>
          <div class="form-group ">
            <label for="inputEmail3" class="col-form-label">Email</label>
            <p style="color:blue;"><?php echo empty($emailError) ? '' : $emailError ?></p>
              <input type="email" name="email" class="form-control" value="<?php echo $user_result [0] ['email'] ?>"   placeholder="Email" >
          </div>
          <div class="form-group ">
            <label for="inputEmail3" class="col-form-label">Password</label>
            <p style="font-size:12px; color:red;">password has already taken But you can change it again.. </p>
            <p style="color:blue;"><?php echo empty($passwordError) ? '' : $passwordError ?></p>
              <input type="password" name="password" class="form-control" value=""   placeholder="Password" >
          </div>
          <div class="form-group ">
              <div class="form-check" style="padding-left:0px !important;">
                <input type="checkbox" class="" name="role" <?php if($user_result [0] ['role'] == '1' ) {echo "checked";} ?> >
                <label class="form-check-label" for="exampleCheck2"> <b>Create Admin Account</b> </label>
              </div>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-info">Update</button>
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
