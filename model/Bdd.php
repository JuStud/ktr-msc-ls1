<?php

class Bdd
{
    private string $host_name = 'localhost';
    private string $database = 'ktr-msc-ls1';
    private string $user_name = 'root';
    private string $pass_word = 'root';
    private PDO $dbh;

    public function __construct()
    {
        try {
            $this->dbh = new PDO("mysql:dbname={$this->database};host={$this->host_name};charset=utf8", $this->user_name, $this->pass_word);
        } catch (PDOException $e) {
            echo 'Failed to connect to bdd : ' . $e->getMessage();
            exit();
        }
    }

    /**
     * @param $data
     * @return string
     */
    public function dataCleaner($data): string
    {
        // Function use to prevent SQL inject
        $data = trim($data);
        $data = stripslashes($data);

        return htmlspecialchars($data);
    }

    /**
     * @param string $name
     * @param string $password
     * @return void
     */
    public function registration(string $name, string $password): void
    {
        // Clear data and hash pswd
        $username = $this->dataCleaner($name);
        $username = strtolower($username);
        $password = $this->dataCleaner($password);
        $passwd_hash = password_hash($password, PASSWORD_BCRYPT);

        $nameIsAlreadyExisting = $this->dbh->prepare('select id from user where name=?');
        $nameIsAlreadyExisting->execute([$name]);
        if (count($nameIsAlreadyExisting->fetchAll()) == 0) {
            // Insert
            $res = $this->dbh->prepare('insert into user(name, password) values (?,?)');

            $res->execute(array(
                $username,
                $passwd_hash,
            ));
        } else {
            exit("<h2 style='color : black; text-align : center;font-style: normal'>Name already existing");
        }
        echo '<meta http-equiv="refresh" content="1; url=./index.php">';
    }

    /**
     * @param string $name
     * @param string $password
     * @return void
     */
    public function login(string $name, string $password): void
    {
        $name = $this->dataCleaner($name);
        $password = $this->dataCleaner($password);
        // Select
        $res = $this->dbh->prepare('select * from user where name = ?');
        $res->execute([$name]);
        $lines = $res->fetch();
        if ($lines) { // If exist 1 row
            if (password_verify($password, $lines['password'])) { // If the password correspond with the db hash
                $_SESSION['user'] = array(
                    'id' => $lines['id'],
                    'name' => $lines['name'],
                    'email' => $lines['email'],
                    'company_name' => $lines['company_name'],
                    'telephone_number' => $lines['telephone_number'],
                );

                echo '<meta http-equiv="refresh" content="1; url=./user_home.php">';
            } else {
                exit("<h2 style='color : red; text-align : center;'>Error while login, please verify your informations");
            }
        } else {
            exit("<h2 style='color : red; text-align : center;'>Error while login, please verify your informations");
        }
    }

    /**
     * @return void
     */
    public function logOut(): void
    {
        session_unset();
        session_destroy();
        header('Location: ./index.php');
        die();
    }

    public function updateUser(array $data): void
    {
        $name = $this->dataCleaner($data['name']);

        if (sizeof($data) > 0) {
            foreach ($data as $key => $value) {
                if ($key == 'name') {
                    continue;
                }

                if (isset($value)) {
                    $currentData = $this->dataCleaner($value);
                    $request = 'UPDATE user SET ';

                    switch ($key) {
                        case 'company_name':
                            $request .= 'company_name = ? where name = ?';
                            break;
                        case 'email':
                            $request .= 'email = ? where name = ?';
                            break;
                        case 'telephone_number':
                            $request .= 'telephone_number = ? where name = ?';
                            break;
                    }

                    $res = $this->dbh->prepare($request);

                    if ($res->execute([$currentData, $name])) {
                        $_SESSION['user'][$key] = $currentData;
                    }
                }
            }
        }

        echo '<meta http-equiv="refresh" content="1; url=user_home.php">';
    }

    /**
     * @param int $id
     * @param bool $personalLibrary
     * @return void
     */
    public function loadLibraries(int $id, bool $personalLibrary = true): void
    {
        switch ($personalLibrary) {
            case true:
                $res = $this->dbh->prepare('select b.* from library l join business_card b on l.business_card_id = b.id join user u on l.user_id = u.id where u.id = ?');
                $res->execute([$id]);
                break;
            case false:
                $res = $this->dbh->prepare('SELECT b.* FROM business_card b inner join user u on b.user_id != u.id where u.id = ? and b.id not in (SELECT l.business_card_id from library l where l.user_id = ?);');
                $res->execute([$id, $id]);
                break;
        }


        $lines = $res->fetchAll();

        foreach ($lines as $line) {
            echo "<li class='element-library'>";
            echo "<input type='checkbox' name='id[]' value='" . $line['id'] . "'/>";
            echo "<div class='card_data'>
                       <div>
                            <h5 class='card_name'>Hello my name is " . $line['name'] . "</h5>
                       </div>
                       <ul class='card_list_data'>
                            <li>Working for : " . $line['company_name'] . "</li>
                            <li>Call me at : " . $line['telephone_number'] . "</li>
                            <li>Or contact me at : " . $line['email'] . "</li>
                       </ul>
                   </div>";
            echo "</li>";
        }
    }

    /**
     * @param array $idToRemove
     * @return void
     */
    public function removeFromLib(array $idToRemove): void
    {
        $res = $this->dbh->prepare('delete from library where business_card_id = ?');

        foreach ($idToRemove as $item) {
            $res->execute([$item]);
        }

        echo '<meta http-equiv="refresh" content="1; url=user_home.php">';
    }

    /**
     * @param array $cardData
     * @return void
     */
    public function newBusinessCard(array $cardData): void
    {
        foreach ($cardData as $key => $cardDatum) {
            if ($cardDatum == '') {
                $cardData[$key] = Null;
                continue;
            }

            $cardDatum = $this->dataCleaner($cardDatum);
        }

        // Insert into business_card the new card
        $res = $this->dbh->prepare('insert into business_card(user_id, name, company_name, email, telephone_number)
                    values (?, ?, ?, ?, ?)');

        $res->execute([
            $_SESSION['user']['id'],
            $cardData['name'],
            $cardData['company_name'],
            $cardData['email'],
            $cardData['telephone_number']
        ]);

        // Insert into the join table data to find card after
        $newRequest = $this->dbh->prepare('insert into library(user_id, business_card_id) values (?,?)');
        $newRequest->execute([
            $_SESSION['user']['id'],
            $this->dbh->lastInsertId()
        ]);

        echo '<meta http-equiv="refresh" content="1; url=user_home.php">';
    }

    /**
     * @param array $idToAdd
     * @return void
     */
    public function addToUserLibrary(array $idToAdd): void
    {
        $request = $this->dbh->prepare('insert into library(user_id, business_card_id) values(?,?)');
        foreach ($idToAdd as $item) {
            $request->execute([
                $_SESSION['user']['id'],
                $item
            ]);
        }

        echo '<meta http-equiv="refresh" content="1; url=libraryPlace.php">';
    }
}
