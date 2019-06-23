<?php
    if (!isset($_POST["submitpromo"]) && !isset($_SESSION["user"])) {
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
        $promo = $_POST["promo"];
        $check = "SELECT * FROM cvetqtb WHERE id=$id";
        $result = mysqli_query($conn, $check);
        $row = mysqli_fetch_assoc($result);
        if ($promo > $row["price"]) 
        {
            echo("<div class='alert'>");
            echo("<p>Промо цената трябва да е по-ниска от реалната</p>");
            echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");
            echo("</div>");
        }
        elseif ($promo == $row["price"]) 
        {
            $empty = "";
            $stmt = $conn->prepare("UPDATE cvetqtb SET promoprice = ? WHERE id = ?");
            $stmt->bind_param("si", $empty, $id);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            $URL = "cp.php";
            echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
        }
        else
        {
            echo "string";
            $stmt = $conn->prepare("UPDATE cvetqtb SET promoprice = ? WHERE id = ?");
            $stmt->bind_param("si", $promo, $id);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            $URL = "cp.php";
            echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
        }
    }
