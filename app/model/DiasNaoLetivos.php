<?php
include_once "./app/config/database.php";

class DiasNaoLetivos
{
    public $id_dia_nao_letivo;
    public $data_dia_nao_letivo;
    public $descricao_dia_nao_letivo;
    public $tipo_feriado_dia_nao_letivo;

    public function __construct($id_dia_nao_letivo, $data_dia_nao_letivo, $descricao_dia_nao_letivo, $tipo_feriado_dia_nao_letivo)
    {
        $this->id_dia_nao_letivo = $id_dia_nao_letivo;
        $this->data_dia_nao_letivo = $data_dia_nao_letivo;
        $this->descricao_dia_nao_letivo = $descricao_dia_nao_letivo;
        $this->tipo_feriado_dia_nao_letivo = $tipo_feriado_dia_nao_letivo;
    }

    public static function CreateDiaNaoLetivo($dados)
    {
        $conn = Database::connection();
        $sql = "INSERT INTO `dias_nao_letivos`(`data_dia_nao_letivo`, `descricao_dia_nao_letivo`, `tipo_feriado_dia_nao_letivo`) VALUES (:data_dia_nao_letivo,:descricao_dia_nao_letivo,:tipo_feriado_dia_nao_letivo)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':data_dia_nao_letivo', $dados['data_dia_nao_letivo']);
        $stmt->bindParam(':descricao_dia_nao_letivo', $dados['descricao_dia_nao_letivo']);
        $stmt->bindParam(':tipo_feriado_dia_nao_letivo', $dados['tipo_feriado_dia_nao_letivo']);

        $stmt->execute();

        $novoId = $conn->lastInsertId();
        return new self($novoId, $dados['data_dia_nao_letivo'], $dados['descricao_dia_nao_letivo'], $dados['tipo_feriado_dia_nao_letivo']);
    }

    public static function ReadAllDiasNaoLetivos()
    {
        $conn = Database::connection();
        $sql = "SELECT * FROM `dias_nao_letivos`";
        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $ambientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ambientes;
    }
}
