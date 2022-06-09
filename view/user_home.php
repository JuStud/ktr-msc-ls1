<?php

include_once './controller/user_home.php';
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
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div class="new_card_form">
    <div class="new_card_form_content">
        <nav class="form_nav">
            <h3>Create a new business card</h3>
            <a href="#" class="exit_form">
                <form>
                    <input type="submit" name="log_out" id="logout" class="material-symbols-outlined" value="cancel_presentation"/>
                </form>
            </a>
        </nav>
        <div class="form_and_data_list">
            <form method="POST" class="card_form">
                <input type="hidden" name="created_by" value="<?= $_SESSION['user']['name'] ?>"/>
                <label for="name"> Email address :
                    <input type="text" name="businessCardData[name]"/>
                </label>
                <label for="company_name"> Company name :
                    <input type="text" name="businessCardData[company_name]">
                </label>
                <label for="email"> Email address * :
                    <input type="email" name="businessCardData[email]" required>
                </label>
                <label for="telephone">Telephone number :
                    <input type="tel" name="businessCardData[telephone_number]">
                </label>
                <input type="submit" name='new_business_card' value="Validate new card">
            </form>
            <div>
                <h4>Yours data :</h4>
                <ul>
                    <li>Name : <?= $_SESSION['user']['name'] ?></li>
                    <li>Company : <?= $_SESSION['user']['company_name'] ?></li>
                    <li>Email : <?= $_SESSION['user']['email'] ?></li>
                    <li>Telephone number : <?= $_SESSION['user']['telephone_number'] ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
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
        <h2>Hello <?= $_SESSION['user']['name'] ?>, this is your personal library : </h2>
        <span>This is where all your business cards and those of other users you add are stored. You can add other on the card place <a
                    href="./libraryPlace.php">there</a>.</span>
    </div>
    <main>
        <form method="post">
            <nav class="own-lib-settings">
                <ul>
                    <li>
                        <a href="#" class="new_card">
                            <input type="submit" name="" id="logout" class="material-symbols-outlined" value="forms_add_on"/>
                        </a>
                    </li>
                    <li>
                        <input type="submit" name="removeFromLibrary" id="logout" class="material-symbols-outlined" value="delete"/>
                    </li>
                </ul>
            </nav>
            <ul class="library-list">
                <?= $bdd->loadLibraries($_SESSION['user']['id']) ?>
            </ul>
        </form>
    </main>
</div>
<script>
    $('.new_card').click(function (e) {
        e.preventDefault();

        $('.new_card_form').css('display', 'flex');
        $('.new_card_form').css('z-index', '1');
    })

    $('.exit_form').click(function () {
        $('.new_card_form').css('display', 'none');
    });

</script>
</body>
</html>
