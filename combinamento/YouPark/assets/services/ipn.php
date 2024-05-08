<?php include("config.php"); include("gateway-config.php");
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
	$keyval = explode ('=', $keyval);
	if (count($keyval) == 2)
		$myPost[$keyval[0]] = urldecode($keyval[1]);
}
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
	$get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
	if($get_magic_quotes_exists == true) {
		$value = urlencode(stripslashes($value));
	} else {
		$value = urlencode($value);
	}
	$req .= "&$key=$value";
}
  
$paypalURL = PAYPAL_URL;
$txn_id='ipnfalse'; 
  
$ch = curl_init($paypalURL);
if ($ch == FALSE) {
	return FALSE;
	  
}
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSLVERSION, 6);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: company-name'));
$res = curl_exec($ch);
$tokens = explode("\r\n\r\n", trim($res));
$res = trim(end($tokens));
if (strcmp($res, "VERIFIED") == 0 || strcasecmp($res, "VERIFIED") == 0) {
	$pid	= $_POST['item_number'];
	$txn_id 		= $_POST['txn_id'];
	$payment_gross 	= $_POST['mc_gross'];
	$currency_code 	= $_POST['mc_currency'];
	$payment_status = $_POST['payment_status'];
	$payer_email=$_POST['payer_email'];
    $firstname=$_POST['first_name'];
    $lastname=$_POST['last_name'];   
      $payer_id=$_POST['payer_id']; 
      parse_str($_POST['custom'],$_MYVAR);
 $phone=$_MYVAR['mob'];
    $address=$_MYVAR['add'];  
    $note=$_MYVAR['note']; 
        $payer_address_country=$_POST['address_country']; 
        $date = new DateTime(null, new DateTimezone("Europe/Rome"));
$payment_date=$date->format('Y-m-d H:i:s');
  $sql="SELECT count(*) from payments WHERE txnid=:txnid"; 
       $stmt = $db->prepare($sql);
           $stmt->bindParam(':txnid', $txn_id, PDO::PARAM_STR);
           $stmt->execute();
         $pay_count=$stmt->fetchcolumn();
	if($pay_count > 0){
	   
		exit();
	}else{
	$sql="INSERT INTO payments(firstname,lastname,amount,status,txnid,pid,payer_email,currency,mobile,address,note,payment_date) VALUES(:firstname,:lastname,:amount,:status,:txnid,:pid,:payer_email,:currency,:mobile,:address,:note,:payment_date)"; 
       $stmt = $db->prepare($sql);
           $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
           $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
           $stmt->bindParam(':amount', 	$payment_gross, PDO::PARAM_STR);
           $stmt->bindParam(':status', $payment_status, PDO::PARAM_STR);
           $stmt->bindParam(':txnid', $txn_id, PDO::PARAM_STR);
           $stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
           $stmt->bindParam(':payer_email', $payer_email, PDO::PARAM_STR);
           $stmt->bindParam(':currency', $currency_code, PDO::PARAM_STR);
           $stmt->bindParam(':mobile', $phone, PDO::PARAM_STR);
           $stmt->bindParam(':address', $address, PDO::PARAM_STR);
           $stmt->bindParam(':note', $note, PDO::PARAM_STR);
           $stmt->bindParam(':payment_date', $payment_date, PDO::PARAM_STR);
           $stmt->execute();
	}

}
header('HTTP/1.1 200 OK');