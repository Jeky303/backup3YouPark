<?php require_once("config.php");

if (isset($_GET['targaRinnovo']) && isset($_GET['product_id'])) {
	
    $_SESSION['pid'] = $_GET['product_id'];
	$_SESSION['targaRinnovo'] = $_GET['targaRinnovo'];
	$pid=$_GET['product_id'];

} else if(isset($_GET['product_id'])){
	unset($_SESSION['targaRinnovo']);
	$pid=$_GET['product_id'];
}

 $sql="SELECT count(*) from products WHERE pid=:pid"; 
		 $stmt = $db->prepare($sql);
		   $stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
		   $stmt->execute();
		  $count=$stmt->fetchcolumn();
	  if($count==0) 
	  {
	  	 header('location:index.php');
	  	 exit();
	  }
	  ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Checkout - YouPark </title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-sm-12 form-container">
				<h1>Checkout</h1>
<hr>
<?php 
if(isset($_POST['submit_form']))
{
$_SESSION['targa']=$_POST['targa'];
$_SESSION['fname']=$_POST['fname']; 
$_SESSION['lname']=$_POST['lname']; 
$_SESSION['email']=$_POST['email'];
$_SESSION['address']=$_POST['address'];
$_SESSION['note']=$_POST['note']; 
$_SESSION['pid']=$pid;
if($_POST['email']!='')
{
header("location:pay.php");
}
}
?>		
				<div class="row"> 
					<div class="col-8"> 
<form action="" method="POST">
<div class="mb-3">
	<label  class="label">Numero Targa</label>
	<input type="text" class="form-control" name="targa" value="<?php if(isset($_GET['targaRinnovo'])){echo $_GET['targaRinnovo'];}?>" required>
  </div>
  <div class="mb-3">
	<!--<label  class="label">First Name</label>-->
	<input type="text" class="form-control" name="fname" value="<?php if(isset($_SESSION['Nome'])){echo $_SESSION['Nome'];}?>" required>
  </div>
  <div class="mb-3">
	<!--<label class="label">Last Name</label>-->
	<input type="text" class="form-control" name="lname" value="<?php if(isset($_SESSION['Cognome'])){echo $_SESSION['Cognome'];}?>" required>
  </div>

  <div class="mb-3">
	<input type="text" class="form-control" name="email" value="<?php if(isset($_SESSION['mailUtente'])){echo $_SESSION['mailUtente'];}?>" required>
  </div>
  <div class="mb-3">
    <label class="label">Mobile</label>
    <input type="text" class="form-control" name="mobile" value="<?php if(isset($_SESSION['Mobile'])){echo $_SESSION['Mobile'];}?>" required>
  </div>
  <div class="mb-3">
   <input type="text" class="form-control" name="address" value="<?php if(isset($_SESSION['Indirizzo'])){echo $_SESSION['Indirizzo'];}?>" required></textarea>
  </div>
  <div class="mb-3">
    <label class="label">Note</label>
   <textarea name="note" class="form-control"></textarea>
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
	<p class="card-text">'.$row['price'].' EUR</p>
  </div>
</div>';
				?> 
				<br>
				  <button type="submit" class="btn btn-primary" name="submit_form">Place Order</button>
	</form>
				</div>
				</div>
		</div>
	</div>
</div>
</body>
</html>