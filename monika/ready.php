<?php
    if (!isset($_POST["submitready"])) 
    {
        $URL = "index.php";
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
    else
    {
?>
<link rel="stylesheet" type="text/css" href="style/alerts.css"/>
<?php
        include 'inc/dbconn.php';
        $clientid = $_POST["clientid"];
        $prid = $_POST["prid"];
        $quant = $_POST["quant"];
        $itemtotalprice = $_POST["itemtotalprice"];
        $total = $_POST["totalprice"];
        $office = $_POST["Office"];
        if (!isset($office)) 
        {
            echo("<div class='alert'>");
            echo("<p>Пропуснали сте да укажете до къде да се изпрати продуктът</p>");
            echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");      
            echo("</div>");
        }
        elseif (isset($office)) 
        {
            if ($office == 'offices') 
            {
                $ekont = $_POST["ekontoffice"];
                include 'inc/dbconn.php';
                $stmt = $conn->prepare("INSERT INTO query(clientid, productid, wheretocome, ekont, total, quant, itemtotalprice) VALUES(?,?,?,?,?,?,?)");
                $stmt->bind_param("issssss",$clientid, $prid, $office, $ekont, $total, $quant, $itemtotalprice);
                $stmt->execute();
                $stmt->close();
                $conn->close();
                $URL = "index.php";
                echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    
            }
            elseif ($office == 'door') 
            {
                $citytocome = $_POST["Citytocome"];
                $address = $_POST["Address"];
                if (empty($citytocome))
                {
                    echo("<div class='alert'>");
                    echo("<p>Попълнете всички полета</p>");
                    echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");      
                    echo("</div>");
                }
                elseif (is_numeric($citytocome)) 
                {
                    echo("<div class='alert'>");
                    echo("<p>Въвели сте цифри вместо букви в полето за Град</p>");
                    echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");      
                    echo("</div>");
                }
                elseif (empty($address)) 
                {
                    echo("<div class='alert'>");
                    echo("<p>Попълнете всички полета</p>");
                    echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");      
                    echo("</div>");
                }
            }
        }
        else
        {
            $stmt = $conn->prepare("INSERT INTO query(clientid, productid, wheretocome, home, homeadr, total, quant, itemtotalprice) VALUES(?,?,?,?,?,?,?,?)");
            $stmt->bind_param("isssssss",$clientid, $prid, $office, $citytocome, $address, $total, $quant, $itemtotalprice);
            $stmt->execute();
            $stmt->close();
            $URL = "index.php";
            echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
        }
    }
?>
