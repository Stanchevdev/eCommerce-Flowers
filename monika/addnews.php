<?php
  session_start();

  if (!isset($_SESSION["user"]) || !isset($_POST["submitnews"])) {
    $URL = "index.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
  }
  else {
    include 'inc/dbconn.php';
    $news = $_POST["news"];
    $id = $_POST["flowers"];
    if (empty($news)) {
      echo('<div class="what" id="show">');
      echo('<h1>Попълнете празните полета</h1>');
      echo("<a href='javascript:history.back()'>&#10004;</a>");
      echo('</div>');
    }
    elseif (empty($id)) {
      echo('<div class="what" id="show">');
      echo('<h1>Изберете цвете</h1>');
      echo("<a href='javascript:history.back()'>&#10004;</a>");
      echo('</div>');
    }
    else {
      $stmt = $conn->prepare("INSERT INTO news(news, flowerid) VALUES(?,?)");
      $stmt->bind_param("si", $news, $id);
      $stmt->execute();
      $stmt->close();
      $conn->close();
      $URL = "index.php";
      echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
      echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
  }
?>
