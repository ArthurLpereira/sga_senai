<?php
include_once "./app/model/BaseModel.php";

class TiposColaboradores extends BaseModel
{

    protected static $tableName = 'tipos_colaboradores';
    protected static $primaryKey = 'id_tipo_colaborador';

    public $id_tipo_colaborador;
    public $nome_tipo_colaborador;

    public function __construct($id_tipo_colaborador, $nome_tipo_colaborador)
    {
        $this->id_tipo_colaborador = $id_tipo_colaborador;
        $this->nome_tipo_colaborador = $nome_tipo_colaborador;
    }
}
