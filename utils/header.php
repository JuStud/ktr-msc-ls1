<?php

require_once './model/Bdd.php';

$bdd = new Bdd();

if (!isset($_SESSION['user'])) {
    header('Location: ./index.php');
    die();
}


if (isset($_POST['log_out'])) {
    $bdd->logOut();
}
