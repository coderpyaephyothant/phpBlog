
<?php
require '../config/config.php';
session_start();
if( empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) && empty($_SESSION['user_name'])){
  echo "<script>alert('please login first.');window.location.href='login.php'</script>";
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
              <div class="card-header">
                <h3 class="card-title">User Lists</h3>
              </div>
              <!-- /.card-header -->
              <?php


              if(!empty($_GET['pageNumber'])){
                $pageNumber = $_GET['pageNumber'];
              } else {
                $pageNumber = 1;
              };
              $numberOfRecs = 2;

              $offset = ($pageNumber - 1) * $numberOfRecs;

               if(empty($_POST['search'])){
                 $pdo_stmt = $pdo->prepare("  SELECT * FROM users ORDER BY id DESC  ");
                 $pdo_stmt->execute();
                 $result1 = $pdo_stmt->fetchAll();
                 $totalPageNumber =  ceil(count($result1)/$numberOfRecs);


                 $pdo_statement = $pdo->prepare("  SELECT * FROM users ORDER BY id DESC LIMIT $offset,$numberOfRecs ");
                 $pdo_statement->execute();
                 $result2 = $pdo_statement->fetchAll();
                 // print"<pre>";
                 // print_r(count($result2));
               }else {
                 $searchKey = $_POST['search'];
                 $pdo_stmt = $pdo->prepare("  SELECT * FROM users WHERE name LIKE '%$searchKey%' ORDER BY id DESC  ");
                 $pdo_stmt->execute();
                 $result1 = $pdo_stmt->fetchAll();
                 $totalPageNumber =  ceil(count($result1)/$numberOfRecs);


                 $pdo_statement = $pdo->prepare("  SELECT * FROM users WHERE name LIKE '%$searchKey%'  ORDER BY id DESC LIMIT $offset,$numberOfRecs ");
                 $pdo_statement->execute();
                 $result2 = $pdo_statement->fetchAll();




               }


               ?>
              <div class="card-body">
                <a href="useraddform.php" class="btn btn-primary"><i class="fas fa-user-plus"></i>&nbsp;&nbsp;Add User</a> <br> <br>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th >#</th>
                      <th>Role</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th >Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($result2){
                      $id=1;

                      foreach ($result2 as $value) {
                      ?>
                      <tr>
                        <td> <?php echo $id ?></td>

                        <td> <?php if($value['role']== 1){echo "Admin"; }else { echo "User";} ?></td>
                        <td><?php echo  $value ['name'] ?></td>
                        <td>
                          <?php echo $value ['email'] ?>
                        </td>
                        <td>
                          <div class="btn-group">
                            <div class="container">
                              <a href="edit.php?id=<?php echo $value['id'] ?>" class="btn btn-primary">Edit</a>
                            </div>
                            <div class="container">
                              <a href="delete.php?id=<?php echo $value['id'] ?>"
                                onclick="return confirm('Are you sure you want to delete this item?')"
                                class="btn btn-danger">Delete</a>
                            </div>
                          </div>
                        </td>
                      </tr>

                    <?php
                  $id ++;
                }
                    }

                     ?>

                  </tbody>
                </table> <br>
                <nav aria-label="Page navigation example" style="float:right;">
                  <ul class="pagination">

                    <li class="page-item"><a class="page-link" href="?pageNumber=1">First</a></li>

                    <li class="page-item <?php if($pageNumber <= 1){echo'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageNumber <= 1){echo '#';}else{ echo "?pageNumber=".($pageNumber -1 );} ?>">Previous</a>
                    </li>

                    <li class="page-item">
                      <a class="page-link" href="#"><?php echo 'Page '. $pageNumber; ?></a>
                    </li>

                    <li class="page-item <?php if ($pageNumber >= $totalPageNumber){echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageNumber >= $totalPageNumber){ echo '#';} else {echo '?pageNumber='.($pageNumber + 1);} ?>">Next</a>
                    </li>

                    <li class="page-item"><a class="page-link" href="?pageNumber=<?php echo $totalPageNumber; ?>">Last</a></li>

                  </ul>
                </nav>
              </div>

              <!-- /.card-body -->







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
