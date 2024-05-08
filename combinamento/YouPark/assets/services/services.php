<?php
include '../check_login_status.php';
require_once("config.php");
include("gateway-config.php");

// Recupera il parametro "servizio" dalla query string dell'URL
$servizio = isset($_GET['servizio']) ? $_GET['servizio'] : null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="icon" href="../icona.png" type="image/x-icon"/>
    <link rel="stylesheet" href="../general.css">
    <link rel="stylesheet" href="style.css">
    <title>Home di YouPark</title>
</head>

<body>
<header>
		<div class="container">
			<input type="checkbox" name="" id="check">

			<div class="logo-container" style="cursor:default">
				<h3 class="logo">You<span>Park</span></h3>
			</div>

			<div class="nav-btn">
				<div class="nav-links">
					<ul>
						<li class="nav-link" style="--i: .6s">
							<a href="../homepage/home.php">Home</a>
						</li>

						<li class="nav-link" style="--i: .85s">
							<a href="#">Servizi<i class="fas fa-caret-down"></i></a>
							<div class="dropdown">
								<ul>
									<li class="dropdown-link">
										<a href="<?php
										if ($isLogged==false) {
											echo '../logpage/login.php';
										}else{echo '../services/services.php?servizio=1';}
									?>">Abbonamento</a>
									</li>
									<li class="dropdown-link">
										<a href="<?php
										if ($isLogged==false) {
											echo '../logpage/login.php';
										}else{echo '../services/services.php?servizio=2';}
									?>">Prenota parcheggio</a>
									</li>
									<li class="dropdown-link">
										<a href="<?php
										if ($isLogged==false) {
											echo '../logpage/login.php';
										}else{echo '../services/services.php?servizio=3';}
									?>">Trova la tua auto</a>
									</li>
									<?php
									if ($isLogged && ($ruolo == "staff")) {
										echo '<li class="dropdown-link">
											<a href="../services/administration.php">Multe e comunicazioni</a>
										</li>';
									}
									if ($isLogged && ($ruolo == "gestore")) {
										echo '<li class="dropdown-link">
											<a href="../services/administration.php">Gestione parcheggi</a>
										</li>';
									}
									if ($isLogged && ($ruolo == "admin")) {
										echo '<li class="dropdown-link">
											<a href="../services/administration.php">Multe e comunicazioni</a>
										</li>';
										echo '<li class="dropdown-link">
											<a href="../services/administration.php">Gestione parcheggi</a>
										</li>';
										echo '<li class="dropdown-link">
											<a href="../services/administration.php">Amministrazione</a>
										</li>';
									}
										
									?>
								   
									<div class="arrow"></div>
								</ul>
							</div>
						</li>


						<li class="nav-link" style="--i: 1.35s">
							<a href="../chisiamo/chisiamo.php">Chi siamo</a>
						</li>
					</ul>
				</div>

				<div class="log-sign" style="--i: 1.8s">
				<a href="<?php if($isLogged) { echo '../logout.php'; }
				else{echo'../logpage/login.php';} ?>" class="btn transparent">
			<?php if($isLogged) { echo "$nome $cognome </br> LOGOUT"; }
				else{echo"Log in";}
			?>
	</a>
					<!--<a href="#" class="btn solid">Sign up</a>-->
				</div>
			</div>

			<div class="hamburger-menu-container">
				<div class="hamburger-menu">
					<div></div>
				</div>
			</div>
		</div>
	</header>
    <main>
        <section>
        <div class="overlay">
    <div class="serviceLayout">
        <div class="top-row">
            <div class="service-item <?php if($servizio==0||$servizio==1){echo ' active';} ?>" onclick="location.href='services.php?servizio=1'">Abbonamenti</div>
            <div class="service-item <?php if($servizio==2){echo ' active';} ?>" onclick="location.href='services.php?servizio=2'">Prenotazione</div>
        </div>
        <div class="bottom-row">
            <div class="service-item <?php if($servizio==3){echo ' active';} ?>" onclick="location.href='services.php?servizio=3'">Trova</div>
            <div class="service-item <?php if($servizio==4){echo ' active';} ?>" onclick="location.href='services.php?servizio=4'">Utente</div>
        </div>
        <?php if($servizio==0||$servizio==1){echo '<div id="abbonamento">
			<div>
				<h1>I tuoi abbonamenti:</h1>';
					include "../connDB.php";
				
				
				$query = "SELECT targa, tipoAbbonamento, dataInizio, dataFine FROM abbonamenti WHERE mail = ?";
				$stmt = $conn->prepare($query);
				
				
				$stmt->bind_param("s", $_SESSION["mailUtente"]);
				$stmt->execute();
				$result = $stmt->get_result();
				
				
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
        
        $dataInizio = strtotime($row["dataInizio"]);
        $dataFine = strtotime($row["dataFine"]);
        $differenzaTempoAbbonamento = $dataFine - $dataInizio;
        $durata= floor($differenzaTempoAbbonamento / (60 * 60 * 24));

		$tempoRimastoAbbonamento = $dataFine - time();
        $giorniRimasti= floor($tempoRimastoAbbonamento / (60 * 60 * 24));

		if($giorniRimasti>0){
			echo '<div class="card">';
			echo '<div class="card-header">' . $row["targa"] . '</div>';
			echo '<div class="card-info">';
			echo '<p><strong>Tipo abbonamento:</strong> ' . $row["tipoAbbonamento"] . '</p>';
			echo '<p><strong>Data inizio:</strong> <span class="center">' . $row["dataInizio"] . '</span></p>';
			echo '<p><strong>Data fine:</strong> <span class="right">' . $row["dataFine"] . '</span></p>';
			echo '<p><strong>Durata abbonamento:</strong> ' . $durata . ' giorni</p>';
			echo '<p><strong>Giorni rimasti:</strong> ' . $giorniRimasti . '</p>';
			echo '</div>';
			echo '</div>';
		}
		else {
			// Query per trovare abbonamenti più recenti per la stessa targa
			$query = "SELECT * FROM abbonamenti WHERE targa = :targa AND dataFine > NOW() ORDER BY dataFine DESC LIMIT 1";
			$stmt = $db->prepare($query);
			$stmt->bindParam(':targa', $row["targa"], PDO::PARAM_STR);
			$stmt->execute();
			$newest_abbonamento = $stmt->fetch();
		
			if ($newest_abbonamento) {
				// Calcola giorni rimasti per l'abbonamento più recente
				$dataFine_newest = strtotime($newest_abbonamento["dataFine"]);
				$differenzaTempo_newest = $dataFine_newest - time(); // Differenza tra la data fine e la data corrente
				$durata_newest = floor($differenzaTempo_newest / (60 * 60 * 24)); // Conversione da secondi a giorni
		
				// Se ci sono giorni rimasti positivi, mostra solo l'abbonamento più recente
				if ($durata_newest > 0) {
					echo '<div class="card">';
					echo '<div class="card-header">' . $newest_abbonamento["targa"] . '</div>';
					echo '<div class="card-info">';
					echo '<p><strong>Tipo abbonamento:</strong> ' . $newest_abbonamento["tipoAbbonamento"] . '</p>';
					echo '<p><strong>Data inizio:</strong> <span class="center">' . $newest_abbonamento["dataInizio"] . '</span></p>';
					echo '<p><strong>Data fine:</strong> <span class="right">' . $newest_abbonamento["dataFine"] . '</span></p>';
					echo '<p><strong>Giorni rimasti:</strong> ' . $durata_newest . '</p>';
					echo '</div>';
					echo '</div>';
				} else {
					// Se non ci sono giorni rimasti positivi, non mostrare nulla
					echo '<div class="card-header warning">'. $row["targa"].' Nessun abbonamento attivo per questa targa. <span class="rinnovaScaduto">Rinnova</span><span class="dimenticaScaduto">Dimentica</span></div>';
				}
			} else {
				// Se non ci sono abbonamenti più recenti, non mostrare nulla
				echo '<div class="card-header warning">'. $row["targa"].' Nessun abbonamento attivo per questa targa.</br><span class="rinnovaScaduto" onclick="rinnovaAbbonamento(\''.$row["targa"].'\')">Rinnova</span><select id="selectAbbonamento">';
				// Esempio di caricamento delle opzioni dal database dei prodotti
				$sql = "SELECT * FROM products";
				$result_products = $conn->query($sql);
				while ($prodotto = $result_products->fetch_assoc()) {
					echo '<option value="' . $prodotto["pid"] . '">' . $prodotto["title"] . '</option>';
				}
				echo '
			</select><span class="dimenticaScaduto" onclick="dimenticaAbbonamento(\''.$row["targa"].'\')">Dimentica</span></div>';
			}


		}
		
        
    }
				} else {
					echo "<p>Non hai abbonamenti attivi.</p>";
				}
				
				
				
				echo '</div>
		<div> <h1>Nuovo abbonamento:</h1>';
				
		 
		$sql="SELECT * from products where type = 'abbonamento' order by pid DESC"; 
