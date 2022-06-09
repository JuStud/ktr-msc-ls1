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
}