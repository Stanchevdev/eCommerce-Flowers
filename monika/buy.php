<?php
session_start();

if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
			if($values["item_id"] == $_GET["id"])
			{
				unset($_SESSION["shopping_cart"][$keys]);
			}
		}
	}
}

?>
<!DOCTYPE html>
<html lang="bg">
  <head>
    <link rel="stylesheet" type="text/css" href="style/buy.css"/>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
  </head>
  <body>
		<?php
			include 'inc/nav.php';
			include "inc/dbconn.php";
			?>
      <div class="cart">
				<table>
					<tbody>
						<tr>
							<td>Продукт</td>
							<td>Количество</td>
							<td>Цена</td>
						</tr>
						<?php
						if(!empty($_SESSION["shopping_cart"]))
						{
							$total = 0;
							foreach($_SESSION["shopping_cart"] as $keys => $values)
							{
								$total = $total + ($values["item_quantity"] * $values["item_price"]);
								$_SESSION["total"] = $total;
						?>
						<tr>
							<td><?php echo $values["item_name"]; ?></td>
							<td><?php echo $values["item_quantity"]; ?></td>
							<td><?php echo $values["item_price"]; ?></td>
							<td><a href="buy.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="delete"><i class='fas fa-trash'></i></span></a></td>
						</tr>
						<?php
						}
						?>
						<tr>
							<td> </td>
							<td>Общо</td>
							<td><?php echo number_format($_SESSION["total"], 2); ?> лв.</td>
							<td><a href="buynextstepclient.php?action=pay&total=<?php echo number_format($total, 2);?>"><i class='fas fa-hand-holding-usd' id="payment"></i></a></td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
      </div>
			<?php
				include 'inc/footer.php';
			?>
  </body>
</html>
