<?php
    if (!isset($_POST["submitforcontact"])) 
    {
        $URL = "index.php";
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
    else{
    ?>
    <link rel="stylesheet" type="text/css" href="style/alerts.css"/>
    <?php
        include 'inc/dbconn.php';
        $name = $_POST["Name"];
        $fam = $_POST["Fam"];
        $email = $_POST["Email"];
        $msg = $_POST["Msg"];
        if (empty($name)) 
        {
            echo("<div class='alert'>");
            echo("<p>Попълнете всички полета</p>");
            echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");
            echo("</div>");
        }
        elseif (is_numeric($name)) 
        {
            echo("<div class='alert'>");
            echo("<p>Въвели сте цифри вместо букви в полето за Град</p>");
            echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");
            echo("</div>");
        }
        elseif (empty($fam)) 
        {
            echo("<div class='alert'>");
            echo("<p>Попълнете всички полета</p>");
            echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");
            echo("</div>");
        }
        elseif (is_numeric($fam)) 
        {
            echo("<div class='alert'>");
            echo("<p>Въвели сте цифри вместо букви в полето за Град</p>");
            echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");
            echo("</div>");
        }
        elseif (empty($email)) 
        {
            echo("<div class='alert'>");
            echo("<p>Попълнете всички полета</p>");
            echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");
            echo("</div>");
        }
        elseif (empty($msg)) 
        {
            echo("<div class='alert'>");
            echo("<p>Попълнете всички полета</p>");
            echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");
            echo("</div>");
        }
        else
        {
            $code = mt_rand(1, 9999);
            $hashed = sha1($code);
            $message = '
              <html>
              <head>
                  <title>Заявка за съобщение</title>
              </head>
              <body>
                  <p>Здравейте, направили сте заявка за изпращане на съобщение до FlowerMoni.com. Ако сте били Вие моля посетете линка <a href="https://flowermoni.com/readymsg.php?code='.$hashed.'&email='.$email.'&name='.$name.'&fam='.$fam.'&msg='.$msg.'">Кликнете тук</a>, за потвърждение на съобщението.</p>
              </body>
              </html>
            ';
            $subject = "Активация на съобщение до Flowermoni.com";
            $headers .= "MIME-Version: 1.0" . "\r\n"; 
            $headers .= "Content-type: text/html; charset=utf-8" . "\r\n"; 
            $headers .= "From: 	flowermo@odin.superhosting.bg" . "\r\n"; 
            $headers .= "To: $email " . "\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();  
            mb_internal_encoding('UTF-8');
            $encoded_subject = mb_encode_mimeheader($subject, 'UTF-8', 'B', "\r\n", strlen('Subject: '));
            mail($email, $encoded_subject, $message, $headers);
            
            echo("<div class='alert'>");
            echo("<p>До посоченият от Вас имейл е изпратено съобщение. Влезте и потвърдете съобщението си от посоченият линк</p>");
            echo("<p><a href='javascript:history.back()'>&#10004;</a></p>");
            echo("</div>");
        }
    }
?>
