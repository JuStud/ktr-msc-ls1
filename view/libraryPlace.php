<?php

include_once './controller/libraryPlace.php';
require_once './model/Bdd.php';

$bdd = new Bdd();

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home || User</title>
    <link rel="stylesheet" href='./view/css/user_home.css'>
    <link rel="stylesheet" href='./view/css/library.css'>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<nav class="header-nav">
    <ul class="navbar">
        <li><a href="./user_home.php" class="material-symbols-outlined">home_app_logo</a></li>
        <li><a href="./profile.php" class="material-symbols-outlined">
                settings</a></li>
        <li><a href="./libraryPlace.php" class="material-symbols-outlined">library_books</a></li>
        <li>
            <form method="post">
                <input type="submit" name="log_out" id="logout" class="material-symbols-outlined" value="logout"/>
            </form>
        </li>
    </ul>
</nav>
<div class="content">
    <div class="library-detail">
        <h2>The library place :</h2>
        <span>This is where all your will find all users personal business card, you can add them to your personnal library by select their and click on add button. See who will be you new contact!</span>
    </div>
    <main>
        <form method="post">
            <nav class="own-lib-settings">
                <ul>
                    <li>
                        <input type="submit" name="addToUserLib" id="logout" class="material-symbols-outlined" value="post_add"/>
                    </li>
                </ul>
            </nav>
            <ul class="library-list">
                <?= $bdd->loadLibraries($_SESSION['user']['id'], false) ?>
            </ul>
        </form>
    </main>
</div>
</body>
</html>
