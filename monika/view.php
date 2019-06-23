<?php
session_start();
if(isset($_POST["add_to_cart"]))
{
	if(isset($_SESSION["shopping_cart"]))
	{
		$item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
		if(!in_array($_GET["id"], $item_array_id))
		{
			$count = count($_SESSION["shopping_cart"]);
			$item_array = array(
				'item_id'			=>	$_GET["id"],
				'item_img'   => $_POST["hidden_img"],
				'item_name'			=>	$_POST["hidden_name"],
				'item_price'		=>	$_POST["hidden_price"],
				'item_quantity'		=>	$_POST["quantity"]
			);
			$_SESSION["shopping_cart"][$count] = $item_array;
		}
		else
		{
			echo '<script>alert("Item Already Added")</script>';
		}
	}
	else
	{
		$item_array = array(
			'item_id'			=>	$_GET["id"],
			'item_img'   => $_POST["hidden_img"],
			'item_name'			=>	$_POST["hidden_name"],
			'item_price'		=>	$_POST["hidden_price"],
			'item_quantity'		=>	$_POST["quantity"]
		);
		$_SESSION["shopping_cart"][0] = $item_array;
	}
}

?>
<!DOCTYPE html>
<html lang="bg">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style/view.css"/>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
		<script type="text/javascript">
				function add() {
					var counter = document.getElementById("counter");
				 	counter.value++;
				};
				function decrease() {
					var counter = document.getElementById("counter");
					counter.value--;
					if (counter.value < 1) {
						counter.value = 1;
					}
				};
				function add10() {
					var counter = document.getElementById("counter");
					var added = counter.value++;
					counter.value = added + 10;
				};
				function decrease10() {
					var counter = document.getElementById("counter");
					counter.value = counter.value - 10;
					if (counter.value < 1) {
						counter.value = 1;
					}
				};

				function summed() {
					var price = document.getElementById("price");
					var counter = document.getElementById("counter");
					var val = counter.value;
					var val2 = price.value;
					var res = val * val2;
					var restofix = res.toFixed(2);
					document.getElementById("summedp").innerHTML = restofix;
				}
		</script>
	</head>
  <body>
		<?php
		include 'inc/nav.php';
    $id = $_GET["id"];
		?>
			<div class="savedlist">
	    <?php
	    include "inc/dbconn.php";
	    $query = "SELECT * FROM cvetqtb WHERE id=$id";
	    $result = mysqli_query($conn, $query);
	    if(mysqli_num_rows($result) > 0)
	    {
	      while($row = mysqli_fetch_assoc($result))
	      {
			$categoryid = $row["categoryid"];
			$querycat = "SELECT * FROM category WHERE id=$categoryid";
			$resultcat = mysqli_query($conn, $querycat);
			$rowcat = mysqli_fetch_assoc($resultcat);

			$querynews = "SELECT * FROM news WHERE flowerid=$id";
			/*This query is for displaying news.
			I use them to tell the users if there are limited quantities*/
			$resultnews = mysqli_query($conn, $querynews);
			$rownews = mysqli_fetch_assoc($resultnews);


	    ?>
			<div class="formandimg">
			    <div class="galerydiv">
		<?php
		    $id = $row["id"];
    	    $queryimg = "SELECT * FROM images WHERE productid=$id";
    	    $resultimg = mysqli_query($conn, $queryimg);
	      while($rowimg = mysqli_fetch_assoc($resultimg))
	      {
	   ?>
                    <img src="<?php echo $rowimg["img"]; ?>" class="mySlides">
        <?php
	      }
	      ?>
	           <div style="text-align:center">
	      <?php
	      for($i=0; $i<mysqli_num_rows($resultimg);$i++)
	      {
        ?>            
                <span class="dot" onclick="currentSlide(<?php echo $i+1;?>)"></span> 

            <?php
	      }
            ?>     
                </div>
	            </div>   
	        <!--Javascript code-->  
	        <!--Javascript code-->    

            <script>
                var slideIndex = 1;
                showSlides(slideIndex);
                
                function currentSlide(n) {
                showSlides(slideIndex = n);
                }
                
                function showSlides(n) {
                var i;
                var slides = document.getElementsByClassName("mySlides");
                var dots = document.getElementsByClassName("dot");
                if (n > slides.length) {slideIndex = 1}    
                if (n < 1) {slideIndex = slides.length}
                for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";  
                }
                for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
                }
                slides[slideIndex-1].style.display = "block";  
                dots[slideIndex-1].className += " active";
                }
            </script>   

	        <!--Javascript code-->    
	        <!--Javascript code-->    


      <form method="POST" class="showdivs" action="view.php?action=add&id=<?php echo $row["id"]; ?>">
				<!--I will use hidden inputs to deliver the data on the next page-->
				<input type="hidden" name="hidden_img" value="<?php echo $row["img"]; ?>" />
        <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />
        <p class="namep"><?php echo $row["name"]; ?> <span class="cat">(<?php echo $rowcat["category"]; ?>)</span></p>

        <?php
				//Here we will check if there is a promotion and then we will sum it.

        if (!empty($row["promoprice"])) {
        ?>
          <input type="hidden" name="hidden_price" id="price" value="<?php echo $row["promoprice"]; ?>" />
          <p class="pricep"><span class="forpromo"><?php echo $row["price"]; ?> лв.</span><br/><span class="promo">Промоция: <?php echo $row["promoprice"]; ?> лв.</span></p>
					<p class="summedp">Общо: <span id="summedp"><?php echo $row["promoprice"];?></span> лв.</p>

        <?php
        }
        else{
        ?>
          <input type="hidden" name="hidden_price" id="price" value="<?php echo $row["price"]; ?>" />
          <p class="pricep"><span><?php echo $row["price"]; ?></span> лв.</p>
					<p class="summedp">Общо: <span id="summedp"><?php echo $row["price"];?></span> лв.</p>
        <?php
        }
        ?>
				<!--These spans are the buttons for calculating the final price for the product-->
				<span onclick="decrease10(); summed()" id="dec10" class="counters"><i class='fas fa-minus'></i>10</span>
        <span onclick="decrease(); summed()" id="dec" class="counters"><i class='fas fa-minus'></i></span>
				<input type="text" class="count" name="quantity" value="1" size="2" id="counter" readonly="readonly"/><span onclick="add(); summed()" id="add" class="counters"><i class='fas fa-plus'></i></span>
				<span onclick="add10(); summed()" id="add10" class="counters"><i class='fas fa-plus'></i>10</span>
        <div class="showbtns">
        <button type="submit" name="add_to_cart">Добави в количката<br/><i class='fas fa-shopping-cart'></i></button>
        </div>
      </form>
		</div>
			<div class="news">
				<p><?php echo $rownews["news"];?></p>
			</div>
      <div class="des">
        <h1>Описание на продукта</h1>
        <p><?php echo $row["des"];?></p>
      </div>
    </div>
    <?php
      }
    }
		include 'inc/footer.php';
		?>
</body>
</html>
