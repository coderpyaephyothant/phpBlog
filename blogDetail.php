
<?php
require 'config/config.php';
session_start();
if( empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) && empty($_SESSION['user_name'])){
  echo "<script>alert('please login first.');window.location.href='login.php'</script>";
};
// echo $_SESSION['logged_in']; exit();
$pdo_statement = $pdo->prepare("SELECT * FROM posts WHERE  id=".$_GET['id']);
$pdo_statement->execute();
$result = $pdo_statement->fetchAll();

//select comments with post idea
$id=$_GET['id'];
$cmstatement = $pdo->prepare("SELECT * FROM comments WHERE  post_id=".$_GET['id']);
$cmstatement->execute();
$cmresult = $cmstatement->fetchAll();
// print"<pre>";
// print_r($cmresult);exit();

//select username with post commentMaker
$authorResult=[];
if($cmresult){
  foreach ($cmresult as $key => $value) {
    $author_id = $cmresult[$key]['author_id'];
    $austatement = $pdo->prepare("SELECT * FROM users WHERE  id=$author_id");
    $austatement->execute();
    $authorResult[] = $austatement->fetchAll();
  }
}
// print"<pre>";
// print_r($authorResult);exit();






if(!empty($_POST)){

    $comment = $_POST['comment'];
    if (empty($_POST['comment'])){
      $commentError = 'Comment cannot be empty..Please try again...';
    }else{
      $pdo_statement = $pdo->prepare( " INSERT INTO comments (content,author_id,post_id) VALUES (:content,:author_id,:post_id) " );
      $result2 = $pdo_statement->execute(
      array(
      ':content' =>$comment,
      ':author_id' => $_SESSION['user_id'],
      ':post_id' => $id

          )
        );
        if ($result2) {
          header('Location: blogdetail.php?id='.$id);
        };
    }




  }






 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pyae Phyo Thant Blogs</title>
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
  <div class="content-wrapper" style="margin-left:0px !important;">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content" >


      <div class="container" style="padding-left:5rem !important; padding-right:5rem !important;">
        <!-- <div class="col-md-8"> -->
          <!-- Box Comment -->
          <a href="index.php" type="button" class="btn btn-primary" style="margin-top:1rem !important; ">Back to Home</a> <br> <br>
          <div class="card card-widget">

              <div class="card-header">

                <!-- /.user-block -->
                <h4 style="text-align:center !important; float:none"><?php echo $result [0] ['title'] ?></h4 >
                <!-- /.card-tools -->
              </div>
              <!-- /.user-block -->
              <!-- /.card-tools -->

            <!-- /.card-header -->
            <div class="card-body">
              <img class="img-fluid pad" style="width:100% !important;" src="images/<?php echo $result [0]  ['image'] ?>" alt="Photo"><br><br>

              <p><?php echo $result [0] ['content'] ?></p>
              <!-- <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i> Share</button>
              <button type="button" class="btn btn-default btn-sm"><i class="far fa-thumbs-up"></i> Like</button>
              <span class="float-right text-muted">127 likes - 3 comments</span> -->

            </div>
            <!-- /.card-body -->
            <div class="card-footer card-comments">
              <h4>Comments</h4> <hr>
              <div class="card-comment">



                <?php
                if ($cmresult){
                  $id=1;
                  foreach ($cmresult as $key => $value) {
                  ?>
                  <div class="comment-text" style="margin-left:0px !important;">
                    <span class="username">
                      <?php print_r($authorResult[$key][0]['name'])  ?>
                      <span class="text-muted float-right"><?php echo $value['created_at'] ?></span>
                    </span><!-- /.username -->
                    <?php echo($value)['content'] ?>

                  </div> <hr> <br>

                <?php
              $id ++;
            }
          }

                 ?>
                <!-- /.comment-text -->
              </div>
              <!-- /.card-comment -->
              <!-- /.card-comment -->
            </div>
            <!-- /.card-footer -->
            <div class="card-footer">
              <form action="" method="post">
                <!-- <img class="img-fluid img-circle img-sm" src="dist/img/user4-128x128.jpg" alt="Alt Text"> -->
                <!-- .img-push is used to add margin to elements next to floating images -->
                <div class="img-push">
                  <p style="color:red;"><?php echo empty($commentError) ? '' : $commentError; ?></p>
                  <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                </div>
              </form>
            </div>
            <!-- /.card-footer -->
          </div>
      </div>





    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left:0px !important;">
  <!-- To the right -->
  <div class="float-right d-none d-sm-inline" style="margin-right:100px !important;">
    <a href="logout.php" type="button" class="btn btn-info">Logout</a>
  </div> <br>
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
