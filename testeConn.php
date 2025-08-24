<?php

// Inclua o arquivo que contém a classe Database
// Adapte o caminho conforme a localização real do seu arquivo
require_once './app/config/database.php';

// Tente obter a conexão
// A classe já trata os erros, então o try/catch aqui é mais para a mensagem de sucesso
try {
    $conn = Database::connection();
    echo "Conexão com o banco de dados 'gerenciador_senai' estabelecida com sucesso!";

    // Você pode fazer uma consulta simples para ter certeza de que tudo está funcionando
    $stmt = $conn->query("SELECT 1");
    $result = $stmt->fetchColumn();

    if ($result == 1) {
        echo "<br>Consulta de teste executada com sucesso.";
    }
} catch (PDOException $e) {
    // Se a conexão falhar, o método getConnection já daria um "die()",
    // mas se o erro for em outro lugar (ex: na consulta), você pode capturá-lo aqui.
    echo "Falha na conexão ou na consulta: " . $e->getMessage();
}
