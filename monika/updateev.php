<?php
  if (!isset($_POST["submitev"]) && !isset($_SESSION["user"])) {
    $URL = "index.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
  }
  else{
    ?>
    <link rel="stylesheet" type="text/css" href="style/alerts.css"/>
    <?php
    include 'inc/dbconn.php';
    $id = $_GET["id"];
    if(!empty($_POST["name"]) && !empty($_POST["des"]))
    {
        $name = $_POST["name"];
        $des = $_POST["des"];
        $stmt = $conn->prepare("UPDATE cvetqtb SET name = ?, des = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $des, $id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        $URL = "cp.php";
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
    elseif(!empty($_POST["name"]))
    {
        $name = $_POST["name"];
        $stmt = $conn->prepare("UPDATE cvetqtb SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        $URL = "cp.php";
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
    elseif(!empty($_POST["des"]))
    {
        $des = $_POST["des"];
        $stmt = $conn->prepare("UPDATE cvetqtb SET des = ? WHERE id = ?");
        $stmt->bind_param("si", $des, $id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        $URL = "cp.php";
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
    else
    {
        $conn->close();
        echo("<div class='alert'>");
        echo("<p>Попълнете някое от полетата</p>");
        echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");
        echo("</div>");
    }
  }
