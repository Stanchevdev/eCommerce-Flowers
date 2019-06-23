<?php
session_start();
if (!isset($_SESSION["user"])) {
  $URL = "index.php";
  echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
  echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
?>
<!DOCTYPE html>
<html lang="bg">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style/msg.css"/>
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>
    <?php
      include 'inc/dbconn.php';
      include 'inc/navcp.php';
      $sql = "SELECT * FROM messages ORDER BY id";
      $result = mysqli_query($conn,$sql);
      echo('<h1 align="center">Съобщения</h1>');
      echo('<div class="savedlist">');
      if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result))
        {
          echo('<div class="showdivs">');
          echo('<p>От: '.$row2["name"].' '.$row2["fam"].'</p>');
          echo('<p>Имейл: '.$row["email"].'</p>');
          echo('<div class="showbtns">');
          echo('<a href="deletemsg.php?clientid='.$row["id"].'" class="buttons"><i class="fas fa-trash-alt" style="background:#cc99ff; float:right;"></i></a>');
          echo('</div>');
          echo('</div>');
        }
      }
      else{
        echo('<div class="showdivs">');
        echo('<h1>Няма съобщения</h1>');
        echo('</div>');
      }
      echo('</div>');
      mysqli_close($conn);

    ?>
</body>
</html>
