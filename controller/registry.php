<?php

include_once './view/registry.php';

require_once './model/Bdd.php';

$bdd = new Bdd();

if (isset($_POST['submitRegistry'])) {
    if (isset($_POST['name']) && isset($_POST['password'])) {
        $bdd->registration($_POST['name'], $_POST['password']);
    }
}