<?php
session_start();
?>
<!DOCTYPE html>
<html lang="bg">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style/index.css"/>
        <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jquery-eu-cookie-law-popup.css"/>
        <script src="js/jquery-eu-cookie-law-popup.js"></script>  
    </head>
    <body>
        <div class="eupopup eupopup-bottom"></div>
        	<?php
            	include 'inc/nav.php';
        	?>
        	<h1 class="producth1">Продукти</h1>
        	<div class="parent">
    		<?php
        		include 'inc/sidecategory.php';
    		?>
        		<div class="savedlist">
        		<?php
            		include "inc/dbconn.php";
            		$query = "SELECT * FROM cvetqtb ORDER BY id ASC";
            		$result = mysqli_query($conn, $query);
            		if(mysqli_num_rows($result) > 0)
            		{
            			while($row = mysqli_fetch_array($result))
            			{
                            $id = $row["id"];
                            $sqlimg = "SELECT * FROM images WHERE productid=$id";
                            $resultimg = mysqli_query($conn, $sqlimg);
                ?>
                        <div class="showdivs">
                		<?php
                            $rowimg = mysqli_fetch_assoc($resultimg);
                            for($i=0; $i<1; $i++)
                            {
                        ?>  
            				    <img src="<?php echo $rowimg["img"]; ?>">
                		<?php
                            }
                		?>
                				<p class="namep"><?php echo $row["name"]; ?></p>
                		<?php
                    		//This script checks if there is a promotion for the product
                    		if (!empty($row["promoprice"]))
                    		{
                		?>
                				<p class="pricep"><span class="forpromo"><?php echo $row["price"]; ?> лв.</span></p>
                				<p class="promo">Промо: <?php echo $row["promoprice"]; ?> лв.</p>
                		<?php
                    		}
                    		else
                    		{
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
    	include 'inc/footer.php';
    	?>
    </body>
</html>
