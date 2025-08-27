<?php

include_once "./app/model/BaseModel.php";

class StatusTurmas extends BaseModel
{
    protected static $tableName = 'status_turmas';
    protected static $primaryKey = 'id_status_turma';

    public $id_status_turma;
    public $nome_status_turma;

    public function __construct($id_status_turma, $nome_status_turma)
    {
        $this->id_status_turma = $id_status_turma;
        $this->nome_status_turma = $nome_status_turma;
    }
}
