<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "libreria");

if (isset($_GET['add_libro'])) {
	$ISBN = intval($_GET['add_libro']);		// Contiene il codice del libro.
	$sql_select_libro = "SELECT numero_letture FROM libro
					   			WHERE ISBN = {$ISBN}";
	$query_select_libro = mysqli_query($connection, $sql_select_libro);
	$num_letture = mysqli_fetch_array($query_select_libro);

	if (isset($ISBN) && $num_letture[0] >= 0) {	//aumenta di uno la quantità.
		$sql_update = "UPDATE libro
						   SET numero_letture = numero_letture + 1
						   WHERE ISBN = {$ISBN}";
		$query_update = mysqli_query($connection, $sql_update);
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="libreria.css">
	<title>Hastega</title>
</head>

<body>


	<div class="custom-padding">
		<nav>

			<ul class="menu-area" style="float: left;">
				<li><a href="Homepage.php">Home</a></li>
				<li><a href="Prodotti.php">Libri</a></li>
			</ul>
			<ul class="menu-area">
				<?php if (isset($_SESSION['session_id'])) { ?>
					<li>
						<div class="dropdown">
							<button class="dropbtn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
									<path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
								</svg>
								<i class="fa fa-caret-down"></i>
							</button>
							<div class="dropdown-content">
								<p><?php echo $_SESSION['session_user']; ?> </p>
								<a href="logout.php">Esci</a>
								<a href="Cancellazione.php">Elimina profilo</a>
							</div>
						</div>
					</li>
				<?php } else { ?>
					<li><a href="Login.php">Accedi</a></li>
					<li><a href="Registrazione.php">Registrati</a></li>
				<?php } ?>
			</ul>
		</nav>
	</div>

	<div class="latest-products">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section-heading">
						<h2>Elenco di tutti libri</h2>
					</div>
				</div>


				<?php
				$sql = "SELECT ISBN FROM libro";
				$result = mysqli_query($connection, $sql);
				while ($row = mysqli_fetch_array($result)) {
					$sql1 = "
								SELECT titolo,autore,trama,data_aggiunta,numero_letture
								FROM libro
								WHERE ISBN='$row[0]'
							";
					$result1 = mysqli_query($connection, $sql1);
					$record = mysqli_fetch_assoc($result1);
				?>
					<div class='col-md-4'>
						<div class='product-item'>
							
							<form method='get'>
								<div class='down-content'>
									<a href="prodotti.php"><h4> <?php echo $record['titolo']; ?></h4></a>
									<p><?php echo $record['autore']; ?> </p>
									<p> <?php echo $record['trama']; ?></p>
									<p> <?php echo $record['data_aggiunta']; ?></p>
									<p> <?php echo $record['numero_letture']; ?></p>
									<input type="hidden" name="add_libro" value=<?php echo $row['ISBN']; ?>>
									<button type="submit">Leggi libro</button>
								</div>
							</form>
						</div>
					</div>

				<?php
				}
				?>
			</div>
		</div>
	</div>
</body>
</html>