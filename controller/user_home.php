<?php

include_once './utils/header.php';
include_once './view/user_home.php';
require_once './model/Bdd.php';

$bdd = new Bdd();

if (isset($_POST['new_business_card'])) {
    if (isset($_POST['businessCardData'])) {
        $bdd->newBusinessCard($_POST['businessCardData']);
    }
}

if (isset($_POST['removeFromLibrary'])) {
    if (isset($_POST['id'])) {
        $bdd->removeFromLib($_POST['id']);
    }
}