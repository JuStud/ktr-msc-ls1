<?php

include_once './view/index.php';
require_once './model/Bdd.php';

$bdd = new Bdd();

if (isset($_POST['submitLoginForm'])) {
    if (isset($_POST['name']) && isset($_POST['password'])) {
        $bdd->login($_POST['name'], $_POST['password']);
    }
}