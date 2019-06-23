<?php
// session_start();
?>
<!DOCTYPE html>
<html lang="bg">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style/nav.css"/>
    <link href="https://fonts.googleapis.com/css?family=Aguafina+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
  </head>
  <body>
    <?php
      include 'dbconn.php';
    ?>
    <div class="overnav">
      <!-- <img src="style/logo.png"/> -->
      <a href="index.php">FlowerMoni.com</a>
    </div>
    <div class="nav">
      <a href="tel:0893887757" class="tellme">Обадете ни се и на телефон: +359 893 887 757 &nbsp;&nbsp;<i class="fa fa-phone"></i></a>
      <a href="index.php" class="all">Начало</a>
      <!-- <a href="products.php" class="all">Продукти</a> -->
      <a href="contacts.php" class="all">Контакти</a>
      <a href="forus.php" class="all">За нас</a>
      <?php
        if(!empty($_SESSION["shopping_cart"]))
        {
      ?>
            <a href="buy.php" class="all"><i class="fas fa-shopping-cart"></i><span class="counter"><?php echo count($_SESSION["shopping_cart"]);?></span></a>
    <?php
        
        }
        else
        {
      ?>
      <a href="buy.php" class="all"><i class='fas fa-shopping-cart'></i><span class="counter"><?php echo 0;?></span></a>
      <?php
        }
      ?>
    </div>
  </body>
</html>
