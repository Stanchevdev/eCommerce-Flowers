<?php
  session_start();

  if (!isset($_POST["submitcate"])) {
    $URL = "index.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
  }
  else {
    include 'inc/dbconn.php';
    $category = $_POST["category"];
    if (empty($category)) {
      echo('<div class="what" id="show">');
      echo('<h1>Попълнете празните полета</h1>');
      echo("<a href='javascript:history.back()'>&#10004;</a>");
      echo('</div>');
    }
    elseif (is_numeric($category)) {
      echo('<div class="what" id="show">');
      echo('<h1>Въвели сте само цифри за Име на продукта</h1>');
      echo("<a href='javascript:history.back()'>&#10004;</a>");
      echo('</div>');
    }
    else{
      $stmt = $conn->prepare("INSERT INTO category(category) VALUES(?)");
      $stmt->bind_param("s", $category);
      $stmt->execute();
      $stmt->close();
      $conn->close();
    }
    $URL = "cp.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';

  }
?>
