<?php

include_once "./app/config/database.php";

abstract class BaseModel
{
    /**
     * O nome da tabela no banco de dados.
     * Este valor DEVE ser sobrescrito em cada classe filha.
     * @var string
     */
    protected static $tableName = '';

    /**
     * O nome da chave primária da tabela.
     * Este valor DEVE ser sobrescrito em cada classe filha.
     * @var string
     */
    protected static $primaryKey = '';

    /**
     * Cria um novo registro no banco de dados.
     * @param array $data Um array associativo onde as chaves são os nomes das colunas.
     * @return bool Retorna true em caso de sucesso, false em caso de falha.
     */
    public static function create(array $data)
    {
        // Pega as chaves do array (nomes das colunas) e as formata para a query SQL.
        $columns = implode(', ', array_map(fn($col) => "`$col`", array_keys($data)));
        // Cria os placeholders para o bind (:coluna1, :coluna2, ...)
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO " . static::$tableName . " ($columns) VALUES ($placeholders)";

        $conn = Database::connection();
        $stmt = $conn->prepare($sql);

        // Associa cada valor do array ao seu respectivo placeholder.
        foreach ($data as $key => &$value) {
            $stmt->bindParam(':' . $key, $value);
        }

        return $stmt->execute();
    }

    /**
     * Retorna todos os registros da tabela.
     * @return array
     */
    public static function readAll()
    {
        $sql = "SELECT * FROM " . static::$tableName;
        $conn = Database::connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retorna um único registro baseado no ID.
     * @param int $id O ID do registro a ser buscado.
     * @return mixed
     */
    public static function readOne(int $id)
    {
        $sql = "SELECT * FROM " . static::$tableName . " WHERE `" . static::$primaryKey . "` = :id";
        $conn = Database::connection();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Atualiza um registro no banco de dados.
     * @param int $id O ID do registro a ser atualizado.
     * @param array $data Um array associativo com as colunas e novos valores.
     * @return bool
     */
    public static function update(int $id, array $data)
    {
        // Cria a parte SET da query (ex: `coluna1` = :coluna1, `coluna2` = :coluna2)
        $setClauses = [];
        foreach (array_keys($data) as $key) {
            $setClauses[] = "`$key` = :$key";
        }
        $setSql = implode(', ', $setClauses);

        $sql = "UPDATE " . static::$tableName . " SET " . $setSql . " WHERE `" . static::$primaryKey . "` = :id";

        $conn = Database::connection();
        $stmt = $conn->prepare($sql);

        // Associa o ID e os novos valores aos placeholders.
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        foreach ($data as $key => &$value) {
            $stmt->bindParam(':' . $key, $value);
        }

        return $stmt->execute();
    }

    /**
     * Deleta um registro do banco de dados.
     * @param int $id O ID do registro a ser deletado.
     * @return bool
     */
    public static function delete(int $id)
    {
        $sql = "DELETE FROM " . static::$tableName . " WHERE `" . static::$primaryKey . "` = :id";
        $conn = Database::connection();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
