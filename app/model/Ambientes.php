<?php

include_once "./app/config/database.php";

class Ambientes
{
    public $id_ambiente;
    public $nome_ambiente;
    public $num_ambiente;
    public $capacidade_ambiente;
    public $status_ambiente;

    public function __construct($id_ambiente, $nome_ambiente, $num_ambiente, $capacidade_ambiente, $status_ambiente)
    {
        $this->id_ambiente = $id_ambiente;
        $this->nome_ambiente = $nome_ambiente;
        $this->num_ambiente = $num_ambiente;
        $this->capacidade_ambiente = $capacidade_ambiente;
        $this->status_ambiente = $status_ambiente;
    }

    public static function CreateAmbiente($dados)
    {
        $conn = Database::connection();
        $sql = "INSERT INTO ambientes(nome_ambiente, num_ambiente, capacidade_ambiente, status_ambiente) VALUES (:nome_ambiente,:num_ambiente,:capacidade_ambiente,:status_ambiente)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':nome_ambiente', $dados['nome_ambiente']);
        $stmt->bindParam(':num_ambiente', $dados['num_ambiente']);
        $stmt->bindParam(':capacidade_ambiente', $dados['capacidade_ambiente']);
        $stmt->bindParam(':status_ambiente', $dados['status_ambiente']);

        $stmt->execute();

        $novoId = $conn->lastInsertId();
        return new self($novoId, $dados['nome_ambiente'], $dados['num_ambiente'], $dados['capacidade_ambiente'], $dados['status_ambiente']);
    }

    public static function ReadAllAmbientes()
    {
        $conn = Database::connection();
        $sql = "SELECT * FROM ambientes";
        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $ambientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ambientes;
    }
}
