<?php

include_once "./app/config/database.php";

class TiposColaboradores
{
    public $id_tipo_colaborador;
    public $nome_tipo_colaborador;

    public function __construct($id_tipo_colaborador, $nome_tipo_colaborador)
    {
        $this->id_tipo_colaborador = $id_tipo_colaborador;
        $this->nome_tipo_colaborador = $nome_tipo_colaborador;
    }

    public static function CreateTipoColaborador($dados)
    {
        $conn = Database::connection();
        $sql = "INSERT INTO `tipos_colaboradores` (`nome_tipo_colaborador`) VALUES (:nome_tipo_colaborador)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':nome_tipo_colaborador', $dados['nome_tipo_colaborador']);

        $stmt->execute();

        $novoId = $conn->lastInsertId();
        return new self($novoId, $dados['nome_tipo_colaborador']);
    }

    public static function ReadAllTipoColaborador()
    {
        $conn = Database::connection();
        $sql = "SELECT * FROM `tipos_colaboradores`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $TipoColaboradores = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $TipoColaboradores;
    }

    public static function ReadOneTipoColaborador($id_tipo_colaborador)
    {
        $conn = Database::connection();
        $sql = "SELECT * FROM `tipos_colaboradores` WHERE `id_tipo_colaborador` = :id_tipo_colaborador";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id_tipo_colaborador', $id_tipo_colaborador, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function UpdateTipoColaborador($id_tipo_colaborador, $dados)
    {
        $conn = Database::connection();
        $sql = "UPDATE `tipos_colaboradores` SET `nome_tipo_colaborador`= :nome_tipo_colaborador WHERE id_tipo_colaborador = :id_tipo_colaborador";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id_tipo_colaborador', $id_tipo_colaborador, PDO::PARAM_INT);
        $stmt->bindParam(':nome_tipo_colaborador', $dados['nome_tipo_colaborador']);

        return $stmt->execute();
    }

    public static function DeleteTipoColaborador($id_tipo_colaborador)
    {
        $conn = Database::connection();
        $sql = "DELETE FROM `tipos_colaboradores` WHERE `id_tipo_colaborador` = :id_tipo_colaborador";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_tipo_colaborador', $id_tipo_colaborador, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
