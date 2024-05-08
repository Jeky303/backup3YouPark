<?php require_once("config.php");
      if(!isset($_SESSION['email'])) 
      {
      	 header('location:index.php');
      	 exit();
      }
      else 
      {
        $pid=$_SESSION['pid'];
      }
      include("gateway-config.php");

      ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Payment - YouPark</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-sm-12 form-container">
				<h1>Payment</h1>
<hr>
<?php 
$firstname=$_SESSION['fname']; 
$lastname=$_SESSION['lname'];
 $email=$_SESSION['email'];
$mobile=$_SESSION['mobile'];
$address=$_SESSION['address'];
$note=$_SESSION['note'];
$sql="SELECT * from products WHERE pid=:pid"; 
         $stmt = $db->prepare($sql);
           $stmt->bindParam(':pid',$pid,PDO::PARAM_INT);
            $stmt->execute();
           $row=$stmt->fetch();
           $price=$row['price'];
           $title=$row['title'];  

 ?>
				<div class="row"> 
					<div class="col-8"> 
            <h4>(Payer Details)</h4>
  <div class="mb-3">
    <label  class="label">First Name :- </label>
     <?php echo $firstname; ?>
  </div>
  <div class="mb-3">
    <label class="label">Last Name:- </label>
      <?php echo $lastname; ?>
  </div>

  <div class="mb-3">
    <label class="label">Email:- </label>
      <?php echo $email; ?>
  </div>
  <div class="mb-3">
    <label class="label">Mobile:- </label>
      <?php echo $mobile; ?>
  </div>
  <div class="mb-3">
    <label class="label">Address:- </label>
    <?php echo $address; ?>
  </div>
  <div class="mb-3">
    <label class="label">Note:- </label>
    <?php echo $note; ?>
  </div>
					</div>
					<div class="col-4 text-center">
					<?php 
					 $sql="SELECT * from products WHERE pid=:pid"; 
         $stmt = $db->prepare($sql);
           $stmt->bindParam(':pid',$pid,PDO::PARAM_INT);
            $stmt->execute();
           $row=$stmt->fetch();
       echo '<div class="card" style="width: 18rem;">
  <img class="card-img-top" src="uploads/'.$row['image'].'" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title">'.$row['title'].'</h5>
    <p class="card-text">'.$row['price'].' '.PAYPAL_CURRENCY.'</p>
  </div>
</div>';
				?> 
        <form action="<?php echo PAYPAL_URL; ?>" method="post" class="form-container price">
          <!-- Identify your business so that you can collect the payments. -->
          <input type="hidden" name="business" value="<?php echo PAYPAL_ID; ?>">
          <!-- Specify a Buy Now button. -->
          <input type="hidden" name="cmd" value="_xclick">
          <!-- Specify details about the item that buyers will purchase. -->
          <input type="hidden" name="item_name" value="<?php echo $title;?> ">
          <input type="hidden" name="item_number" value="<?php echo $pid;?> ">
          <input type="hidden" name="amount" value="<?php echo $price; ?>">
          <input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY; ?>">
          <!-- Specify URLs -->
          <input type="hidden" name="return" value="<?php echo PAYPAL_RETURN_URL; ?>">
          <input type="hidden" name="cancel_return" value="<?php echo PAYPAL_CANCEL_URL; ?>">
          <input type="hidden" name="notify_url" value="<?php echo PAYPAL_NOTIFY_URL; ?>">
          <td><input type="hidden" class="form-control" value="<?php echo $firstname;?>" readonly/></td>
       <td><input type="hidden" class="form-control" value="<?php echo $lastname;?>" readonly/></td>
            <td><input type="hidden" class="form-control" value="<?php echo $email;?>" readonly/></td>
             <input type="hidden" name="custom" value="mob=<?php echo $mobile;?>&add=<?php echo $address;?>&note=<?php echo $note;?>"/>
        <center><input type="submit" name="submit" class="paypal_button" value="Pay Now" ></center>
      </form>
				</div>
        
				</div>
		</div>
	</div>
</div>
</body>
</html>