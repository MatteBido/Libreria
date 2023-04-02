<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="libreria.css">
    <title>Registrazione</title>
    <style>
        .registrazione {
            text-align: center;
            padding: 20px;
            background: #DDD;
            border: 4px solid #AAA;
            width: 360px;
            margin: 30px auto;
        }

        .scelte {
            text-align: center;
            width: 380px;
            margin: 30px auto;
            margin-bottom: 30px;
        }

        input {
            font: 14px 'Open Sans', sans-serif;
            border: 2px solid #ccc;
            padding: 6px;
            display: block;
            margin-bottom: 10px;
            width: 96%;
            text-align: center;
        }

        button {
            font: 14px 'Open Sans', sans-serif;
            background-color: #4285f4;
            color: white;
            padding: 6px;
            cursor: pointer;
            border: none;
            margin-top: 10px;
            text-transform: uppercase;
            margin-right: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
<div class="custom-padding">
		<nav>
			<ul class="menu-area" style="float: left;">
				<li><a href="#">About</a></li>
				<li><a href="#">Prodotti</a></li>
			</ul>
			<ul class="menu-area">
				<?php if (isset($_SESSION['session_id'])) { ?>
					<li>
						<div class="dropdown">
							<button class="dropbtn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
													<path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
													</svg>
								<i class="fa fa-caret-down"></i>
							</button>
							<div class="dropdown-content">
								<a href="logout.php">Esci</a>
								<a href="Elimina profilo">Elimina profilo</a>
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

    <form class="registrazione" method="post" action="">
        Nome: <input type="text" id="nome" name="nome" placeholder="Il tuo nome">
        Email: <input type="email" id="email" name="email" placeholder="La tua email" maxlength="50" required>
        <!-- </form> -->

        <!-- <form class="registrazione" method="post" action="Registrati.php"> -->
        Password: <input type="password" id="password" name="password" placeholder="Password" required>
        Ripeti Password: <input type="password" name="password2" placeholder="Conferma Password">
        <!-- </form> -->

        <!-- <form class="scelte" method="post" action="Registrati.php"> -->
        <button type="reset" name="reset" onClick="window.location.reload();" style="background-color: red; margin-right:10px;">Ripristina</button>
        <button type="submit" name="register" style="background-color: #4285f4;">Registrati</button>
        <p><a href="Login.php">Se hai già un account, accedi qui</a></p>
    </form>
    <br/>
    <?php
    require_once('database.php');

    if (isset($_POST['register'])) {
        $email = $_POST['email'] ?? '';
        $nome = $_POST['nome'] ?? '';
        $password = $_POST['password'] ?? '';
        $confermapassword = $_POST['password2'] ?? '';
        $pwdLenght = mb_strlen($password);

        if (empty($email) || empty($password)) {
            echo "<span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span>
                            Compila tutti i campi obbligatori";
        } elseif ($pwdLenght < 5 || $pwdLenght > 20) {
            echo "<span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span>
                            Lunghezza minima password 5 caratteri.
                            Lunghezza massima 20 caratteri";
        } elseif ($confermapassword != $password) {
            echo "<span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span>
                            Le password non coincidono.";
        } else {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            $query = "
                        SELECT email
                        FROM utente
                        WHERE email = :email
                    ";

            $check = $pdo->prepare($query);
            $check->bindParam(':email', $email);
            $check->execute();

            $user = $check->fetchAll(PDO::FETCH_ASSOC);

            if (count($user) > 0) {
                echo "<span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span>
                        Email già in uso.";
            } else {
                $query = "
                            INSERT INTO utente(email,nome,password)
                            VALUES (:email,:nome,:password)
                        ";

                $check = $pdo->prepare($query);
                $check->bindParam(':email', $email);
                $check->bindParam(':nome', $nome);
                $check->bindParam(':password', $password_hash);
                $check->execute();

                if ($check->rowCount() > 0) {
                    echo "<span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span>
                            Registrazione eseguita con successo.";
                    header("location:Login.php");
                } else {
                    echo "<span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span>
                            Problemi con la registrazione.";
                }
            }
        }
    }
    ?>
</body>
</html>