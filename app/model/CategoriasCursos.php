<?php

include_once "./app/model/BaseModel.php";

class CategoriasCursos extends BaseModel
{
    protected static $tableName = 'categorias_cursos';
    protected static $primaryKey = 'id_categoria_curso';

    public $id_categoria_curso;
    public $nome_categoria_curso;

    public function __construct($id_categoria_curso, $nome_categoria_curso)
    {
        $this->id_categoria_curso = $id_categoria_curso;
        $this->nome_categoria_curso = $nome_categoria_curso;
    }
}
