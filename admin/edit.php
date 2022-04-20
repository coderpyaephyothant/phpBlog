
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

if($_POST){
  if (empty($_POST['titleHead']) || empty( $_POST['content'])) {

      if (empty($_POST['titleHead'])){
        $titleHeaderError = 'Please fill the title header';
      }

      if (empty($_POST['content'])){
        $contentError = 'Please fill the content';
      }


  }else{

    $titleHeader = $_POST['titleHead'];
    $content  = $_POST['content'];
    $image = $_FILES['image']['name'];
    $id = $_POST['id'];
    $targetFile = '../images/'.($_FILES['image']['name']);
    $fileType = pathinfo($targetFile,PATHINFO_EXTENSION);
    if ($_FILES['image']['name'] != null){

      if ($fileType != 'png' && $fileType != 'jpg' && $fileType != 'jpeg' ){
        echo "<script>alert('Image file must be JPG PNG or JPEG');</script>";
      }else{

        move_uploaded_file($_FILES['image']['tmp_name'],$targetFile);
        $pdo_stmt = $pdo->prepare("UPDATE posts SET title='$titleHeader', content='$content', image='$image' WHERE id='$id'");
        $result1 = $pdo_stmt->execute();
        if($result1){
          echo "<script>alert('Successfully Updated with Files');window.location.href='index.php';</script>";
        }
      }
    }else {
      $pdo_stmt = $pdo->prepare("UPDATE posts SET title='$titleHeader', content='$content' WHERE id='$id'");
      $result2 = $pdo_stmt->execute();
      if($result2){
        echo "<script>alert('Successfully Updated with no Files');window.location.href='index.php';</script>";
      }
    }

  }



}

  $pdo_statement = $pdo->prepare("SELECT * FROM posts WHERE  id=".$_GET['id']);
  $pdo_statement->execute();
  $result = $pdo_statement->fetchAll();
  // print"<pre>";
  // print_r($result);exit();


 ?>

 <?php
 include('header.php');
  ?>


    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form class="" action="" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                  <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $result [0] ['id'] ?>">
                    <label for="title">Title</label>
                    <p style="color:blue"><?php echo empty($titleHeaderError) ? '' : $titleHeaderError ?></p>
                    <input class="form-control" type="text" name="titleHead" value="<?php echo $result [0] ['title'] ?>">
                    </div>
                    <div class="form-group">
                      <label for="content">Content</label>
                      <p style="color:blue"><?php echo empty($contentError) ? '' : $contentError ?></p>
                      <textarea class="form-control" name="content" rows="8" cols="80"><?php echo $result [0] ['content'] ?></textarea>
                      </div>

                      <div class="form-group">
                        <label for="image">Image</label>
                        <img width="250px" src="../images/<?php echo $result [0] ['image'] ?>" alt="">
                        <input  type="file" name="image" value="">
                      </div>
                      <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="" value="Update">
                        <a href="index.php" class="btn btn-info">Back</a>
                        </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.card -->
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  <?php
  include('footer.html');
   ?>
