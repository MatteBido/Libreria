<?php
session_start();
require_once('database.php');

if (isset($_SESSION['session_id'])) {
    header('Location: dashboard.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="libreria.css">
    <title>Login</title>
    <style>
        form {
            padding: 40px;
            background: #DDD;
            border: 4px solid #AAA;
            width: 360px;
            margin: 30px auto;
            text-align: center;
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
        }
    </style>
</head>

<body>
<div class="custom-padding">
		<nav>
			<ul class="menu-area" style="float: left;">
				<li><a href="Homepage.php">Home</a></li>
				<li><a href="#">Libri</a></li>
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
    <form method="post" action="">
        <h1>Accedi</h1><br>
        <input type="email" id="email" placeholder="email" name="email" required>
        <input type="password" id="password" placeholder="Password" name="password" required>
        <button type="submit" name="login">Accedi</button>
    </form>


    <?php

    if (isset($_POST['login'])) {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $msg = 'Manca email o password %s';
        } else {
            $query = "
                        SELECT email, password
                        FROM utente
                        WHERE email = :email
                    ";

            $check = $pdo->prepare($query);
            $check->bindParam(':email', $email, PDO::PARAM_STR);
            $check->execute();
            $user = $check->fetch(PDO::FETCH_ASSOC);

            if (!$user || password_verify($password, $user['password']) === false) {
                $msg = 'Credenziali utente errate %s';
            } else {
                session_regenerate_id();
                $_SESSION['session_id'] = session_id();
                $_SESSION['session_user'] = $user['email'];

                header('Location:Homepage.php');
                exit;
            }
        }

        printf($msg, '<a href="Login.php">torna indietro</a>');
    }
    ?>
</body>

</html>