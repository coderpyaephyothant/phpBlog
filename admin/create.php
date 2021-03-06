
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
    if (empty($_POST['titleHead']) || empty($_POST['content']) || empty($_FILES['image']['name'])) {

      if (empty($_POST['titleHead'])){
        $titleHeadError = 'Please Fill the title header..';
      }

      if (empty($_POST['content'])) {
        $contentError = 'Please Fill the content..';
      }

      if (empty($_FILES['image']['name'])) {
        $imageError = 'Please Upload the image file..';
      }

    }else {

      $target_file = '../images/'.($_FILES['image']['name']);
      $file_type = pathinfo($target_file,PATHINFO_EXTENSION);
      if ($file_type != 'png' && $file_type != 'jpg' && $file_type != 'jpeg' ){
        echo "<script>alert(file type must be PNG, JPG or JPEG);</script>";
      }else {
        $titleHead = $_POST['titleHead'];
        $content = $_POST['content'];
        $image = $_FILES['image']['name'];
        // echo "$titleHead,$content";exit();
        move_uploaded_file( $_FILES['image']['tmp_name'],$target_file );
        $pdo_statement = $pdo->prepare( " INSERT INTO posts (title,content,image,author_id) VALUES (:title,:content,:image,:author_id) " );
        $result = $pdo_statement->execute(
          array(
            ':title' =>$titleHead,
            ':content' => $content,
            ':image' => $image,
            ':author_id' => $_SESSION['user_id']
          )
        );
        if ($result) {
          echo "<script>alert('Successfully Created...' );window.location.href='index.php';</script>";
        };

      }

    }
}

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
                <form class="" action="create.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <p style="color:blue;"><?php echo empty($titleHeadError) ? '': $titleHeadError ?></p>
                    <input class="form-control" type="text" name="titleHead" value="">
                    </div>

                    <div class="form-group">
                      <label for="content">Content</label>
                      <p style="color:blue;"><?php echo empty($contentError) ? '': $contentError ?></p>
                      <textarea class="form-control" name="content" rows="8" cols="80"></textarea>
                      </div>

                      <div class="form-group">
                        <label for="image">Image</label>
                        <p style="color:blue;"><?php echo empty($imageError) ? '': $imageError ?></p>
                        <input  type="file" name="image" value="">
                      </div>

                      <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="title" value="Submit">
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
