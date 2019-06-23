<?php
session_start();
$action = $_GET["action"];
$total = $_GET["total"];
if (!isset($id) && !isset($action)) {
  $URL = "index.php";
  echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
  echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
elseif(isset($action))
{
	if($_GET["action"] == "pay")
	{
?>
<!DOCTYPE html>
<html lang="bg">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style/buynext.css"/>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
  </head>
  <body>
    <?php
      include 'inc/nav.php';
    ?>
      <form action="buynextstep.php" method="POST">
        <h1>Това са вашите поръчки</h1>
        <?php
        $cart = $_SESSION["shopping_cart"];
        // $idarr is an array for colecting the id's of the products which are in the cart

        $idarr = array();

        // $qarr is an array for colecting the quantities from the form in view.php
        $qarr = array();

        // $oneitemarr is an array for colecting the total price for each product in the cart
        $oneitemarr = array();
        foreach ($cart as $keys => $values) {
          //Here we are inserting the values in the arrays
          $idarr[] = $values["item_id"];
          $qarr[] = $values["item_quantity"];
          $onetotal = number_format($values["item_quantity"] * $values["item_price"], 2);
          $oneitemarr[] = $onetotal;
        ?>
        <div class="showdivs">
        <?php
        include 'inc/dbconn.php';

        //I use this query to take the pictures for the products in the cart

        $sql = "SELECT * FROM cvetqtb WHERE id='".$values["item_id"]."'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($result);
        $sqlimg = "SELECT * FROM images WHERE productid='".$values["item_id"]."'";
        $resultimg = mysqli_query($conn,$sqlimg);
        $rowimg = mysqli_fetch_assoc($resultimg);

        ?>
        <img src="<?php echo $rowimg["img"]; ?>">
        <p>Цена: <?php echo $values["item_price"]; ?> лв.</p>
        <p>Количество: <?php echo $values["item_quantity"]; ?></p>
        <p>Крайна цена за продукт: <?php echo $onetotal; ?> лв.</p>
        </div>
        <?php
        }
        echo ('<p>Обща стойност: '.$total.' лв.</p>');
      }
    }
        ?>
        <hr/>
        <h1>Персонални данни</h1>
        <?php
        //With implode function we are inserting commas between objects in the array
        
        $insertidarr = implode(',',$idarr);
        $insertqarr = implode(',',$qarr);
        $inserttotalarr = implode(',',$oneitemarr);

        ?>

        <input type="hidden" name="prid" value="<?php echo $insertidarr;?>">
        <input type="hidden" name="quant" value="<?php echo $insertqarr;?>">
        <input type="hidden" name="itemtotalprice" value="<?php echo $inserttotalarr;?>">
        <input type="hidden" name="totalprice" value="<?php echo $total;?>">
        <input type="text" name="Name" placeholder="Име">
        <input type="text" name="Fam" placeholder="Фамилия">
        <input type="text" name="Num" placeholder="Тел. за връзка">
        <input type="submit" name="submitfornext" value="Напред">
    </form>
    <?php
      include 'inc/footer.php';
    ?>
  </body>
</html>
