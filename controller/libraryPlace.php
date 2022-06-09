<?php

include_once './utils/header.php';
include_once './view/libraryPlace.php';
require_once './model/Bdd.php';

$bdd = new Bdd();

if (isset($_POST['addToUserLib'])) {
    if (isset($_POST['id'])) {
        $bdd->addToUserLibrary($_POST['id']);
    }
}