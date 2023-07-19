<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// // Обработка выхода из системы
// if (isset($_POST['logout'])) {
//     session_destroy();
//     header("Location: login.php");
//     exit();
// }

// Рассчет времени до окончания акции
$loginTime = $_SESSION['login_time'];
$remainingTime = 86400 - (time() - $loginTime);
$hours = floor($remainingTime / 3600);
$minutes = floor(($remainingTime % 3600) / 60);
$seconds = $remainingTime % 60;

// Проверка, установлен ли день рождения пользователя
if (isset($_SESSION['birthday'])) {
    $birthday = $_SESSION['birthday'];
    $daysUntilBirthday = calculateDaysUntilBirthday($birthday);
    $discountMessage = getDiscountMessage($birthday, $daysUntilBirthday);
} else {
    $daysUntilBirthday = null;
    $discountMessage = "";
}

// Обработка отправки формы 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $birthday = $_POST['birthday'];
    $_SESSION['birthday'] = $birthday;
    $daysUntilBirthday = calculateDaysUntilBirthday($birthday);
    $discountMessage = getDiscountMessage($birthday, $daysUntilBirthday);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Главная страница</title>
</head>
<body>
    <h1>Добро пожаловать, <?php echo $_SESSION['user']; ?>!</h1>
    <p>Вы на главной странице.</p>
    <p>Только для Вас дарим скидку 10% на весь ассортимент в течение 24 часов!</p>
    <p>Время до окончания акции: <?php echo "$hours часов, $minutes минут, $seconds секунд"; ?></p>
    <h2>Услуги, предлагаемые нашим SPA-салоном:</h2>
    <ul>
        <li>Массаж</li>
        <li>Терапия для лица</li>
        <li>Обертывания</li>
        <li>Маникюр и педикюр</li>
        <li>Уход за волосами</li>
    </ul>
    <?php if ($daysUntilBirthday !== null) { ?>
        <p><?php echo $discountMessage; ?></p>
    <?php } ?>
    <form method="POST" action="">
        <label for="birthday">Внесите дату своего рождения:</label>
        <input type="date" id="birthday" name="birthday" required><br><br>
        <input type="submit" value="Submit">
    </form>
    <h2>Фотографии нашего SPA-салона:</h2>
    <img src="spa_photo1.jpg" alt="Фото SPA-салона 1" width="400" height="300">
    <img src="spa_photo2.jpg" alt="Фото SPA-салона 2" width="400" height="300">

    <form method="POST" action="login.php">
        <input type="submit" name="Выход" value="Logout">
    </form>
</body>
</html>
