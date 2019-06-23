<?php
  session_start();
  $id = $_GET["clientid"];
  if (empty($id) || empty($_SESSION["user"])) {
    $URL = "index.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
  }
  else{
    include 'inc/dbconn.php';
    $sql = "DELETE FROM query WHERE clientid=$id";
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    $URL = "query.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';

  }
