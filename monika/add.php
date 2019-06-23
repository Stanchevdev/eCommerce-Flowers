<?php
if (!isset($_POST["submitpicture"]) && !isset($_SESSION["user"])) 
{
    $URL = "cp.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
else{
    include 'inc/dbconn.php';
    
    $name = $_POST["named"];
    $price = $_POST["price"];
    $des = $_POST["des"];
    $category = $_POST["categories"];
    $comma = ',';   
?>
    <link rel="stylesheet" type="text/css" href="style/alerts.css"/>
<?php
    if (empty($name)) {
        echo("<div class='alert'>");
        echo("<p>Попълнете празните полета</p>");
        echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");
        echo("</div>");
    }
    elseif (is_numeric($name)) {
        echo("<div class='alert'>");
        echo('<p>Въвели сте само цифри за Име на продукта</p>');
        echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");
        echo("</div>");

    }
    elseif (empty($price)) {
        echo("<div class='alert'>");
        echo("<p>Попълнете празните полета</p>");
        echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");
        echo("</div>");
    }
    elseif (!is_numeric($price)) {
        echo("<div class='alert'>");
        echo("<p>Въведете цена</p>");
        echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");
        echo("</div>");
    }
    elseif (strpos($price, $comma) !== false) {
        echo("<div class='alert'>");
        echo("<p>Използвайте точка вместо запетая за въведената цена</p>");
        echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");
        echo("</div>");
    }
    elseif (empty($des)) {
        echo("<div class='alert'>");
        echo("<p>Попълнете празните полета</p>");
        echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");
        echo("</div>");
    }
    else{
        $stmt = $conn->prepare("INSERT INTO cvetqtb(name, price, des, categoryid) VALUES(?,?,?,?)");
        $stmt->bind_param("sssi", $name, $price, $des, $category);
        $stmt->execute();
        $last_id = mysqli_insert_id($conn);
        $stmt->close();
        for($i=0; $i<=count($_FILES["file"]["name"]); $i++)
        {
        $filetmp = $_FILES["file"]["tmp_name"][$i];
        $filename = $_FILES["file"]["name"][$i];
        $filetype = $_FILES["file"]["type"][$i];
        $filepath = "uploads/".$filename;
        $stmt = $conn->prepare("INSERT INTO images(productid, img, img_type) VALUES(?,?,?)");
        $stmt->bind_param("iss", $last_id, $filepath, $filetype);
        $stmt->execute();
        $stmt->close();
        move_uploaded_file($filetmp,$filepath);
        }
        $conn->close();
        $URL = "cp.php";
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';

    }
      
}
    
?>