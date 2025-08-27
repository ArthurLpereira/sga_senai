<?php

include_once "./app/model/BaseModel.php";

class Ambientes extends BaseModel
{
    // 1. Definir o nome da tabela e da chave primária
    protected static $tableName = 'ambientes';
    protected static $primaryKey = 'id_ambiente';

    // 2. Manter as propriedades e o construtor (se necessário)
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
}
