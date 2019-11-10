
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


<tr><td align="right">Grand Total </td>
<td align="right"></td>
 
</tr>
<?php } ?>

  





     



	


		

		
		</table>
		</div>
		<div class="row-md-2"></div>
	</div>

</div>



</body>
</html>


