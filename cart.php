<?php

//session_start();
$product_ids = array();

//session_destroy();

if(filter_input(INPUT_POST, 'add_to_cart')){

	
if(isset($_SESSION['shopping_cart'])){


$product_ids =  array_column($_SESSION['shopping_cart'],'id');

$count = count($_SESSION['shopping_cart']);



if(!in_array(filter_input(INPUT_GET, 'id'), $product_ids)){
  
  $_SESSION['shopping_cart'][$count] = array(


        "id" => filter_input(INPUT_GET, 'id'),
		"name" => filter_input(INPUT_POST, 'name'),
		"price" => filter_input(INPUT_POST, 'price'),
		"quantity" => filter_input(INPUT_POST, 'quantity')

  );

}  else{
	for ($i=0; $i < count($product_ids) ; $i++) { 
		if($product_ids[$i] == filter_input(INPUT_GET, 'id')){
			$_SESSION['shopping_cart'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');
		}
	}
}



} else{

	$_SESSION['shopping_cart'][0] = array(

		"id" => filter_input(INPUT_GET, 'id'),
		"name" => filter_input(INPUT_POST, 'name'),
		"price" => filter_input(INPUT_POST, 'price'),
		"quantity" => filter_input(INPUT_POST, 'quantity')


	);
}


}

//pre_r($_SESSION);

function pre_r($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}



if(filter_input(INPUT_GET, 'delete')){
    //loop through all products in the shopping cart until it matches with GET id variable
    foreach($_SESSION['shopping_cart'] as $key => $product){
        if ($product['id'] == filter_input(INPUT_GET, 'delete')){
            //remove product from the shopping cart when it matches with the GET id
            unset($_SESSION['shopping_cart'][$key]);
        }
    }

    $_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
}


?>




<!DOCTYPE html>
<html>
<head>
	<title></title>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/cart.css">

	<script type="text/javascript" scr="jquery.min.js"></script>

</head>
<body>

<div class="container">


<?php

$connect = mysqli_connect("localhost", "root", "", "cart");


$query = "SELECT * FROM products ORDER by id ASC";
$result  = mysqli_query($connect, $query);

if($result){

	if(mysqli_num_rows($result)>0){
		while ($product = mysqli_fetch_assoc($result)) {
		 ?>

		 <div class="col-sm-4 col-md-3">

		 	<form method="post" action="cart.php?action=add&id=<?php echo $product['id'];?> ">

		 		   <div class="products">
                            <img src="images/<?php echo $product['image']; ?>" class="img-responsive" />
                            <h4 class="text-info"><?php echo $product['name']; ?></h4>
                            <h4>$ <?php echo $product['price']; ?></h4>
                            <input type="number" name="quantity" class="form-control" value="1" />
                            <input type="hidden" name="name" value="<?php echo $product['name']; ?>" />
                            <input type="hidden" name="price" value="<?php echo $product['price']; ?>" />
                            <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-info"
                                   value="Add to Cart" />
                        </div>
		 		

		 	</form>
		 </div>

		 <?php
		}
	}

}
?>

</div>



<div class="container">
	
	<div class="row">
		<div class="row-md-2"></div>
		<div class="row-md-8">
		<table class="table table-bordered">

 <tr>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Price</th>
         <th>Total</th>
         <th>Action</th>
        
      </tr>


<?php 

if(!empty($_SESSION['shopping_cart'])){
$total = 0;
foreach ($_SESSION['shopping_cart'] as $key => $product) {
	# code...





	?>
			<tr>
				
				<th><?php echo $product['name']; ?></th>
				<th><?php echo $product['quantity']; ?></th>
				<th>$ <?php echo $product['price']; ?></th>
				<th>$ <?php echo $product['quantity'] * $product['price']; ?></th>
				<th> <a class="btn btn-danger" href="cart.php?delete=<?php echo $product['id']; ?>">Delete</a></th>
			</tr> 

			

<?php

$total = $total + ($product['quantity'] * $product['price']);

 } ?>

<tr><td align="right">Grand Total </td>
<td align="right"> $ <?php echo $total;?></td>
 
</tr>
<?php } ?>

  





     



	


		

		
		</table>
		</div>
		<div class="row-md-2"></div>
	</div>

</div>



</body>
</html>


