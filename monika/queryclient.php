<?php
  session_start();
  $id = $_GET["clientid"];
  $prid = $_GET["prid"];
  if (empty($id) || empty($prid) || empty($_SESSION["user"])) {
    $URL = "index.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
  }
?>
<!DOCTYPE html>
<html lang="bg">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style/cp.css"/>
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>
    <?php
      include 'inc/dbconn.php';
      include 'inc/navcp.php';
      //Here we are using $prid variable which is an array of objects
      
      $sql = "SELECT * FROM cvetqtb WHERE id IN ($prid)";
      $result = mysqli_query($conn,$sql);
      echo('<div class="savedlist">');
      
      //We are using $id variable to sort the products which the selected client has ordered
      
      $sql2 = "SELECT * FROM query WHERE clientid=$id";
      $result2 = mysqli_query($conn,$sql2);
      $row2 = mysqli_fetch_assoc($result2);
      
      //With str_replace function we are removing the commas from the string
      
      $repl = str_replace(","," ",$row2["quant"]);
      
      //With explode function we are converting the string into an array
      
      $strtoarr = explode(" ", $repl);
      
      //We are making the same steps with the total price for each product
      
      $repl2 = str_replace(","," ",$row2["itemtotalprice"]);
      $strtoarr2 = explode(" ", $repl2);
      
      /*This for cycle displays the pictures and some data for the ordered products
      and sorting the objects in the arrays*/
      
      for($i=0; $i<count($strtoarr); $i++)
      {
        $row = mysqli_fetch_assoc($result);
        $row2 = mysqli_fetch_assoc($result2);

        echo('<div class="showdivs">');
        echo('<p>'.$row["name"].'</p>');
        echo('<p>Общо: '.$strtoarr2[$i].' лв.</p>');
        echo('<p>Количество: '.$strtoarr[$i].'</p>');
        echo('</div>');
      }
      echo('</div>');
      mysqli_close($conn);
    ?>
  </body>
</html>
