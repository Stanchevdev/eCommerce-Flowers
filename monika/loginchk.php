<?php
    session_start();
?>
<!DOCTYPE html>
    <html lang="bg">
        <head>
            <link rel="stylesheet" type="text/css" href="style/alerts.css"/>
        </head>
    <?php
        if (!isset($_POST["submitlog"]))
        {
            $URL = "index.php";
            echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
        }
        else
        {
            $userlog = "admin";
            $passlog = "admin";
            $user = $_POST["user"];
            $pass = $_POST["pass"];
            if ($user == $userlog && $pass == $passlog) 
            {
                $_SESSION["user"] = $user;
                $URL = "cp.php";
                echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
            }
            else
            {
                echo("<div class='alert'>");
                echo("<p>Грешно име или парола</p>");
                echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");
                echo("</div>");
            }
        }
    ?>
