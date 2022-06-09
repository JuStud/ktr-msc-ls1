<?php

include_once './controller/profile.php';

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home || User</title>
    <link rel="stylesheet" href='./view/css/profile_settings.css'>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
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
    <main>
        <h2>Your profile</h2>
        <form method="post" class="update-user">
            <ul>
                <li>
                    <label for="name"> Name : <?= $_SESSION['user']['name'] ?> </label>
                    <input name="data[name]" type="hidden" value="<?= $_SESSION['user']['name'] ?>"/>
                </li>
                <li>
                    <label for="company_name"> Company name :
                        <input name="data[company_name]" type="text" value="<?= $_SESSION['user']['company_name'] ?>"/>
                    </label>
                </li>
                <li>
                    <label for="email"> Email address :
                        <input name="data[email]" type="email" value="<?= $_SESSION['user']['email'] ?>"/>
                    </label>
                </li>
                <li>
                    <label for="telephone_number"> Telephone number :
                        <input name="data[telephone_number]" type="tel"
                               value="<?= $_SESSION['user']['telephone_number'] ?>"/>
                    </label>
                </li>
                <li>
                    <input type="submit" name="update_user" value="Update information"/>
                </li>
            </ul>
        </form>
    </main>
</div>
</body>
</html>
