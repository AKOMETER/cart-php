
<?php

session_start();

$productIds = array();



if(filter_input(INPUT_POST, 'add_cart')){


if(isset($_SESSION['cart'])){

	$productIds = array_column($_SESSION['cart'], 'id');

	$count = count($_SESSION['cart']);




	if(!in_array(filter_input(INPUT_GET, 'id'), $productIds)){

		$_SESSION['cart'][$count] = array(
       "id" => filter_input(INPUT_GET, 'id'),
		"quantity" => filter_input(INPUT_POST, 'quantity'),
		"price" => filter_input(INPUT_POST, 'price'),
		"name" => filter_input(INPUT_POST, 'name')

	);
		
	} else{


			for ($existing_ids=0; $existing_ids < count($productIds) ; $existing_ids++) { 
			if($productIds[$existing_ids] = filter_input(INPUT_GET, 'id')){
				$_SESSION['cart'][$existing_ids]['quantity'] += filter_input(INPUT_POST, 'quantity');
			}
			}
		
	}





} else{


	$_SESSION['cart'][0] = array(

		"id" => filter_input(INPUT_GET, 'id'),
		"quantity" => filter_input(INPUT_POST, 'quantity'),
		"price" => filter_input(INPUT_POST, 'price'),
		"name" => filter_input(INPUT_POST, 'name')

	);
}


}

if(filter_input(INPUT_GET, "delete")){

	foreach ($_SESSION['cart'] as $key => $value) {

		if($value['id'] == filter_input(INPUT_GET, "delete"))
		unset($_SESSION['cart'][$key]);
	}

	$_SESSION['cart']  = array_values($_SESSION['cart']);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/cart.css">

</head>
<body>


















<?php


$con = mysqli_connect("localhost", "root", "", "cart");
$query = "SELECT * FROM `products`";

$sql = mysqli_query($con, $query);

while($item = mysqli_fetch_assoc($sql)){

?>
	 <div class="col-sm-4 col-md-3">
<form method="post" action="index.php?add&id=<?php echo $item['id']; ?>">

		   <div class="products">
<img src="images/<?php echo $item['image']; ?>" class='img-responsive'>
<h4><?php echo $item['name']; ?></h4>
<h4>$ <?php echo $item['price']; ?></h4>

<input type="number" name="quantity" value='1'>
<input type="hidden" name="price" value="<?php echo $item['price']; ?>">
<input type="hidden" name="name" value="<?php echo $item['name']; ?>">
<input type="submit" name="add_cart" class="btn btn-info">

</div>
</form>
</div>
<?php
}
?>

<table class="table table-condensed">



<?php

	if(!empty($_SESSION['cart'])){
$total = 0;
		foreach($_SESSION['cart'] as $key => $val) {
		
		$total = $total + ($val['quantity'] * $val['price'] );
		?>

<tr>
  <td class="active"><?php echo $val['name']; ?></td>
  <td class="success"><?php echo $val['quantity']; ?></td>
  <td class="warning">$ <?php echo $val['price']; ?></td>
  <td class="danger">Total <?php echo $val['price'] * $val['quantity']; ?></td>
  <td class="info"><a href='index.php?delete=<?php echo $val['id']; ?>' class="btn btn-danger">Delete</a></td>
</tr>

<tr>
 <td class="info"><?php echo $total ?></td>
</tr>


<?php
}}?>


</table>



</body>
</html>