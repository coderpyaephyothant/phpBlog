
<?php
require 'config/config.php';
require 'config/common.php';
session_start();
if( empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) && empty($_SESSION['user_name'])){
  echo "<script>alert('please login first.');window.location.href='login.php'</script>";
}
 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pyae Phyo Thant</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left:0px !important">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <a href="logout.php" type="button" class="btn btn-info" style="float:right;">Logout</a>
      <div class="container-fluid">
        <h1 style="text-align:center; color:green;"><b>Products and Details</b></h1>

      </div><!-- /.container-fluid --> <br> <br>


    </section>

    <!-- Main content -->
    <section class="content">


      <?php

      if(!empty($_GET['pageNumber'])){
        $pgnumber = $_GET['pageNumber'];



      }else {
      $pgnumber = 1;
      }
      $numberOfRecs = 6;
      $offset = ($pgnumber - 1 ) * $numberOfRecs;

      $pdo_stmt = $pdo->prepare("  SELECT * FROM posts ORDER BY id DESC  ");
      $pdo_stmt->execute();
      $Rawresult = $pdo_stmt->fetchAll();

      $totalPages = ceil(count($Rawresult)/$numberOfRecs);

      $pdo_stmt = $pdo->prepare("  SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numberOfRecs ");
      $pdo_stmt->execute();
      $result = $pdo_stmt->fetchAll();
      // print"<pre>";
      // print_r(count($result)); exit();
       ?>

      <div class="row">

        <?php
        if ($result){
          $id=1;
          foreach ($result as $value) {
          ?>
          <div class="col-md-4">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <!-- /.user-block -->
                <h4 style="text-align:center !important; float:none; color:grey;"><?php echo escape($value['title']) ?></h4 >
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="blogdetail.php?id=<?php echo escape($value['id'] )?>"><img class="img-fluid pad" width="250px" src="images/<?php echo $value  ['image'] ?>" alt="Photo" style="height:250px !important;width: 100% !important;"></a>
              </div>
              <!-- /.card-body -->
              <!-- /.card-footer -->
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>


        <?php
      $id ++;
    }
        }

         ?>
            <?php



            ?>


         <div class="" style="width:100%">
           <nav aria-label="Page navigation example" style="float:right; margin-right:0.5rem;">
             <ul class="pagination">
               <li class="page-item "><a class="page-link" href="?pageNumber=1">First</a></li>
               <li class="page-item <?php if($pgnumber <=1){ echo 'disabled';} ?>">
                 <a class="page-link" href="<?php if($pgnumber <=1){ echo '#';} else { echo "?pageNumber=".($pgnumber-1);} ?>">Previous</a></li>
               <li class="page-item"><a class="page-link" href="#"><?php echo 'Page '. $pgnumber ?></a></li>
               <li class="page-item <?php if($pgnumber >= $totalPages){ echo 'disabled';} ?>">
                 <a class="page-link" href="<?php if ($pgnumber >= $totalPages){ echo '#';} else {echo "?pageNumber=".($pgnumber +1 );} ?>">Next</a></li>
               <li class="page-item"><a class="page-link" href="?pageNumber=<?php echo $totalPages ?>">Last</a></li>
             </ul>
           </nav>
         </div>





        <!-- /.col -->
        <!-- /.col -->
      </div> <br>


    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left:0px !important;">
  <!-- To the right -->

  <!-- Default to the left -->
  <strong>Copyright &copy; 2023 <a href="#">Pyae Phyo Thant</a>.</strong> All rights reserved.
  </footer>
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
