<?php

include_once "./app/model/BaseModel.php";

class DiasNaoLetivos extends BaseModel
{
    protected static $tableName = 'dias_nao_letivos';
    protected static $primaryKey = 'id_dia_nao_letivo';

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
}
