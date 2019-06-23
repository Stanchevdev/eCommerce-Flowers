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
    <link rel="stylesheet" type="text/css" href="style/cp.css"/>
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>
    <?php
      include 'inc/dbconn.php';
      include 'inc/navcp.php';
    ?>
    <p class="forforms">Форма за добавяне на новини</p>
    <!--Form for adding news-->
    <form method="POST" action="addnews.php">
      <input type="text" name="news" placeholder="Новина"/>
      <?php
        $sql = "SELECT * FROM cvetqtb ORDER BY id";
        $result = mysqli_query($conn, $sql);

        echo('<select name="flowers">');
        echo('<option value="0">Моля изберете</option>');
        while ($row = mysqli_fetch_assoc($result))
        {
          echo('<option value="'.$row["id"].'">'.$row["name"].'</option>');
        }
        echo('</select>');
      ?>
      <input type="submit" name="submitnews" value="Добави"/>
    </form>
        <p class="forforms">Форма за изтриване на новини</p>
    <?php
    //This is a table for displaying categories. You can delete a category from the table
      $sql = "SELECT * FROM news ORDER BY id";
      $result = mysqli_query($conn, $sql);
    ?>
    <div class="cart">
      <table>
        <tbody>
          <tr>
            <td class="categorytd">Новини</td>
          </tr>
          <?php
          while ($row = mysqli_fetch_assoc($result))
          {
             $flower = $row["flowerid"];
             $sqlfl = "SELECT * FROM cvetqtb WHERE id=$flower";
             $resulfl = mysqli_query($conn, $sqlfl);
             $rowfl = mysqli_fetch_assoc($resulfl);
             $img = $rowfl["img"];
          ?>
          <tr>
            <td><b><?php echo $row["news"];?></b></td><td> за продукт <b><?php echo $rowfl["name"];?></b></td>
            <td class="deletetd"><a href="deletenews.php?id=<?php echo $row["id"]; ?>"><span class="delete"><i class='fas fa-trash'></i></span></a></td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>

    <p class="forforms">Форма за добавяне на категории</p>
    <form method="POST" action="addcategory.php">
      <input type="text" name="category" placeholder="Категория"/>
      <input type="submit" name="submitcate" value="Добави"/>
    </form>
    <p class="forforms">Форма за изтриване на категории</p>
    <?php
    //This is a table for displaying categories. You can delete a category from the table
      $sql = "SELECT * FROM category ORDER BY id";
      $result = mysqli_query($conn, $sql);
    ?>
    <div class="cart">
      <table>
        <tbody>
          <tr>
            <td class="categorytd">Категория</td>
          </tr>
          <?php
          while ($row = mysqli_fetch_assoc($result))
          {
          ?>
          <tr>
            <td><?php echo $row["category"];?></td>
            <td class="deletetd"><a href="deletecat.php?id=<?php echo $row["id"]; ?>"><span class="delete"><i class='fas fa-trash'></i></span></a></td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
    <p class="forforms">Форма за добавяне на продукти</p>
    <form action="add.php" method="POST" enctype="multipart/form-data">
      <input type="file" name="file[]" multiple/>
      <input type="text" name="named" placeholder="Име на продукт"/>
      <input type="text" name="price" placeholder="Цена"/>
      <?php
      $sql = "SELECT * FROM category ORDER BY id";
      $result = mysqli_query($conn, $sql);

      echo('<select name="categories">');
        echo('<option value="0">Моля изберете</option>');

        while ($row = mysqli_fetch_assoc($result))
        {
          echo('<option value="'.$row["id"].'">'.$row["category"].'</option>');
        }
      echo('</select>');
      ?>
      <textarea placeholder="Описание на продукт" class="textarea" name="des"></textarea>
      <input type="submit" name="submitpicture" value="Добави"/>
    </form>
    <?php
    //Here we are displaying all of the products which we uploaded
      $sql = "SELECT * FROM cvetqtb ORDER BY id";
      $result = mysqli_query($conn, $sql);
      echo('<div class="savedlist">');
      while($row = mysqli_fetch_assoc($result))
      {
        $id = $row["id"];
        $sqlimg = "SELECT * FROM images WHERE productid=$id";
        $resultimg = mysqli_query($conn, $sqlimg);
        echo('<div class="showdivs">');
        while($rowimg = mysqli_fetch_assoc($resultimg)){
        echo('<img src="'.$rowimg["img"].'" width="100%" height="200px"/>');
        }
        echo('<p>'.$row["name"].'</p>');
        //Check if is set a promoprice
        //If there is a promotion we can edit it or remove it if we write the original price in the form
        if (!empty($row["promoprice"]))
        {
          echo('<p>Цена: <span class="forpromo">'.$row["price"].' лв.</span><br/> <span class="promo">'.$row["promoprice"].' лв.</span></p><form method="POST" action="setpromo.php?id='.$row["id"].'"><input type="text" name="promo" placeholder="Промоция"/><input type="submit" name="submitpromo" value="Задай"/></form>');
        }
        else
        {
          echo('<p>Цена: '.$row["price"].' лв.</p><form method="POST" action="setpromo.php?id='.$row["id"].'"><input type="text" name="promo" placeholder="Промоция"/><input type="submit" name="submitpromo" value="Задай"/></form>');
        }
        echo('<form method="POST" action="updateev.php?id='.$row["id"].'"><input type="text" name="name" placeholder="Име"/><input type="text" name="des" placeholder="Описание"/><input type="submit" name="submitev" value="Промени"/></form>');
        echo('<p class="des"><span>Описание:</span> '.$row["des"].'</p>');
        echo('<a href="del.php?id='.$row["id"].'">Изтрии</a>');
        echo('</div>');
      }
      echo('</div>');
      mysqli_close($conn);
    ?>
  </body>
</html>