$stmt = $db->prepare($sql);
$stmt->execute();
$rows=$stmt->fetchAll();
foreach ($rows as $row) {
echo '<div class="card" style="width: 18rem;">
<img class="card-img-top" src="uploads/'.$row['image'].'" height="100px" width="100px" alt="abbonamento">
<div class="card-body">
<h5 class="card-title">'.$row['title'].'</h5>
<p class="card-text">'.$row['price'].' '.PAYPAL_CURRENCY.'</p>
<a href="checkout.php?product_id='.$row['pid'].'" class="btn-sub">Buy Now</a>
</div>
</div>';

}
   
			echo '</div>
		</div>';}?>
		<?php if($servizio==2){echo '';}?>
		<?php if($servizio==3){echo '';}?>
		<?php if($servizio==4){echo '';}?>
		
		
    </div>
</div>

        </section>
    </main>
<script>
function rinnovaAbbonamento(targa) {

    var prodottoId = document.getElementById("selectAbbonamento").value;

    // Controlla se è stato selezionato un prodotto
    if (prodottoId != "") {
        // Reindirizza alla pagina checkout.php con i parametri GET
        window.location.href = 'checkout.php?targaRinnovo=' + encodeURIComponent(targa) + '&product_id=' + encodeURIComponent(prodottoId);
    }
}

function dimenticaAbbonamento(targa) {

var prodottoId = document.getElementById("selectAbbonamento").value;

// Controlla se è stato selezionato un prodotto
if (prodottoId != "") {
	// Reindirizza alla pagina per cancellare l'abbonamento
	window.location.href = 'forgetSubscription.php?targaDimentica=' + encodeURIComponent(targa);
}

}
</script>

</body>

</html>



