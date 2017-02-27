<?php
include_once '../lib.php';
User::login($_POST['user'], $_POST['password']);
header('Location: ../main/index.php');