<!DOCTYPE html>
<html lang="bg">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style/index.css"/>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
  </head>
  <body>
		<?php
		include 'inc/nav.php';
		?>
    <h1 class="producth1">Продукти</h1>
		<div class="parent">
      <?php
      include 'inc/sidecategory.php';
        if (isset($_GET["category"])) {
          $catid = $_GET["category"];
      ?>
      <div class="savedlist">
      <?php
      include "inc/dbconn.php";
      $query = "SELECT * FROM cvetqtb WHERE categoryid=$catid";
      $result = mysqli_query($conn, $query);
      if(mysqli_num_rows($result) > 0)
      {
        while($row = mysqli_fetch_array($result))
        {
          $productid = $row["id"];
          $sqlimg = "SELECT * FROM images WHERE productid=$productid";
          $resultimg = mysqli_query($conn, $sqlimg);
          $rowimg = mysqli_fetch_assoc($resultimg);
      ?>
        <div class="showdivs">
          <img src="<?php echo $rowimg["img"]; ?>">
          <p class="namep"><?php echo $row["name"]; ?></p>
          <?php
          if (!empty($row["promoprice"])) {
          ?>
            <p class="pricep"><span class="forpromo"><?php echo $row["price"]; ?> лв.</span></p>
            <p class="promo">Промо: <?php echo $row["promoprice"]; ?> лв.</p>
          <?php
          }
          else{
          ?>
            <p class="pricep"><?php echo $row["price"]; ?> лв.</p>
            <p class="notpromo"><br/></p>
          <?php
          }
          ?>
          <div class="showbtns">
          <a href="view.php?id=<?php echo $row["id"];?>" class="view"><i class='fas fa-search'></i></a>
          </div>
        </div>
        <?php
          }
        }
        ?>
      </div>
    </div>
      <?php
        }
      ?>
    </div>
		<?php
		include 'inc/footer.php';
		?>
  </body>
</html>
