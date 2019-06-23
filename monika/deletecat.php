<?php
  session_start();
  if (!isset($_SESSION["user"]) && !isset($_GET["id"])) {
    $URL = "index.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
  }
  else {
    $id = $_GET["id"];
    include 'inc/dbconn.php';
    $sql = "DELETE FROM category WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    $URL = "cp.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
  }
?>
