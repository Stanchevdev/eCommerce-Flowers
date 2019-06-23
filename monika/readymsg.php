<?php
$code = $_GET["code"];
$email = $_GET["email"];
if (!isset($code) && !isset($email)) {
  $URL = "index.php";
  echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
  echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
else{
  include 'inc/dbconn.php';
  $code = $_GET["code"];
  $email = $_GET["email"];
  $name = $_GET["name"];
  $fam = $_GET["fam"];
  $msg = $_GET["msg"];
  $stmt = $conn->prepare("INSERT INTO messages(name, fam, email, msg, code) VALUES(?,?,?,?,?)");
  $stmt->bind_param("sssss", $name, $fam, $email, $msg, $code);
  $stmt->execute();
  $stmt->close();
  $conn->close();
  $URL = "contacts.php";
  echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
  echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
