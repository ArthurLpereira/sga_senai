<?php
class Database
{
    public static $conn;

    public static function connection()
    {
        if (!self::$conn) {
            try {
                $host = 'localhost';
                $db_name = 'gerenciador_senai';
                $password = '';
                $username = 'root';

                self::$conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro na conexão" . $e->getMessage());
            }
        }

        return self::$conn;
    }
}
