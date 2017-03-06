<?php
include_once '../lib/lib.php';

switch ($_GET['op']) {
    case "login":
        User::login($_POST['user'], $_POST['password']);
        break;
    case "logout":
        User::logout();
        break;
}

header("Location: ../main/index.php");