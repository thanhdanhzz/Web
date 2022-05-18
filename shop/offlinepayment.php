<?php
	include 'inc/header.php';

?>
<?php
	if(isset($_GET['orderid']) && $_GET['orderid']=="order"){
		$customer_id = Session::get('customer_id');
		$insertOrder = $ct->insertOrder($customer_id);
		$delCat = $ct->del_all_data_cart();
		header("Location:success.php");
	}
?>	
<style type="text/css">
    .box_left{
        width: 50%;
        float: left;
        border: 1px solid #666;
    }
    .box_right{
        width: 48%;
        float: right;
        border: 1px solid #666; 
        padding: 4px;
    }

	.submit_order{
		padding: 10px 70x;
		background: red;
		color: #fff;
		border: none;
		font-size:25px;
		border-radius:5%;
	}
</style>    
 <form action="" method="POST">
 <div class="main">
    <div class="content">
    	<div class="section group">
            <div class="heading">
                <h3>Offine Payment</h3>
            </div>

            <div class="clear"></div>
            <div class="box_left">
            <div class="cartpage">
			    	<h2>Your Cart</h2>
					<?php 
						if(isset($updateCart)) {
							echo $updateCart;
						}

						if(isset($delCart)) {
							echo $delCart;
						}
					?>
						<table class="tblone">
							<tr>
								<th width="5%">ID</th>
								<th width="15%">Product Name</th>
								<th width="15%">Price</th>
								<th width="25%">Quantity</th>
								<th width="20%">Total Price</th>
							</tr>
							<?php
								$get_product_cart = $ct->get_product_cart();
								if($get_product_cart){
									$subtotal = 0;
									$qty = 0;
                                    $i = 0;
									while($result = $get_product_cart->fetch_assoc()){
                                        $i++;
							?>
							<tr>
								<td><?php echo $i ?></td>
								<td><?php echo $result['productName'] ?></td>

								<td><?php echo $result['price'].' '.'VND' ?></td>
								<td>

								<?php echo $result['quantity'] ?>


								</td>
								<td><?php  $total = $result['price']*$result['quantity'];
									echo $total.' '.'VND' ?></td>
								</td>
								
							</tr>
							<?php
									$subtotal += $total;
									$qty = $qty + $result['quantity'];
									}
								}
							?>
						</table>
						<?php
									$check_cart = $ct->check_cart();
									if($check_cart){

									?>		
						<table style="float:right;text-align:left;border: 1px solid #fff; padding: 5px" width="40%">
							<tr>
								<th>Sub Total : </th>
								<td><?php
									
									echo $subtotal;
									Session::set("sum", $subtotal);
									Session::set("qty", $qty);
								?></td>
							</tr>
							<tr>
								<th>VAT : </th>
								<td>10%</td>
							</tr>
							<tr>
								<th>Grand Total :</th>
								<td><?php 
									$vat = $subtotal * 0.1;
									$grandTotal = $subtotal + $vat;
									echo $grandTotal; 
									?> </td>
							</tr>
							   
					   </table>
						<?php
							}else{
								echo "Your Cart is Empty";
							}
						?>			
						
					</div>
            </div>
            <div class="box_right">
			<table class='tblone'>
                <?php
                $id = Session::get('customer_id');
                $get_customers = $cus->show_customer($id);
                if($get_customers){
                    while($result = $get_customers->fetch_assoc()){
                ?>
                <tr>
                    <th>Name</th>
                    <th>:</th>
                    <th><?php echo $result['name'] ?></th>
                </tr>
                <tr>
                    <th>City</th>
                    <th>:</th>
                    <th><?php echo $result['city'] ?></th>
                </tr>
                <tr>
                    <th>Phone</th>
                    <th>:</th>
                    <th><?php echo $result['phone'] ?></th>
                </tr>
                <tr>
                    <th>Country</th>
                    <th>:</th>
                    <th><?php echo $result['country'] ?></th>
                </tr>
                <tr>
                    <th>Zipcode</th>
                    <th>:</th>
                    <th><?php echo $result['zipcode'] ?></th>
                </tr>
                <tr>
                    <th>Email</th>
                    <th>:</th>
                    <th><?php echo $result['email'] ?></th>
                </tr>
                <tr>
                    <th>Address</th>
                    <th>:</th>
                    <th><?php echo $result['address'] ?></th>
                </tr>
                <?php
                    }
                }
                ?>
            </table>
			</div>
 		</div>
		 <center><a href="?orderid=order" class="submit_order" >Order NOW </a> </center><br/>
 	</div>
</div>
</form>
    <?php
        include 'inc/footer.php';
    ?>

