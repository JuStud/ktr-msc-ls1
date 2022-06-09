<?php

class Bdd
{
    private string $host_name = 'localhost';
    private string $database = 'ktr-ls1';
    private string $user_name = 'root'; // put here your MYSQL Username
    private string $pass_word = 'root'; // put here your MYSQL Password
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
}