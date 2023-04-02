<?php
session_start();
require_once('database.php');

if (isset($_SESSION['session_id'])) {
    $sql_delete = "DELETE FROM Cliente WHERE email='$_SESSION[session_user]'";
    $result_delete = $pdo->prepare($sql_delete);
    $result_delete->execute();
    unset($_SESSION['session_id']);
    session_regenerate_id();
}
if (isset($_SESSION['session_user'])) {
    unset($_SESSION['session_user']);
}
header('Location: Homepage.php');
exit;
