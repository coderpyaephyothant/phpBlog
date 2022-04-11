<?php
require '../config/config.php';
session_start();

$pdo_statement = $pdo->prepare("  DELETE FROM posts WHERE id=".$_GET['id']);
$result= $pdo_statement->execute();
if ($result){
  echo "<script>alert('Successfully Deleted');window.location.href='index.php';</script>";
}

 ?>
