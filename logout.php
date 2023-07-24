<?php
session_start();

// Обработка выхода из системы
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>