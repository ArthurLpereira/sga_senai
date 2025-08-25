<?php

include_once "./app/config/database.php";

class CategoriasCursos
{
    public $id_categoria_curso;
    public $nome_categoria_curso;

    public function __construct($id_categoria_curso, $nome_categoria_curso)
    {
        $this->id_categoria_curso = $id_categoria_curso;
        $this->nome_categoria_curso = $nome_categoria_curso;
    }

    public static function CreateTipoCurso($dados)
    {
        $conn = Database::connection();
        $sql =  "INSERT INTO `categorias_cursos`(`nome_categoria_curso`) VALUES (:nome_categoria_curso)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':nome_categoria_curso', $dados['nome_categoria_curso']);
        $stmt->execute();

        $novoId = $conn->lastInsertId();
        return new self($novoId, $dados['nome_categoria_curso']);
    }

    public static function ReadAllTiposCursos()
    {
        $conn = Database::connection();
        $sql = "SELECT * FROM `categorias_cursos`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $TiposCursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $TiposCursos;
    }

    public static function ReadOneTipoCurso($id_categoria_curso)
    {
        $conn = Database::connection();
        $sql = "SELECT * FROM `categorias_cursos` WHERE `id_categoria_curso` = :id_categorias_curso";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_categorias_curso', $id_categoria_curso, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function UpdateTipoCurso($id_categoria_curso, $dados)
    {
        $conn = Database::connection();
        $sql = "UPDATE `categorias_cursos` SET `nome_categoria_curso`= :nome_categoria_curso WHERE `id_categoria_curso`= :id_categoria_curso";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id_categoria_curso', $id_categoria_curso, PDO::PARAM_INT);
        $stmt->bindParam(':nome_categoria_curso', $dados['nome_categoria_curso']);

        return $stmt->execute();
    }

    public static  function DeleteAmbiente($id_categoria_curso)
    {
        $conn = Database::connection();
        $sql = "DELETE FROM `categorias_cursos` WHERE `id_categoria_curso` = :id_categoria_curso";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id_categoria_curso', $id_categoria_curso, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
