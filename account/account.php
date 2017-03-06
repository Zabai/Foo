<?php
include_once '../lib/lib.php';
if (!User::getLoggedUser()) header("Location: ../main/index.php");

switch (User::getLoggedUser()['tipo']) {
    case 1:
        header("Location: ../admin/admin.php");
        break;
    case 2:
        header("Location: ../customer/customer.php");
        break;
    case 3:
        header("Location: ../deliver/deliver.php");
        break;
    default:
        break;
}
