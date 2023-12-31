<?php
session_start();

// Проверка авторизации
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Обработка выхода из системы
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

require 'function.php';

// Обработка отправки формы 
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     echo "Form submitted"; // Оператор отладки
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Аутентифицакия
    if (checkPassword($login, $password)) {
        $_SESSION['user'] = $login;
        header("Location: index.php");
        exit();
    } else {
        $error = "Неверный логин или пароль";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Страница входа</title>
</head>
<body>
    <h1>Вход</h1>
    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>
    <form method="POST" action=>
        <label for="login">Логин:</label>
        <input type="text" id="login" name="login" required><br><br>
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" name="submit" value="Войти">
    </form>
    <p>Нет личного кабинета?<a href="registration.php">Зарегистрироваться</a></p>
</body>
</html>


