<?php 
require_once("config.php");
require_once("gateway-config.php");
$pid = $_SESSION['pid'];



$firstname=$_SESSION['fname']; 
$lastname=$_SESSION['lname'];
$email=$_SESSION['email'];
$address=$_SESSION['address'];

// Controlla se $_SESSION['targaRinnovo'] è impostato e se sì, cancella l'abbonamento precedente
if(isset($_SESSION['targaRinnovo'])) {
    $targa=$_SESSION['targaRinnovo'];
    $query_delete = "DELETE FROM abbonamenti WHERE targa = :targa";
    $stmt_delete = $db->prepare($query_delete);
    $stmt_delete->bindParam(':targa', $_SESSION['targaRinnovo'], PDO::PARAM_STR);
    $stmt_delete->execute();
    unset($_SESSION['targaRinnovo']);
} else{
    $targa=$_SESSION['targa'];
}




// Determina l'intervallo di tempo in base al valore di $pid
// Query per aggiungere un nuovo abbonamento
if ($pid == 1) {
    // Se $pid è 1, l'intervallo è di un mese
    $sql = "INSERT INTO abbonamenti (targa, mail, dataInizio, dataFine) VALUES (:targa, :email, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH))";
} elseif ($pid == 2) {
    // Se $pid è 2, l'intervallo è di un anno
    $sql = "INSERT INTO abbonamenti (targa, mail, dataInizio, dataFine) VALUES (:targa, :email, NOW(), DATE_ADD(NOW(), INTERVAL 1 YEAR))";
} else {
    // Intervallo di default, ad esempio un anno
    $sql = "INSERT INTO abbonamenti (targa, mail, dataInizio, dataFine) VALUES (:targa, :email, NOW(), DATE_ADD(NOW(), INTERVAL 1 YEAR))";
}

// Preparazione dello statement
$stmt = $db->prepare($sql);

// Associazione dei parametri
$stmt->bindParam(':targa', $_SESSION['targa'], PDO::PARAM_STR);
$stmt->bindParam(':email', $_SESSION['email'], PDO::PARAM_STR);

// Esecuzione della query
$stmt->execute();

// Recupero dell'ultimo ID inserito nella tabella abbonamenti
$abbonamento_id = $db->lastInsertId();

// Altri dettagli necessari per l'abbonamento
$dataInizio = date('Y-m-d H:i:s');
$dataFine = date('Y-m-d H:i:s', strtotime('+1 year'));
      ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Status - YouPark</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
    <h1>PAGAMENTO AVVENUTO CON SUCCESSO!</h1>
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
</div>
</body>
</html>