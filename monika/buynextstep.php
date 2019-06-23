<?php
session_start();
if (!isset($_POST["submitfornext"])) {
  $URL = "index.php";
  echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
  echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
else {
  $_SESSION["Name"] = $_POST["Name"];
  $name = $_SESSION["Name"];
  $_SESSION["Fam"] = $_POST["Fam"];
  $fam = $_SESSION["Fam"];
  $_SESSION["Num"] = $_POST["Num"];
  $num = $_SESSION["Num"];
  ?>
  <link rel="stylesheet" type="text/css" href="style/buynext.css"/>
  <?php
  if (empty($name)) {
    echo('<div class="showdivs" id="show">');
    echo('<h1>Попълнете празните полета</h1>');
    echo("<a href='javascript:history.back()'>&#10004;</a>");
    echo('</div>');
  }
  elseif (is_numeric($name)) {
    echo('<div class="showdivs" id="show">');
    echo('<h1>Въвели сте само цифри за Име</h1>');
    echo("<a href='javascript:history.back()'>&#10004;</a>");
    echo('</div>');
  }
  elseif (empty($fam)) {
    echo('<div class="showdivs" id="show">');
    echo('<h1>Попълнете празните полета</h1>');
    echo("<a href='javascript:history.back()'>&#10004;</a>");
    echo('</div>');
  }
  elseif (is_numeric($fam)) {
    echo('<div class="showdivs" id="show">');
    echo('<h1>Въвели сте цифри в полето за Фамилия</h1>');
    echo("<a href='javascript:history.back()'>&#10004;</a>");
    echo('</div>');
  }
  elseif (empty($num)) {
    echo('<div class="showdivs" id="show">');
    echo('<h1>Попълнете празните полета</h1>');
    echo("<a href='javascript:history.back()'>&#10004;</a>");
    echo('</div>');
  }
  elseif (!is_numeric($num)) {
    echo('<div class="showdivs" id="show">');
    echo('<h1>Телефонът трябва да съдържа само цифри</h1>');
    echo("<a href='javascript:history.back()'>&#10004;</a>");
    echo('</div>');
  }
  elseif (strlen($num) < 10) {
    echo('<div class="showdivs" id="show">');
    echo('<h1>Телефонът не трябва да е по-малко от 10 цифри</h1>');
    echo("<a href='javascript:history.back()'>&#10004;</a>");
    echo('</div>');
  }
  else{

?>
<!DOCTYPE html>
<html lang="bg">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style/buynext.css"/>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
    <script>
    function show(){
      var panelshow = document.getElementById("doors");
      panelshow.style.display = "block";
      var panelhide = document.getElementById("Officediv");
      panelhide.style.display = "none";
    }
    function show2(){
      var panelshow = document.getElementById("Officediv");
      panelshow.style.display = "block";
      var panelhide = document.getElementById("doors");
      panelhide.style.display = "none";
    }
</script>
  </head>
  <body>
    <?php
      include 'inc/nav.php';
      include 'inc/dbconn.php';
      $_SESSION["prid"] = $_POST["prid"];
      $prid = $_SESSION["prid"];
      $_SESSION["quant"] = $_POST["quant"];
      $quant = $_SESSION["quant"];
      $_SESSION["itemtotalprice"] = $_POST["itemtotalprice"];
      $itemtotalprice = $_SESSION["itemtotalprice"];
      $_SESSION["totalprice"] = $_POST["totalprice"];
      $totalprice = $_SESSION["totalprice"];

      //This query takes the orders id from clients table
      $sqlid = "SELECT orderid FROM clients ORDER BY id";
      $result = mysqli_query($conn, $sqlid);
      $row = mysqli_fetch_assoc($result);
      $randid = mt_rand(1,999999999);
      //Here we check if there are coincidences between calculated random number and orders id from the clients table
      if($randid == $row["orderid"]){
        //If there is a coincidence, we are generating new random number for order id
        $randid = mt_rand(1,999999999);
      }
      $stmt = $conn->prepare("INSERT INTO clients(name, fam, num, orderid) VALUES(?,?,?,?)");
      $stmt->bind_param("sssi",$name, $fam, $num, $randid);
      $stmt->execute();
      $stmt->close();
    ?>
      <form action="ready.php" method="POST">
        <h1>Това са вашите поръчки</h1>
        <?php
        $cart = $_SESSION["shopping_cart"];
        foreach ($cart as $keys => $values) {
          $onetotal = number_format($values["item_quantity"] * $values["item_price"], 2);
        ?>
        <div class="showdivs">
        <?php
        include 'inc/dbconn.php';
        //We are displaying the products again for the final step
        $sql = "SELECT * FROM cvetqtb WHERE id='".$values["item_id"]."'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($result);
        $sqlimg = "SELECT * FROM images WHERE productid='".$values["item_id"]."'";
        $resultimg = mysqli_query($conn,$sqlimg);
        $rowimg = mysqli_fetch_assoc($resultimg);

        ?>
        <img src="<?php echo $rowimg["img"]; ?>">
        <p>Цена: <?php echo $values["item_price"]; ?> лв.</p>
        <p>Количество: <?php echo $values["item_quantity"];?></p>
        <p>Крайна цена за продукт: <?php echo $onetotal;?> лв.</p>
        </div>
      <?php
        }
        echo ('<p>Обща стойност: '.$totalprice.' лв.</p>');
      ?>
        <hr/>
        <?php
        //We are takeing the client order number to insert it later in the query table with a few more values
        $clientsql = "SELECT * FROM clients WHERE orderid='".$randid."'";
        $resultclient = mysqli_query($conn,$clientsql);
        $rowclient = mysqli_fetch_assoc($resultclient);
        $clientid = $rowclient["orderid"];
        ?>
        <input type="hidden" name="clientid" value="<?php echo $clientid;?>">
        <input type="hidden" name="prid" value="<?php echo $prid;?>">
        <input type="hidden" name="quant" value="<?php echo $quant;?>">
        <input type="hidden" name="itemtotalprice" value="<?php echo $itemtotalprice;?>">
        <input type="hidden" name="totalprice" value="<?php echo $totalprice;?>">
        <h1>Начин на доставка</h1>
        <div class="offl">
        <p>Еконт Доставка</p>
        <!--Here the user will choose how to proceed the delivery...I'm useing a little bit Java Script-->
          <label for="offices" onclick="show2()">Еконт Експрес - до офис</label><input type="radio" name="Office" value="offices" id="offices">
          <div class="panel" id="Officediv">
            <?php
            echo('<select name="ekontoffice">');
            echo('<option value="0">Моля изберете</option>');
            //Here I'm displaying XML data in a list of the offices for deliver
              $path = "wow.xml";
              $xmlfile = file_get_contents($path);
              $xml = simplexml_load_string($xmlfile);
              $json = json_encode($xml);
              $xmlobj = json_decode($json, true);
              for($city=0; $city<=count($xmlobj['offices']['e']); $city++)
              {
                echo('<option value="'.$xmlobj['offices']['e'][$city]['address'].'">'.$xmlobj['offices']['e'][$city]['address'].'</option>');
              }
                echo('</select>');
            ?>
        </div>
        <!--This is option for delivery to home address-->
          <label for="door" onclick="show()">Еконт Експрес - до адрес</label><input type="radio" name="Office" value="door"  id="door"></br>
            <div class="panel" id="doors">
            <input type="text" name="Citytocome" placeholder="Град">
            <input type="text" name="Address" placeholder="Адрес">
          </div>
      </div>
      <input type="submit" name="submitready" value="Напред">
  </form>
  <?php
  }
}
  ?>
  <?php
    include 'inc/footer.php';
  ?>
  </body>
</html>
