<?php
$id = $_GET["id"];
if (!isset($id) && empty($_SESSION["user"])) 
{
    $URL="cp.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
else
{
    include 'inc/dbconn.php';
    $sql = "DELETE FROM cvetqtb WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $sqlimg = "DELETE FROM images WHERE productid=$id";
    $resultimg = mysqli_query($conn, $sqlimg);
    $URL="cp.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
?>
