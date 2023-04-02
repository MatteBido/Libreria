<?php
session_start();

if (isset($_SESSION['session_id'])) {
    unset($_SESSION['session_id']);
    session_regenerate_id();
}
if (isset($_SESSION['session_user'])) {
    unset($_SESSION['session_user']);
}
header('Location: Homepage.php');
exit;
