<?php

include_once './utils/header.php';
include_once './view/profile.php';
require_once './model/Bdd.php';

$bdd = new Bdd();

if (isset($_POST['update_user'])) {
    if (isset($_POST['data'])) {
        $bdd->updateUser($_POST['data']);
    }
}
