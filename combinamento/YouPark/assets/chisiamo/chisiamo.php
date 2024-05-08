

<?php
include '../check_login_status.php';
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
							<a href="#">Chi siamo</a>
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
                <section>
                    <div class="container1" style="margin-top:20px;">
            <div class="column">
                <h1  style="text-align:center;font-size:28px;">Benvenuti a YouPark - Gestione Parcheggi Genova</h1>
                <p>Siamo orgogliosi di essere la principale azienda dedicata alla gestione dei parcheggi nella città di Genova. Presso YouPark, ci impegniamo a fornire soluzioni di parcheggio convenienti, sicure e efficienti per soddisfare le esigenze dei nostri clienti.</p>
                <br>
                <h2 style="text-align:center;">I Nostri Servizi:</h2>
                <ul>
                <li><strong style="font-size:20px;">Parcheggi Moderni:</strong> Offriamo parcheggi moderni dotati delle ultime tecnologie per garantire la massima comodità e sicurezza ai nostri clienti.</li>
                <li><strong style="font-size:20px;">Tariffe Competitive:</strong> Ci impegniamo a mantenere tariffe competitive per garantire un rapporto qualità-prezzo imbattibile ai nostri clienti.</li>
                <li><strong style="font-size:20px;">Parcheggi Strategici:</strong> I nostri parcheggi sono situati in posizioni strategiche in tutta la città, garantendo un accesso facile e conveniente ai principali luoghi di interesse e alle aree commerciali.</li>
                <li><strong style="font-size:20px;">Sicurezza:</strong> La sicurezza dei veicoli dei nostri clienti è la nostra massima priorità. I nostri parcheggi sono monitorati costantemente e dotati di sistemi di sicurezza avanzati per garantire la tranquillità dei nostri clienti.</li>
                </ul>
            
                <p><strong style="font-size:20px;">Prenota il Tuo Posto Oggi:</strong><br>Prenotare il tuo posto auto non è mai stato così facile! Utilizza il nostro comodo sistema di prenotazione online per assicurarti un posto nel parcheggio desiderato e risparmia tempo e stress.</p>
                <p><strong style="font-size:20px;">Contattaci:</strong><br>Hai domande o hai bisogno di assistenza? Il nostro team di professionisti è qui per aiutarti. Non esitare a contattarci per qualsiasi richiesta o informazione.</p>
                <p style="text-align:center;"><strong style="text-align:center;font-size:20px;">Scegli YouPark per un'esperienza di parcheggio senza problemi a Genova!</strong></p>
            </div>
            </div>  
            <div class="container2" style="margin-top:20px;">
            <p><strong style="font-size:20px; color:white;">Contattaci:</strong></p>
                <form class="lsform" name="contactForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <p><strong style="font-size:20px; color:white;">Contattaci:</strong></p>
                <label for="fname">Nome</label><br>
                <input class="inputls" type="text" id="fname" name="fname" required><br>

                <label for="lname">Cognome</label><br>
                <input class="inputls" type="text" id="lname" name="lname" required><br>

                <label for="email">Email</label><br>
                <input class="inputls" type="email" id="email" name="email"><br>

                <label for="comment">Commento</label><br>
                <textarea class="inputls" id="comment" name="comment" rows="4" required></textarea><br>

                <input class="submitls" type="submit" name="invia" value="Invia">
             </form>
            </div>

			
        </section>
		<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d27114.866644483223!2d8.916311833490012!3d44.410608638622435!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sparcheggi%20genova!5e0!3m2!1sit!2sit!4v1715075028358!5m2!1sit!2sit" width="1920" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		<footer>
            <div class="footer-container">
                <div class="vertical-menu-left">
                    <h3>Contact</h3>
                    <p>Cel: 3519***399</p>
                    <p>pec: YouPark@Pec.com</p>
                    <p>Mail: YouPark@genovayoupark.com</p>
                </div>
            </div>

            <div class="footer-container">
                <div class="footer-icons">
                    <a href="#" class="icon facebook"><img src="../png/facebook.png" alt="Facebook" width="35px" height="35px"></a>
                    <a href="#" class="icon twitter"><img src="../png/twitter.png" alt="Twitter" width="35px" height="35px"></a>
                    <a href="#" class="icon instagram"><img src="../png/instagram.png" alt="Instagram" width="35px" height="35px"></a>
                    <a href="#" class="icon linkedin"><img src="../png/linkedin.png" alt="LinkedIn" width="35px" height="35px"></a>
                </div>
                <p>&copy; 2024 Sito Web. Tutti i diritti riservati.</p>
            </div>

            <div class="footer-container">
                <div class="vertical-menu-left">
                    <h3>Contact</h3>
                    <p>P.IVA: 01225308554</p>
                    <p>Codice SDI SUBM70N</p>
                    <p>Indirizzo: Via Borzoli 46R</p>
                </div>
            </div>
        </footer>
        </div>


    </section>
</main>

</body>

</html>

