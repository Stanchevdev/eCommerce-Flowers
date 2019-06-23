<?php
  session_start();
  if (!empty($_GET["clientid"]) && !empty($_GET["prid"])) {
    $id = $_GET["clientid"];
    $prid = $_GET["prid"];
  }
  if (empty($_SESSION["user"])) {
    $URL = "index.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
  }
  else{

  }
  ?>
  <!DOCTYPE html>
  <html lang="bg">
    <head>
      <meta charset="UTF-8">
      <link rel="stylesheet" type="text/css" href="style/cpacc.css"/>
      <link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body>
      <?php
        include 'inc/dbconn.php';
        include 'inc/navcp.php';
        $sql = "SELECT * FROM query WHERE accepted='1'";
        $result = mysqli_query($conn,$sql);
        echo('<h1 align="center">Потвърдени заявки</h1>');
        echo('<div class="savedlist">');
        if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_assoc($result))
          {
            $rowid = $row["clientid"];
            $sql2 = "SELECT * FROM clients WHERE orderid IN ($rowid)";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $prid = $row["productid"];
            echo('<div class="showdivs">');
            echo('<p>Име: '.$row2["name"].' '.$row2["fam"].'</p>');
            echo('<p>Тел. за връзка: '.$row2["num"].'</p>');
            if ($row["wheretocome"] == 'offices') {
              echo('<p>Адрес на доставка: '.$row["ekont"].'</p>');
            }
            else{
              echo('<p>Адрес на доставка: '.$row["home"].', '.$row["homeadr"].'</p>');
            }
            echo('<p>Общо: '.$row["total"].' лв.</p>');
            echo('<div class="showbtns">');
            echo('<a href="delete.php?clientid='.$rowid.'" class="buttons"><i class="fas fa-trash-alt" style="background:#cc99ff; float:right;"></i></a>');
            echo('<a href="queryclient.php?clientid='.$rowid.'&prid='.$prid.'" class="buttons"><i class="fas fa-eye" style="background:#ccc;"></i></a>');
            echo('</div>');
            echo('</div>');
          }
        }
        else{
          echo('<div class="showdivs">');
          echo('<h1>Няма потвърдени заявки</h1>');
          echo('</div>');
        }
        echo('</div>');
        mysqli_close($conn);

      ?>
  </body>
  </html>
