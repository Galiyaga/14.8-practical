<?php
$users = array(
    array(
        'login' => 'user1',
        'password' => 'password1'
    ),
    array(
        'login' => 'user2',
        'password' => 'password2'
    ),
    array(
        'login' => 'user3',
        'password' => 'password3'
    ),
    array(
        'login' => 'user4',
        'password' => 'password4'
    ),
    array(
        'login' => 'user5',
        'password' => 'password5'
    ),
    array(
        'login' => 'user6',
        'password' => 'password6'
    )
);

function getUsersList() {
    global $users;
    $userList = array();
    foreach ($users as $user) {
        $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
        $userList[] = array(
            'login' => $user['login'],
            'passwordHash' => $hashedPassword
        );
    }
    return $userList;
}

function existsUser($login) {
    global $users;
    foreach ($users as $user) {
        if ($user['login'] === $login) {
            return true;
        }
    }
    return false;
}

function checkPassword($login, $password) {
    global $users;
    foreach ($users as $user) {
        if ($user['login'] === $login) {
            return password_verify($password, $user['password']);
        }
    }
    return false;
}

function getCurrentUser() {
    session_start();
    if(isset($_SESSION['user'])) {
        return $_SESSION['user'];
    }
    return null;
}

function addUser($login, $password) {
    global $users;
    $users[] = array(
        'login' => $login,
        'password' => $password
    );
}

function calculateDaysUntilBirthday($birthday) {
    $today = new DateTime();
    $birthday = new DateTime($birthday);
    $birthday->setDate($today->format('Y'), $birthday->format('m'), $birthday->format('d'));
    
    if ($today > $birthday) {
        $birthday->modify('+1 year');
    }
    
    $interval = $today->diff($birthday);
    return $interval->days;
}

function getDiscountMessage($birthday, $daysUntilBirthday) {
    $today = new DateTime();
    $birthday = new DateTime($birthday);
    $birthday->setDate($today->format('Y'), $birthday->format('m'), $birthday->format('d'));
    
    if ($today->format('md') === $birthday->format('md')) {
        return "С днем ​​рождения! Получите скидку 5% на все услуги салона!";
    } else {
        return "До дня рождения осталось всего " . $daysUntilBirthday . " дней!";
    }
}

// $userList = getUsersList();
// print_r($userList);

// $loginToCheck = 'user3';
// $passwordToCheck = 'password3';
// if (checkPassword($loginToCheck, $passwordToCheck)) {
//     $_SESSION['user'] = $loginToCheck;
//     echo "Logged in as user: " . getCurrentUser();
// } else {
//     echo "User with login '$loginToCheck' does not exist or the password is incorrect.";
// }

?>